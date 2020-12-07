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
        $student = Functions::getCurrentStudent($class, []);

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

    public function storePost($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);
        $data = request()->validate([
            'blog' => ['numeric', 'required'],
            'title' => ['string', 'required'],
            'content' => ['string', 'required'],
        ]);

        $student = Functions::getCurrentStudent($class, []);
        $blog = Blog::find($data['blog']);
        if ($blog->student_id != $student->id)
            abort(403);

        return Posts::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'blog_id' => $blog->id,
            'date' => Carbon::now('Europe/Madrid'),
        ]);
    }

    public function index($code)
    {
        $class = Classroom::where('code', '=', $code)->firstOrFail();
        $this->authorize('studyOrTeach', $class);

        $data = request()->validate([
            'blog' => ['numeric', 'required'],
        ]);

        $student = Functions::getCurrentStudent($class, []);

        $blog = Blog::where('id', '=', $data['blog'])->where('student_id', $student->id)->firstOrFail();
        return $blog->posts()->orderByDesc('id')->get();
    }
}
