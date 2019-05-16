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
     * Create a new controller instance,
     * and include the auth middleware,
     * so this controller requires authentication.
     * If user is not authenticated it will be redirected
     * to login
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Check if current logged user id matches with task id,
     * and if not stops operation and redirect back with an
     * error message
     * 
     * @var task
     * 
     * @return Redirect
     */
    public function checkAuth($task) {
        if($task->user_id !== Auth::id()) {
            return Redirect::back()->with("danger", "Unauthorized");
        }
    }

    /**
     * Query all tasks that belong to the user and
     * passes them to the view
     * 
     * @return view
     */
    public function index()
    {
        $tasks = Task::where("user_id", Auth::id())->where("completed", false)->orderBy("id", "desc")->get();
        $completed_tasks = Task::where("user_id", Auth::id())->where("completed", true)->get();

        return view("tasks_index", compact("tasks", "completed_tasks"));

    }

    /**
     * Create a new task and store it in db
     * with current user id as user id
     * and returns a success message
     * 
     * @var request
     * 
     * @return view
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $task = new Task();
        $task->task = request("task");
        $task->user_id = Auth::id();
        $task->save();
        return Redirect::back()->with("message", "Task has been added");
    }

    /**
     * Check if user_id is correct
     * and tick a task as complete
     * 
     * @var request
     * 
     * @return view
     */
    public function complete($id)
    {
        $task = Task::find($id);

        $this->checkAuth($task);

        $task->completed = true;
        $task->save();
        return Redirect::back()->with("message", "Task has been added to completed list");
    }

    /**
     * Check if user_id is correct
     * and delete a task from db
     * 
     * @var request
     * 
     * @return view
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        $this->checkAuth($task);

        $task->delete();
        return Redirect::back()->with('message', "Task has been deleted");
    }
}
