<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Challenge;
use App\Classroom;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store() {
        
        $data = request()->validate([
            'attachment.challenge_id' => ['numeric', 'required'],
            'attachment.type' => ['numeric', 'required'],
            'attachment.name' => ['string', 'nullable'],
            'attachment.url' => ['url', 'required'],
            'attachment.mode' => ['numeric', 'required'],
        ]);
        
        $class = Classroom::findOrFail(Challenge::find($data['attachment']['challenge_id'])->group->classroom_id);

        $this->authorize('update', $class);
        
        return Attachment::create($data['attachment']);

    }
    
    public function destroy($id) {
    
        $attachment = Attachment::findOrFail($id);
        $class = Classroom::find($attachment->challenge->group->classroom_id);
        $this->authorize('update', $class);

        return $attachment->delete();
    }
    
}
