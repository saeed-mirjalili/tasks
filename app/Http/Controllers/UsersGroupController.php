<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersGroupController extends Controller
{
    public function showForm(Group $group)
    {
        $groupUsers = $group->users;
        $users = User::all();
        return view('usersGroupForm', compact('users', 'groupUsers', 'group'));
    }

    public function add(Request $request)
    {
        try {
            if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access', $request->group))){
                if (!is_null($request->user)){
                    $group = Group::findOrFail($request->group);
                    if ($request->has('isSupervisor')) {
                        $role = 'supervisor';
                    }else{
                        $role = 'user';
                    }
                    $group->users()->attach($request->user, ['role' => $role]);

                    return redirect()->back()->with('success', 'the operation was successfully');
                }else{
                    return redirect()->back()->with('error','please select a user');
                }
            }else{
                return redirect()->back()->with('error','you dont have permision');
            }
        }catch (QueryException $e){
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'This task is already assigned to the user.');
            }
            return redirect()->back()->with('error','error:'.$e->getMessage());
        }
    }

    public function remove(Request $request)
    {
        try {
            if (Gate::allows('admin-access')  || (Gate::allows('supervisor-access', $request->task))){
                $group = Group::findOrFail($request->group);
                $group->users()->detach($request->user);
                return redirect()->back()->with('success', 'the operation was successfully');
            }else{
                return redirect()->back()->with('error','you dont have permision');
            }
        }catch (QueryException $e){
            return redirect()->back()->with('error','error:'.$e->getMessage());
        }
    }
}
