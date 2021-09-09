<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Collection;
use App\Collectionable;
use App\CollectionableShared;
use App\CollectionGroup;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        settings()->setExtraColumns(['classroom_id' => $class->id]);
        $settings['buy_collectionable'] = settings()->get('buy_collectionable', 0);
        $settings['buy_collectionable_count'] = settings()->get('buy_collectionable_count', 3);
        $settings['buy_collectionable_gold_pack'] = settings()->get('buy_collectionable_gold_pack', 200);

        $collections = $class->collections()->with('collectionables')->get();

        return view('collections.index', compact('class', 'collections', 'settings'));
    }
    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'collection.name' => ['string', 'required'],
            'collection.xp' => ['numeric', 'required'],
            'collection.gold' => ['numeric', 'required'],
        ]);

        $data['collection']['classroom_id'] = $class->id;
        Collection::create($data['collection']);

        return $class->fresh()->collections()->with('collectionables')->get();
    }

    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);
        $class = Classroom::findOrFail($collection->classroom_id);
        $this->authorize('update', $class);
        try {
            foreach ($collection->collectionables as $colecctionable) {
                $colecctionable->delete();
            }
            $collection->delete();
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
        return 1;
    }

    public function update($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'collection.name' => ['string', 'required'],
            'collection.xp' => ['numeric', 'required'],
            'collection.gold' => ['numeric', 'required'],
            'collection.id' => ['numeric', 'required'],
            'collection.max' => ['numeric', 'required'],
        ]);
        $collection = collection::findOrFail($data['collection']['id']);
        if ($collection->classroom_id != $class->id)
            abort(403);
        $collection->update($data['collection']);

        return $class->fresh()->collections()->with('collectionables')->get();
    }

    public function importCollection()
    {
        $data = request()->validate([
            'code' => ['string', 'required'],
            'id' => ['numeric', 'required'],
        ]);
        $class = Classroom::where('code', $data['code'])->firstOrFail();
        $this->authorize('update', $class);
        $collectiong = CollectionGroup::where('id', $data['id'])->with('collectionables')->firstOrFail();
        $collection = Collection::create([
            'name' => $collectiong->name,
            'xp' => $collectiong->xp,
            'gold' => $collectiong->gold,
            'classroom_id' => $class->id,
        ]);
        foreach ($collectiong->collectionables as $collectionable) {
            $newCollectionable = Collectionable::create([
                'name' => $collectionable->name,
                'description' => $collectionable->description,
                'type' => $collectionable->type,
                'collection_id' => $collection->id,
            ]);
            $collectionable->media->each(function (Media $media) use ($newCollectionable) {
                $props = $media->toArray();
                unset($props['uuid']);
                unset($props['id']);
                $props['collection_name'] = 'collectionable';
                $newCollectionable->addMedia($media->getPath())
                    ->preservingOriginal()
                    ->withProperties($props)
                    ->toMediaCollection($media->collection_name);
            });
        }
    }

    public function getSharedCollections()
    {
        $collection = CollectionGroup::all();
        $collection->each->load('collectionables');
        return $collection;
    }

    public function share()
    {
        $data = request()->validate([
            'code' => ['required', 'string'],
            'id' => ['required', 'numeric'],
        ]);

        $class = Classroom::where('code', '=', $data['code'])->firstOrFail();
        $this->authorize('update', $class);

        $collection = Collection::where('id', '=', $data['id'])->where('classroom_id', $class->id)->firstOrFail();

        $collecitongroup = CollectionGroup::create([
            'name' => $collection->name,
            'xp' => $collection->xp,
            'gold' => $collection->gold,
        ]);

        foreach ($collection->collectionables as $collectionable) {
            $newCollectionable = CollectionableShared::create([
                'name' => $collectionable->name,
                'description' => $collectionable->description,
                'type' => $collectionable->type,
                'description' => $collectionable->description,
                'collection_group_id' => $collecitongroup->id,
            ]);

            $collectionable->media->each(function (Media $media) use ($newCollectionable) {
                $props = $media->toArray();
                unset($props['uuid']);
                unset($props['id']);
                $newCollectionable->addMedia($media->getPath())
                    ->preservingOriginal()
                    ->withProperties($props)
                    ->toMediaCollection($media->collection_name);
            });
        }

        // Mail::to(env('EMAIL'))->send(new NewLevelsNotification());
    }
}
