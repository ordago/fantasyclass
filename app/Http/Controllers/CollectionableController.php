<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Collection;
use App\Collectionable;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CollectionableController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function destroy($id)
    {
        $collectionable = Collectionable::findOrFail($id);
        $class = Classroom::findOrFail($collectionable->collection->classroom_id);
        $this->authorize('update', $class);
        try {
            $collectionable->delete();
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
            'name' => ['string', 'required'],
            'type' => ['numeric', 'required'],
            'id' => ['numeric', 'required'],
        ]);
        $collectionable = Collectionable::findOrFail($data['id']);
        if($collectionable->collection->classroom_id != $class->id)
            abort(403);
        $collectionable->update($data);

        $collectionable->addMedia(request()->file('image'))
            ->toMediaCollection('collectionable');
        
        $collection = Collection::findOrFail($collectionable->collection->id);
        $collection->load('collectionables');
        return $collection;

    }

    public function store($code)
    {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('update', $class);

        $data = request()->validate([
            'name' => ['string', 'required'],
            'type' => ['numeric', 'required'],
            'collection_id' => ['numeric', 'required'],
        ]);

        $collection = Collection::find($data['collection_id']);
        if ($collection->classroom_id != $class->id)
            abort(403);

        $collectionable = Collectionable::create($data);

        $collectionable->addMedia(request()->file('image'))
            ->toMediaCollection('collectionable');

        $collection = $collection->fresh();
        $collection->load('collectionables');
        return $collection;
    }
}
