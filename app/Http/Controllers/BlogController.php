<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Classroom;
use App\Http\Classes\Functions;
use App\Posts;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function store($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'name' => ['string', 'required'],
            ]);

        if(request()->student) {
            $student = Student::find(request()->student);
            $this->authorize('update', $class);
            if($student->classroom->classroom_id != $class->id)
                abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        return Blog::create([
            'name' => $data['name'],
            'student_id' => $student->id,
        ]);
    }

    public function destroy($code, $id)
    {
        $blog = Blog::find($id);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        
        $student = Functions::getCurrentStudent($class, []);
        
        if($student->id != $blog->student_id)
            abort(403);

        $blog->delete();
        return $student->blogs;
    }

    public function destroyPost($code, $id)
    {
        $post = Posts::find($id);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        
        $student = Functions::getCurrentStudent($class, []);
        
        if($student->id != $post->blog->student_id)
            abort(403);

        $post->delete();
    }

    public function editPost($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'id' => ['numeric', 'required'],
            'title' => ['string', 'required'],
            'content' => ['string', 'required'],
        ]);

        if(request()->student) {
            $student = Student::find(request()->student);
            $this->authorize('update', $class);
            if($student->classroom->classroom_id != $class->id)
                abort(403);
            $name = auth()->user()->name;
        } else {
            $student = Functions::getCurrentStudent($class, []);
            $name = $student->name;
        }
        $post = Posts::find($data['id']);
        if ($post->blog->student_id != $student->id)
            abort(403);


        $post->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'last_edit' => $name,
        ]);        
        $post->touch();

    }
    public function storePost($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'blog' => ['numeric', 'required'],
            'title' => ['string', 'required'],
            'content' => ['string', 'required'],
            'is_teacher' => ['nullable'],
        ]);

        if(request()->student) {
            $student = Student::find(request()->student);
            $this->authorize('update', $class);
            if($student->classroom->classroom_id != $class->id)
                abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        $blog = Blog::find($data['blog']);
        if ($blog->student_id != $student->id)
            abort(403);

        $from['title'] = __("notifications.post") . $blog->name;
        
        if(!$data['is_teacher']) {
            $from['datetime'] = Carbon::now();
            $from['name'] = $student->name;
            $from['username'] = $student->username;
    
            NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.post", $data['title'] , $from, "post", $student->id);
        } else {
            $student->classroom->user->sendMessage($from['title'], $class->code, "post");
            // NotificationController::sendToTeachers(auth()->user()->id, $class->code, "notifications.post", $data['title'] , $from, "post", $student->id);

        }


        return Posts::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'blog_id' => $blog->id,
            'date' => Carbon::now(),
            'is_teacher' => $data['is_teacher'],
        ]);
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            'blog' => ['numeric', 'required'],
        ]);

        if(request()->student) {
            $student = Student::find(request()->student);
            $this->authorize('update', $class);
            if($student->classroom->classroom_id != $class->id)
                abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        $blog = Blog::where('id', '=', $data['blog'])->where('student_id', $student->id)->firstOrFail();
        return $blog->posts()->orderByDesc('id')->get();
    }
}
