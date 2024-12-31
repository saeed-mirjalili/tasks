<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;

class GroupsTaskController extends Controller
{
    public function showForm(Task $task)
    {
        $taskGroups = $task->groups;
        $groups = Group::all();
        return view('groupsTaskForm', compact('groups', 'taskGroups', 'task'));
    }

    public function add(Request $request)
    {
        try {
            if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access', $request->task))){
                if (!is_null($request->group)){
                    $task = Task::findOrFail($request->task);
                    $task->groups()->attach($request->group);
//                    if ($request->has('isSupervisor')){
//                        $user = User::findOrFail($request->user);
//                        if ($user->role == 'user') {
//                            $user->role = 'supervisor';
//                            $user->save();
//                        }
//                    }
//                    if ($task->status == 'notassigned'){
//                        $task->status = 'inprogress';
//                        $task->save();
//                    }

                    return redirect()->back()->with('success', 'the operation was successfully');
                }else{
                    return redirect()->back()->with('error','please select a group');
                }
            }else{
                return redirect()->back()->with('error','you dont have permision');
            }
        }catch (QueryException $e){
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This task is already assigned to the group.');
            }
            return redirect()->back()->with('error','error:'.$e->getMessage());
        }
    }

    public function remove(Request $request)
    {
        try {
            if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access', $request->task))){
                $task = Task::findOrFail($request->task);
                $task->groups()->detach($request->group);
//                $user = User::findOrFail($request->user);
//                if ($user->role == 'supervisor') {
//                    $user->role = 'user';
//                    $user->save();
//                }
                return redirect()->back()->with('success', 'the operation was successfully');
            }else{
                return redirect()->back()->with('error','you dont have permision');
            }
        }catch (QueryException $e){
            return redirect()->back()->with('error','error:'.$e->getMessage());
        }
    }
}
