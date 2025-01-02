<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
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
        return view('dashboard', compact('tasks', 'timesForCurrentUser'));
    }
}
