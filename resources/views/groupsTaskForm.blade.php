<x-app-layout>
        <link href="/css/style.css" rel="stylesheet" />
        <link href="/css/index.css" rel="stylesheet" />
        <link href="/css/tree.css" rel="stylesheet" />
<div style="
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    width: 80%;
    margin: 10px auto;
    ">
    <div style="width: 30%;
    background-color: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 3px 6px #d5d5d5;
    ">
        <form method="POST" action="{{ route('addGroupTask') }}">
            @csrf
            <input type="text" name="task" value="{{$task->id}}" hidden>
            <select id="group" name="group"  style="border: 1px solid silver;border-radius: 10px;margin: 5px;">
                <option value="" disabled selected>pleas select a group</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            <label for="isSupervisor" class="inline-flex items-center" style="margin: 5px;">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="isSupervisor">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Is Auxiliary') }}</span>
            </label>
            <x-primary-button class="ms-3">
                <span class="icon-login"></span>{{ __('Add') }}
            </x-primary-button>
        </form>
    </div>


    <div style="width: 30%;
    background-color: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 3px 6px #d5d5d5;">
        <form method="post" action="{{ route('removeGroupTask') }}">
            @csrf
            <input type="text" name="task" value="{{$task->id}}" hidden>

            <select id="group" name="group"  style="border: 1px solid silver;border-radius: 10px;margin: 5px;">
                <option value="" disabled selected>pleas select a group</option>
                @foreach($taskGroups as $taskGroup)
                    <option value="{{ $taskGroup->id }}">{{ $taskGroup->name }}</option>
                @endforeach
            </select>

            <x-primary-button class="ms-3">
                {{ __('Remove') }}<span class="icon-log-out"></span>
            </x-primary-button>
        </form>
    </div>
</div>


<div style="width: 80%;
    background-color: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 3px 6px #d5d5d5;
    margin: auto;
    ">
    <div class="tree">
        <ul>
            <li>
                <a href="#">{{$task->subject}}</a>
                <ul>
                    @foreach($taskGroups as $taskGroup)
{{--                        @if($taskGroup->role == 'user')--}}
                            <li>
                                <a href="#">{{$taskGroup->name}}</a>
                            </li>
{{--                        @endif--}}
                    @endforeach
                </ul>

            </li>
        </ul>
    </div>
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
