<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('times', 'groups.users')->get();
        foreach ($tasks as $task) {
            if ($task->deadline < now() && $task->status != 'done') {
                $task->update([
                    'status' => 'fail',
                ]);
            }
            if ($task->groups->count() > 0 && $task->status != 'fail' && $task->status != 'done'){
                $task->update([
                    'status' => 'inprogress',
                ]);
            }
        }
        return view('tasksview', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access'))) {
            return view('taskCreateForm');
        }
        return redirect()->route('tasks.index')->with('error', 'You do not have permission to access this page.');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access'))) {
            Task::create($request->validated());
            return redirect()->route('tasks.index')->with('success', 'the operation was successfully');
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access'))) {
            return view('taskUpdateForm',compact($task));
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access'))) {
            $task->update($request->validated());
            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access'))) {
            $task->delete();
            return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }
}
