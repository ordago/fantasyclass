<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Classroom;
use Illuminate\Support\Facades\Auth;

class ServicesController extends Controller
{

    private $classroom;
    public function __construct(Google_Client $client)
    {
        $this->middleware(function ($request, $next) use ($client) {
            $client->refreshToken(auth()->user()->refresh_token);
            $this->classroom = new Google_Service_Classroom($client);
            return $next($request);
        });
    }
    
    public function classroomList()
    {
        // Print the first 10 courses the user has access to.
        $optParams = array(
            'pageSize' => 10
        );
        $results = $this->classroom->courses->listCourses($optParams);

        if (count($results->getCourses()) == 0) {
            print "No courses found.\n";
        } else {
            print "Courses:\n";
            foreach ($results->getCourses() as $course) {
                printf("%s (%s)\n", $course->getName(), $course->getId());
            }
        }
    }
}
