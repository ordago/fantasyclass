<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Auth;

class StorageController extends Controller
{

    private $folder;
    public function __construct(Google_Client $client)
    {

        $this->middleware(function ($request, $next) use ($client) {
            if (!auth()->user()->refresh_token) {
                abort(403);
            }
            // settings()->setExtraColumns(['classroom_id' => $class->id]);
            // settings()->set('gdrive_refresh_token', $auth_user->refreshToken);
            $client->refreshToken(Auth()->user()->g_refresh_token);
            $client->setAccessType('offline');
            $client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

            $this->folder = new Google_Service_Drive($client);
            return $next($request);
        });
    }

    public function gDrive()
    {
        $results = $this->folder->files->listFiles();

        if (count($results->getFiles()) == 0) {
            $fileMetadata = new \Google_Service_Drive_DriveFile(array(
                'name' => "#FantasyClassFiles", 'mimeType' => 'application/vnd.google-apps.folder'
            ));
            $folderId = $this->folder->files->create($fileMetadata, array(
                'fields' => 'id'
            ));
            $user = Auth()->user();
            $user->g_folder = $folderId->id;
            $user->save();
        }
        return redirect()->to('/classroom/' . session()->pull('code') . "/challenges");

    }
}
