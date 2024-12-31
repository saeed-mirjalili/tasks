{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <link href="css/progress.css" rel="stylesheet" />--}}
{{--    <link href="css/style.css" rel="stylesheet" />--}}
{{--    <link href="css/index.css" rel="stylesheet" />--}}
{{--    <title>Document</title>--}}
{{--    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>--}}
{{--</head>--}}
{{--<body>--}}


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>



    <div style="width: 80%;margin: auto;">
        <div style="display: flex;flex-direction: row;justify-content: start;align-items: center;border: 1px dashed silver;padding: 10px;height:60px;border-radius: 25px;margin: 10px;text-align: center;background-color: white;box-shadow: 0px 0px 5px silver;">
            <a href="{{ route('tasks.create') }}"> <span class="icon-plus"></span> add new task</a>
        </div>
        <div style="display: flex;flex-direction: row;justify-content: start;align-items: center;border: 1px dashed silver;padding: 10px;height:60px;border-radius: 25px;margin: 10px;text-align: center;background-color: white;box-shadow: 0px 0px 5px silver;">
            <div style="flex: 16;text-align: left;">name</div>
            <div style="flex: 3">finish at</div>
            <div style="flex: 1;padding: 0 5px;border-radius: 5px;min-width: 10%;">status</div>
            <div style="flex: 1;"></div>
            <div style="flex: 3;display: flex;justify-content: center;align-items: center;">progress</div>
            <div style="flex: 1;text-align: end;display: flex;align-items: flex-start;"></div>
            <div style="flex:1">group</div>
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
                    <div style="flex: 3;display: flex;justify-content: center;align-items: center;">
                        @php
                            if (!empty($task->times) && isset($task->times[0])) {
                                $firstStart = $task->times[0]->start;
                                $dead = $task->deadline;
                                $start = \Carbon\Carbon::parse($firstStart);
                                $end = \Carbon\Carbon::parse($dead);
                                $all = $end->diffInMinutes($start);
                            } else {
                                $firstStart = 0;
                                $all = 0;
                            }
                            $sum = 0;
                            foreach($task->times as $time){
                                $sum += $time->diffMinute;
                            }
                            if($all !=0){
                                $progress = ($sum/$all)*100;
                                $progress = round($progress);
                            }else{
                                $progress = null;
                            }
                        @endphp
                        @if($task->status == 'inprogress' || $task->status == 'done')
                            @if(!is_null($progress))
                                <svg width="40" height="40" viewBox="0 0 250 250" class="circular-progress" style="--progress: {{$progress}}">
                                    <circle class="bg"></circle>
                                    <circle class="fg"></circle>
                                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" class="progress-text">
                                        {{$progress}}%
                                    </text>
                                </svg>
                            @endif
                        @endif
                    </div>
                    <div style="flex: 1;text-align: end;display: flex;align-items: flex-start;">
                        @if($task->groups->count() > 0 )
                            <span class="icon-shield tooltip" >
                              <small style="color: white;font-size: 9px;background-color: #939393;position: absolute;padding: 2px;border-radius: 50%;">
                                +{{$task->groups->count()}}
                              </small>
                                <span class="tooltiptext">
                            @foreach($task->groups as $group)
                                    @foreach ($group->users as $user)
                                        @if ($user->pivot->role === 'supervisor')
                                            <li>{{$user->name}}</li>
                                        @endif
                                    @endforeach
                            @endforeach
                                    </span>
                            </span>
                        @endif
                    </div>
                    <div style="flex: 1;">
                        <a href="{{ route('showGroupTaskForm', $task)}}"><span class="icon-flow-tree"></span></a>
                    </div>
                    <div style="flex:1">
                        <span class="icon-dots-three-vertical"  x-on:click="open = ! open"></span>
                    </div>
                </div>
                <div x-show="open" style="width: 86%;margin: -10px auto 10px;background-color: white;position: relative;z-index: 0;padding: 13px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border: 1px solid #e7e7e7;">
                    <div style="text-align: center;">{{$task->description}}</div>
                    <div style="display: flex;justify-content: space-evenly;flex-direction: row;">
                        <div>
                            <form action="{{route('tasks.update', $task->id) }}" method="post" onsubmit="return confirm('are you sure?');">
                                @csrf
                                @method('PUT')
                                <input type="text" value="done" name="status" hidden />
                                <x-primary-button class="ms-3">
                                    is it done <span class="icon-thunder-cloud"></span>
                                </x-primary-button>
                            </form>
                        </div>
                        <div>
                            <form action="{{route('tasks.update', $task->id) }}" method="post" onsubmit="return confirm('are you sure?');">
                                @csrf
                                @method('PUT')
                                <input type="text" value="fail" name="status" hidden />
                                <x-primary-button class="ms-3">
                                    is it fail <span class="icon-new"></span>
                                </x-primary-button>
                            </form>
                        </div>
                        <div>
                            <form action="{{route('tasks.destroy', $task->id) }}" method="post" onsubmit="return confirm('are you sure?');">
                                @csrf
                                @method('delete')
                                <x-primary-button class="ms-3">
                                    delete task <span class="icon-trash"></span>
                                </x-primary-button>
                            </form>
                        </div>
                        <div>
                            <form action="{{route('tasks.update', $task->id) }}" method="post" onsubmit="return confirm('are you sure?');">
                                @csrf
                                @method('PUT')
                                <input type="datetime-local" name="deadline">
                                <x-primary-button class="ms-3">
                                    take overtime <span class="icon-battery"></span>
                                </x-primary-button>
                            </form>
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
{{--</body>--}}
{{--</html>--}}
