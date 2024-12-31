<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Time;
use App\Http\Requests\StoreTimeRequest;
use App\Http\Requests\UpdateTimeRequest;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimeRequest $request)
    {
        try {
            if (Gate::allows('user-access', $request->task_id)) {
                Time::create(array_merge($request->validated(), [
                    'status' => true,
                ]));
                return redirect()->back()->with('success', 'the operation was successfully');
            }else{
                return redirect()->back()->with('error', 'Your access has been denied');
            }
        }catch (QueryException $e){
            return redirect()->back()->with('error','error:'.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Time $time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Time $time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimeRequest $request, $task)
    {
        $time = Time::where('task_id', $task)->where('status', true)->where('user_id', $request->user_id)->first();

        if (Gate::allows('user-access', $task)) {
            $start = Carbon::parse($time->start);
            $end = Carbon::parse($request->end);
            $duration = $end->diffInMinutes($start);
            $time->update(array_merge($request->validated(),[
                'diffMinute' => $duration,
                'status' => false,
            ]));
            return redirect()->back()->with('success', 'the operation was successfully');
        }else{
            return redirect()->back()->with('error', 'Your access has been denied');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Time $time)
    {
        //
    }
}
