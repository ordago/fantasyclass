<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code) {
        $class = Classroom::where('code', $code)->firstOrFail();
        $this->authorize('view', $class);

        $collections = $class->collections()->with('collectionables')->get();

        return view('collections.index', compact('class', 'collections'));
    }
    public function store($code) {
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
        ]);
        $collection = collection::findOrFail($data['collection']['id']);
        if($collection->classroom_id != $class->id)
            abort(403);
        $collection->update($data['collection']);
        
        return $class->fresh()->collections()->with('collectionables')->get();

    }
}
