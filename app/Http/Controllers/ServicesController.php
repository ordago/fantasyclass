<?php

namespace App\Http\Controllers;

use Exception;
use Google_Client;
use Google_Service;
use Google_Service_Classroom;
use Google_Service_Drive;
use Google_Service_Oauth2;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use PulkitJalan\Google\Facades\Google;

class ServicesController extends Controller
{

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    function getClient()
    {
        $scriptUri = "http://localhost:8000/gclassroom";
        $client = new Google_Client();
        $client->setAccessType('offline');
        $client->setApplicationName('FantasyClass');
        $client->setAuthConfig('/var/www/google.json');
        $client->setScopes([
            'https://www.googleapis.com/auth/classroom.courses.readonly',
            "https://www.googleapis.com/auth/classroom.rosters.readonly",
            'https://www.googleapis.com/auth/classroom.coursework.students',
            'https://www.googleapis.com/auth/classroom.student-submissions.students.readonly',
            'https://www.googleapis.com/auth/classroom.announcements',
         ]);
         
        
         if (!request()->code) { // auth call to google
            $client->setRedirectUri($scriptUri);
            $authUrl = $client->createAuthUrl();
            header("Location: ".$authUrl);
            dd('test');
         } else {
            session()->put('token', $client->getAccessToken());
            $accessToken = $client->fetchAccessTokenWithAuthCode(request()->code);
            dd($accessToken);
            $client->setAccessToken($accessToken);
         }
         
        // If there is no previous token or it's expired.
        // if ($client->isAccessTokenExpired()) {
        //     // Refresh the token if possible, else fetch a new one.
        //     if ($client->getRefreshToken()) {
        //         $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        //     } else {
              
        //         $client->setRedirectUri($scriptUri);
        //         $authUrl = $client->createAuthUrl();
        //         header("Location: ".$authUrl);
        //     }
        
        // }
        return $client;
    }
    public function gclassroom()
    {

        $client = $this->getClient();
        $service = new Google_Service_Classroom($client);
        // Print the first 10 courses the user has access to.
            $optParams = array(
                'pageSize' => 10
            );
            $results = $service->courses->listCourses($optParams);
            
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
