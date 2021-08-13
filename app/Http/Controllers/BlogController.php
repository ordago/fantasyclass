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
            'public' => ['numeric', 'nullable'],
            'type' => ['numeric', 'nullable'],
            ]);
        $studentId = $classId = null;
        if(!isset($data['public']) || $data['public'] != 2) {
            if(request()->student) {
                $student = Student::find(request()->student);
                $this->authorize('update', $class);
                if($student->classroom->classroom_id != $class->id)
                    abort(403);
            } else {
                $student = Functions::getCurrentStudent($class, []);
            }
            $studentId = $student->id;
        } else {
            $classId = $class->id;
        }

        return Blog::create([
            'name' => $data['name'],
            'student_id' => $studentId,
            'classroom_id' => $classId,
            'public' => isset($data['public']) ? $data['public'] : $data['type'],
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
        $student->fresh();
        $student->load('blogs');
        if($student->groups->first())
            $student->groups->first()->append('blogs');
        return $student;
    }
    public function destroyPublic($code, $id)
    {
        $blog = Blog::find($id);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('update', $class);
        
        $blog->delete();
        return $class->fresh()->blogs;
    }

    public function destroyPost($code, $id)
    {
        $post = Posts::find($id);
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        
        $student = Functions::getCurrentStudent($class, []);
        
        if($post->blog->public == 0) {
            if($student->id != $post->blog->student_id)
            abort(403);
        } else {
            if(!auth()->user()->classrooms->where('id', $class->id)->where('pivot.role', '>', 0)->first() ? true : false && $post->student_id) {
                if($post->student_id != $student->id)
                    abort(403);
            }
        }
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
        $post = Posts::find($data['id']);

        if(request()->student) {
            $student = Student::find(request()->student);
            $this->authorize('update', $class);
            if($student->classroom->classroom_id != $class->id)
                abort(403);
            $name = auth()->user()->name;
        } else {
            $student = Functions::getCurrentStudent($class, []);
            $name = $student->name;
            if($post->blog->public == 2) {
                if($post->student_id != $student->id) {
                    abort(403);
                }
            } else if($post->blog->public == 1) {
                $group = Student::find($post->blog->student_id)->groups()->first();
                if($student->groups()->first()->id != $group->id)
                    abort(403);
            }else if ($post->blog->student_id != $student->id)
                abort(403);
        }


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
            'student_id' => ['numeric', 'nullable'],
        ]);
        
        $blog = Blog::find($data['blog']);
        
        if(request()->student) {
            $student = Student::find(request()->student);
            $this->authorize('update', $class);
            if($student->classroom->classroom_id != $class->id)
            abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        if($blog->public == 1) {
            $group = Student::find($blog->student_id)->groups()->first();
            if($student->groups()->first()->id != $group->id)
                abort(403);
        } else {
            if($blog->classroom_id && $blog->classroom_id != $class->id)
                abort(403);
            else if (!$blog->classroom_id && $blog->student_id != $student->id)
                abort(403);
        }

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
            'student_id' => (!isset($data['is_teacher']) || $data['is_teacher'] != 1) ? $student->id : null,
        ]);
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            'blog' => ['numeric', 'required'],
        ]);
        $blog = Blog::where('id', '=', $data['blog'])->firstOrFail();
        if($blog->public == 2) {
            if($blog->classroom_id != $class->id)
                abort(403);
            return $blog->posts()->orderByDesc('id')->get();
        }

        if(request()->student) {
            $student = Student::find(request()->student);
            $this->authorize('update', $class);
            if($student->classroom->classroom_id != $class->id)
                abort(403);
        } else {
            $student = Functions::getCurrentStudent($class, []);
        }

        if($blog->public == 0) {
            if($blog->student_id != $student->id)
                abort(403);
        }
        else {
            $group = Student::find($blog->student_id)->groups()->first();
            if($student->groups()->first()->id != $group->id)
                abort(403);
        }
        return $blog->posts()->orderByDesc('id')->get();
    }
}
