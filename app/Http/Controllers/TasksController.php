<?php

namespace App\Http\Controllers;

use App\Challenge;
use App\Classroom;
use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{

    public function __construct()
    {
        $this->middleware('verified');
    }


    public function destroy($id) {
        $task = Task::findOrFail($id);
        $class = Classroom::find($task->challenge->classroom());
        $this->authorize('update', $class);

        $task->delete();

    }
}
