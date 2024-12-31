<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
//        $user = Auth::user();
//        $tasks = Task::with(['times', 'groups.users'])
//            ->whereHas('groups.users', function ($query) use ($user) {
//                $query->where('users.id', $user->id);
//            })->get();
//        $timesForCurrentUser=[];
//        foreach ($tasks as $task) {
//            if (Auth::check()) {
//                $userTimes = $task->times()
//                    ->where('user_id', Auth::id())
//                    ->get();
//                foreach ($userTimes as $time) {
//                    $timesForCurrentUser[] = $time;
//                }
//            }
//        }


        $user = Auth::user();
        $tasks = Task::with(['times', 'groups.users'])
            ->whereHas('groups.users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->get();

        $timesForCurrentUser = [];
        if (Auth::check()) {
            foreach ($tasks as $task) {
                foreach ($task->times as $time) {
                    if ($time->user_id == Auth::id()) {
                        $timesForCurrentUser[] = $time;
                    }
                }
            }
        }
//        $lastTimeForTask = $timesForCurrentUser->lastWhere('task_id', $task->id);

//dd($timesForCurrentUser);
        return view('dashboard', compact('tasks', 'timesForCurrentUser'));
    }
}
