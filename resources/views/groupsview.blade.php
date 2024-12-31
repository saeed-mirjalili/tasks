
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Groups') }}
        </h2>
    </x-slot>



@php
    $CurentTime = now();
@endphp

<div style="width: 80%;margin: auto;">
    <div style="display: flex;flex-direction: row;justify-content: start;align-items: center;border: 1px dashed silver;padding: 10px;border-radius: 25px;margin: 10px;text-align: center;height: 60px;background-color: white;box-shadow: 0px 0px 5px silver;">
        <a href="{{ route('groups.create') }}"> <span class="icon-plus"></span> add new group</a>
    </div>
    <div style="display: flex;flex-direction: row;justify-content: start;align-items: center;border: 1px dashed silver;padding: 10px;border-radius: 25px;margin: 10px;text-align: center;height: 60px;background-color: white;box-shadow: 0px 0px 5px silver;">
        <div style="flex: 16;text-align: left;">name</div>
        <div style="flex: 3">create at</div>
        <div style="flex: 1;padding: 0 5px;border-radius: 5px;min-width: 10%;">rate</div>
        <div style="flex: 1;"></div>
        <div style="flex: 3;display: flex;justify-content: center;align-items: center;">users</div>
        <div style="flex: 1;text-align: end;display: flex;align-items: flex-start;"></div>
        <div style="flex:1">tasks</div>
        <div style="flex:1">detail</div>
    </div>

    @foreach($groups as $group)
        <div  x-data="{ open: false }" >
            <div style="position: relative;z-index: 1;display: flex;flex-direction: row;justify-content: space-between;align-items: center;border: 1px solid silver;padding: 10px;border-radius: 25px;margin: 10px;text-align: center;height: 60px;background-color: white;box-shadow: 0px 0px 5px silver;">
                <div style="flex: 16;text-align: left;">{{$group->name}}</div>
                <div style="flex: 3">
                    <small>{{\Carbon\Carbon::parse($group->created_at)->toFormattedDateString()}}</small>
                </div>
                <div style="flex: 1;padding: 0 5px;border-radius: 5px;min-width: 10%;display: flex;justify-content: center;color: #dfbc01;">
                    @for($i = 0 ; $i < 5; $i++)
                        @if($i < $group->rate)
                            <span class="icon-star"></span>
                        @else
                            <span class="icon-star-outlined"></span>
                        @endif
                    @endfor
                </div>
                <div style="flex: 1;">

                </div>
                <div style="flex: 3;display: flex;justify-content: center;align-items: center;">
                    {{$group->users->count()}}
                </div>
                <div style="flex: 1;text-align: end;display: flex;align-items: flex-start;">

                </div>
                <div style="flex: 1;">
                    {{$group->tasks->count()}}
                </div>
                <div  style="flex: 1;">
                    <a href="{{route('showUserGroupForm', $group->id )}}"><span class="icon-flow-tree"></span></a>
                </div>
                <div style="flex:1">
                    <span class="icon-dots-three-vertical"  x-on:click="open = ! open"></span>
                </div>
            </div>
            <div x-show="open" style="width: 86%;margin: -10px auto 10px;background-color: white;position: relative;z-index: 0;padding: 13px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border: 1px solid #e7e7e7;">
                <div style="text-align: center;"></div>
                <div style="display: flex;justify-content: space-evenly;flex-direction: row;">
                    <div>
                        done task:{{ $taskCounts[$group->id]['successful'] ?? 0 }}<span class="icon-thumbs-up"></span>
                        failed task:{{ $taskCounts[$group->id]['unsuccessful'] ??  0}}<span class="icon-thumbs-down"></span>
                    </div>
                    <div>
{{--                        <form action="{{route('tasks.update', $task->id) }}" method="post" onsubmit="return confirm('are you sure?');">--}}
{{--                            @csrf--}}
{{--                            @method('PUT')--}}
{{--                            <input type="text" value="fail" name="status" hidden />--}}
{{--                            <button type="submit">is it fail <span class="icon-new"></span></button>--}}
{{--                        </form>--}}
                    </div>
                    <div>
{{--                        <form action="{{route('tasks.destroy', $task->id) }}" method="post" onsubmit="return confirm('are you sure?');">--}}
{{--                            @csrf--}}
{{--                            @method('delete')--}}
{{--                            <button type="submit">delete task <span class="icon-trash"></span></button>--}}
{{--                        </form>--}}
                    </div>
                    <div>
{{--                        <form action="{{route('tasks.update', $task->id) }}" method="post" onsubmit="return confirm('are you sure?');">--}}
{{--                            @csrf--}}
{{--                            @method('PUT')--}}
{{--                            <input type="datetime-local" name="deadline">--}}
{{--                            <button type="submit">take overtime <span class="icon-battery"></span></button>--}}
{{--                        </form>--}}
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




