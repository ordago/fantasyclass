<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Classroom;
use Google_Service_Drive;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

    private $folder;
    public function __construct(Google_Client $client)
    {
        
        $this->middleware(function ($request, $next) use ($client) {   
            if(!auth()->user()->refresh_token) {
                abort(403);
            }
            $client->refreshToken(auth()->user()->refresh_token);
            $this->folder = new Google_Service_Drive($client);
            return $next($request);
        });
    }

    public function gDrive() {
    }

    // public function usersList($courseId)
    // {

    //     $students = [];
    //     $response = $this->classroom->courses_students->listCoursesStudents($courseId);
    //     foreach ($response->students as $student) {
    //         array_push($students, $student);
    //     }
    //     return $students;
    // }

    // public function classroomList()
    // {

    //     $results = $this->classroom->courses->listCourses();
    //     $courses = [];
    //     $gcourses = $results->getCourses();
    //     if (count($gcourses) != 0) {
    //         foreach ($gcourses as $course) {
    //             array_push($courses, $course);
    //         }
    //     }
    //     return $courses;
    // }


}
