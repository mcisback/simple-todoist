<?php

namespace App\Http\Controllers;

use Redirect;
use Auth;

use Illuminate\Http\Request;

use App\Task;
use App\User;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkAuth($task) {
        if($task->user_id !== Auth::id()) {
            return Redirect::back()->with("danger", "Unauthorized");
        }
    }

    public function index()
    {

        // $tasks = Task::where("completed", false)->orderBy("id", "desc")->get();
        // $completed_tasks = Task::where("completed", true)->get();
        $tasks = Task::where("user_id", Auth::id())->where("completed", false)->orderBy("id", "desc")->get();
        $completed_tasks = Task::where("user_id", Auth::id())->where("completed", true)->get();

        return view("tasks_index", compact("tasks", "completed_tasks"));

    }
    public function store(Request $request)
    {
        $input = $request->all();
        $task = new Task();
        $task->task = request("task");
        $task->user_id = Auth::id();
        $task->save();
        return Redirect::back()->with("message", "Task has been added");
    }
    public function complete($id)
    {
        $task = Task::find($id);

        $this->checkAuth($task);

        $task->completed = true;
        $task->save();
        return Redirect::back()->with("message", "Task has been added to completed list");
    }
    public function destroy($id)
    {
        $task = Task::find($id);

        $this->checkAuth($task);

        $task->delete();
        return Redirect::back()->with('message', "Task has been deleted");
    }
}
