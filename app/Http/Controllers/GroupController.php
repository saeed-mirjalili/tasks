<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Support\Facades\Gate;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::with('tasks', 'users')->get();
        $taskCounts = [];

        foreach ($groups as $group) {
            $taskCounts[$group->id] = [
                'successful' => $group->tasks->filter(function ($task) {
                    return $task->status == 'done';
                })->count(),
                'unsuccessful' => $group->tasks->filter(function ($task) {
                    return $task->status == 'fail';
                })->count(),
            ];
        }
        return view('groupsview', compact('groups','taskCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access'))) {
            return view('groupCreateForm');
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request)
    {
        if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access'))) {
            Group::create($request->validated());
            return redirect()->route('groups.index')->with('success', 'the operation was successfully');
        }
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return $group;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }
}
