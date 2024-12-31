<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $CurentTime = now();
    @endphp
    <div style="width: 80%;margin: auto;">

        <div style="display: flex;flex-direction: row;justify-content: start;align-items: center;border: 1px dashed silver;padding: 10px;height:60px;border-radius: 25px;margin: 10px;text-align: center;background-color: white;box-shadow: 0px 0px 5px silver;">
            <div style="flex: 16;text-align: left;">name</div>
            <div style="flex: 3">finish at</div>
            <div style="flex: 1;padding: 0 5px;border-radius: 5px;min-width: 10%;">status</div>
            <div style="flex: 1;">run</div>
            <div style="flex:1">detail</div>
        </div>
        @foreach($tasks as $task)
            <div  x-data="{ open: false }" >
                <div style="position: relative;z-index: 1;display: flex;flex-direction: row;justify-content: space-between;align-items: center;border: 1px solid silver;padding: 10px;border-radius: 25px;margin: 10px;text-align: center;height: 60px;background-color: white;box-shadow: 0px 0px 5px silver;">
                    <div style="flex: 16;text-align: left;">{{$task->subject}}</div>
                    <div style="flex: 3">
                        <small>{{\Carbon\Carbon::parse($task->deadline)->toFormattedDateString()}}</small>
                    </div>
                    <div class="{{$task->status}}" style="flex: 1;padding: 0 5px;border-radius: 5px;color: white;min-width: 10%;">
                        {{$task->status}}
                    </div>
                    <div style="flex: 1;">
                        @if($task->status == 'inprogress' && !is_null(Auth::user()))
                            @php
                                $lastStatusForTask = null;
                            @endphp
                            @foreach($timesForCurrentUser as $time)
                                @if($time->task_id == $task->id)
                                    @php
                                        $lastStatusForTask = $time->status;
                                    @endphp
                                @endif
                                @if (is_null($time))
                                    @php
                                        $lastStatusForTask = false;
                                    @endphp
                                @endif
                            @endforeach

                            @if($lastStatusForTask)
                                <form action="{{ route('times.update', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="end" value="{{ $CurentTime }}">
                                    <button type="submit" class="pausbtn"><span style="font-size: x-large;" class="icon-controller-paus"></span></button>
                                </form>
                            @elseif(!$lastStatusForTask)
                                <form action="{{ route('times.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    <input type="hidden" name="start" value="{{ $CurentTime }}">
                                    <button type="submit" class="startbtn"><span style="font-size: x-large;" class="icon-controller-play"></span></button>
                                </form>
                            @endif
                        @endif

                    </div>
                    <div style="flex:1">
                        <span class="icon-dots-three-vertical"  x-on:click="open = ! open"></span>
                    </div>
                </div>
                <div x-show="open" style="width: 86%;margin: -10px auto 10px;background-color: white;position: relative;z-index: 0;padding: 13px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border: 1px solid #e7e7e7;">
                    <div style="text-align: center;">{{$task->description}}</div>
                    <div style="display: flex;justify-content: space-evenly;flex-direction: row;">
                        <div>
                            <table>
                                <tr>
{{--                                    <th>task name</th>--}}
                                    <th>start at</th>
                                    <th>end at</th>
                                    <th>duration</th>
                                </tr>
{{--                                @dd($timesForCurrentUser)--}}
                                @if(!is_null($timesForCurrentUser))
                                    @foreach($timesForCurrentUser as $time)
                                        <tr>
{{--                                            <td>{{$task->name}}</td>--}}
                                            <td>{{$time->start}}</td>
                                            <td>{{$time->end}}</td>
                                            <td>{{$time->diffMinute}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if(session('success'))
        <div id="alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div id="alert" class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <script>
        setTimeout(function() {
            var div = document.getElementById("alert");
            div.parentNode.removeChild(div);
        }, 4000);
    </script>



</x-app-layout>
