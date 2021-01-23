<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Document;
use App\DocumentCategory;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function index($code)
    {
        $data = request()->validate([
            'id' => ['numeric'],
        ]);
        $group = DocumentCategory::findOrFail($data['id']);
        $class = Classroom::where('id', '=', $group->classroom_id)->first();
        $this->authorize('view', $class);

        $documents = Document::where('document_category_id', $group->id)->orderBy('order')->get();

        return $documents;
    }

    public function updateProp($code)
    {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);
        $document = Document::find(request()->id);
        if ($document->category->classroom_id != $class->id || request()->prop == 'document_category_id')
            abort(403);
        $document->update([
            request()->prop => request()->value,
        ]);
    }
    
    public function update($code) {
        
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);
        $document = Document::findOrFail(request()->document['id']);
        if ($document->category->classroom_id != $class->id || request()->prop == 'document_category_id')
            abort(403);

        $data = request()->validate([
            'document.name' => ['string', 'nullable'],
            'document.description' => ['string', 'nullable'],
            'document.url' => ['string', 'nullable'],
            'document.text' => ['string', 'nullable'],
        ]);

        $document->update($data['document']);
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        $class = Classroom::find($document->category->classroom_id);
        $this->authorize('update', $class);

        if($document->type == 2 && $document->url) {
            foreach ($class->getMedia('documents') as $doc) {
                if($doc->getUrl() == $document->url) {
                    $doc->delete();
                }
            }
        }
        return $document->delete();
    }

    public function order($code)
    {
        $class = Classroom::where('code', '=', $code)->first();
        $this->authorize('update', $class);

        $i = 0;
        foreach (request()->documents as $document) {
            $doc = Document::find($document['id']);
            $doc->update(['order' => $i]);
            $i++;
        }
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstorFail();
        $this->authorize('update', $class);

        request()->merge(['document' => json_decode(request()->document)]);
        $data = request()->validate([
            'document.name' => ['string', 'nullable'],
            'document.description' => ['string', 'nullable'],
            'document.type' => ['numeric', 'nullable'],
            'document.type_document' => ['string', 'nullable'],
            'document.url' => ['string', 'nullable'],
            'document.size' => ['numeric', 'nullable'],
            'document.text' => ['string', 'nullable'],
            'document.document_category_id' => ['numeric', 'nullable'],
            'document.order' => ['numeric', 'nullable'],
            'document.indentation' => ['numeric', 'nullable'],
            'document.visible' => ['numeric', 'nullable'],
            'file' => ['mimes:pdf,doc,ppt,xls,docx,pptx,xlsx,gif,jpeg,jpg,png,svg,zip,rar,odt,mp4,avi,odp,ods,mpeg,txt,mpga,mp3', 'nullable', 'max:10000'],
        ]);

        $data['document']['uploader'] = auth()->user()->id;

        $cat = DocumentCategory::find($data['document']['document_category_id']);
        if ($cat->classroom_id != $class->id) {
            abort(403);
        }

        if (request()->file) {
            $size = request()->file('file')->getSize() / 1000000;
            if (auth()->user()->files + $size > auth()->user()->quota) {
                return [
                    "message" => __('success_error.quota_exceded'),
                    "type" => "times",
                    "type" => "error"
                ];
            }
        }

        $doc = Document::create($data['document']);

        try {
        if (request()->file && $data['document']['type'] == 2) {
            $mime = request()->file('file')->getMimeType();
            $media = $class->addMedia(request()->file('file'))
                ->toMediaCollection('documents');
            $doc->update(['url' => $media->getUrl(), 'type_document' => $mime, 'size' => $size]);
        }
        } catch (\Throwable $th) {
            return [
                "message" => __('success_error.error'),
                "type" => "times",
                "type" => "error"
            ];
        }
        return [
            "message" => __('success_error.add_success'),
            "type" => "success",
            "icon" => "check"
        ];
    }
}
