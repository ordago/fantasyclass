<?php

namespace App\Http\Controllers;

use Google_Service;
use Google_Service_Classroom;
use Google_Service_Drive;
use Google_Service_Oauth2;
use Illuminate\Http\Request;
use PulkitJalan\Google\Facades\Google;

class ServicesController extends Controller
{
    public function gclassroom() {
        $classroom = Google::make('classroom');

        $googleClient = Google::getClient();
        $googleClient->setAuthConfig('/var/www/google.json');
        // $googleClient->setScopes([
        //     'https://www.googleapis.com/auth/classroom.courses.readonly',
        //     "https://www.googleapis.com/auth/classroom.rosters.readonly",
        //     'https://www.googleapis.com/auth/classroom.coursework.students',
        //     'https://www.googleapis.com/auth/classroom.student-submissions.students.readonly',
        //     'https://www.googleapis.com/auth/classroom.announcements',
        //   ]);
        $googleClient->addScope(Google_Service_Drive::DRIVE);

        $redirect_uri = "http://localhost:8000";
        $googleClient->setRedirectUri($redirect_uri);
        $googleClient->getAccessToken();

        // $httpClient = $googleClient->authorize();

        // $google_oauthV2 = new Google_Service_Oauth2($googleClient);
        // dump($google_oauthV2);

        // if (isset($_GET['code'])) {
        //     $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
        // }

    }
}
