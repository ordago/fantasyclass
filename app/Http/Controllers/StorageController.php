<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Http\Classes\Functions;
use App\Task;
use App\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\Auth;

class StorageController extends Controller
{

    private $folder;
    private $client;
    public function __construct(Google_Client $client)
    {

        $this->middleware(function ($request, $next) use ($client) {
            $this->client = $client;
            // if (!auth()->user()->refresh_token) {
            //     abort(403);
            // }
            // settings()->setExtraColumns(['classroom_id' => $class->id]);
            // settings()->set('gdrive_refresh_token', $auth_user->refreshToken);
            if (auth()->user()->refresh_token) {
                $client->refreshToken(Auth()->user()->g_refresh_token);
                $client->setAccessType('offline');
                $client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

                $this->folder = new Google_Service_Drive($client);
            }
            return $next($request);
        });
    }

    public function uploadFile($challengeId)
    {
        $challenge = Challenge::find($challengeId);
        $class = Classroom::find($challenge->classroom());
        $this->authorize('studyOrTeach', $class);

        $task = Task::find($challenge->task->id);
        $challenge = Challenge::find($task->challenge_id);

        $originalFile = request()->file('upload');
        $image = $originalFile->getContent();

        $student = Functions::getCurrentStudent($class);

        $rt = User::find($task->g_user)->g_refresh_token;

        $this->client->refreshToken($rt);
        $this->client->setAccessType('offline');
        $this->client->setScopes(array('https://www.googleapis.com/auth/drive.file'));

        $this->folder = new Google_Service_Drive($this->client);

        $file = new Google_Service_Drive_DriveFile();
        $file->setMimeType($file->mimeType);
        $name = "";
        if($challenge->type == 0)
            $name = $student->name . "-" . Carbon::now() . "-" . $originalFile->getClientOriginalName();
        else $name = $student->groups->first()->name . "-" . Carbon::now() . "-" . $originalFile->getClientOriginalName();
        $file->setName($name);
        $file->setParents(array($task->g_folder));

        $createdFile = $this->folder->files->create($file, array(
                    'data' => $image,
                    'mimeType' => $file->mimeType,
                    'uploadType' => 'multipart'
        ));

        $student->tasks()->attach([$task->id => ['file' => $createdFile->id, 'filename' => $originalFile->getClientOriginalName()]]);

        return redirect("/classroom/show/" . $class->code . "/section/2");
    }

    public function createFolder()
    {
        $data = request()->validate([
            'name' => ['string', 'required'],
            'challenge' => ['numeric', 'required'],
        ]);

        $challenge = Challenge::find($data['challenge']);
        $class = Classroom::find($challenge->classroom());
        $this->authorize('update', $class);

        $parentFolder = Auth()->user()->g_folder;
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => $data['name'],
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => array($parentFolder),
        ));
        $folderId = $this->folder->files->create($fileMetadata, array(
            'fields' => 'id'
        ));

        // To share
        /*$userPermission = new Google_Service_Drive_Permission(array(
            'type' => 'anyone',
            'role' => 'writer',
        ));
        $request = $this->folder->permissions->create(
            $folderId->id,
            $userPermission,
            array('fields' => 'id'),
        );*/

        return Task::create([
            'name' => $data['name'],
            'g_folder' => $folderId->id,
            'g_user' => Auth()->user()->id,
            'g_upload' => true,
            'challenge_id' => $challenge->id,
        ]);
    }

    public function gDrive()
    {
        $results = $this->folder->files->listFiles();
        $create = true;
        if (count($results->getFiles()) != 0) {
            foreach ($results->getFiles() as $file) {
                if ($file->name == "#FantasyClassFiles") {
                    $create = false;
                    $user = Auth()->user();
                    $user->g_folder = $file->id;
                    $user->save();
                }
            }
        }
        if ($create) {
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
