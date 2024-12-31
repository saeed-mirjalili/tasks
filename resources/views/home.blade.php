
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Manager</title>
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/index.css" rel="stylesheet" />
</head>
<body>
<div style="padding:40px;display: flex;justify-content: space-evenly;flex-direction: row;align-items: center;width: 80%;margin: 40px auto;background-color: white;border-radius: 10px;box-shadow: 0 0 5px silver;">
    <div   style="flex: 1;text-align: left;margin: auto 20px;">
        <div><h1>Task Manager</h1></div>
        <div>Quickly and easily generate Lorem Ipsum placeholder text. Select the number of characters, words, sentences or paragraphs, and hit generate!</div>
        @if (Route::has('login'))
            <div style="margin: 20px;">
                @auth
                    <a class="home-a-but" href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a class="home-a-but" href="{{ route('login') }}">Log in</a>

                    @if (Route::has('register'))
                        <a class="home-a-but" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
    <div style="flex: 1;"><img src="css/dd.svg" /></div>
</div>

</body>
</html>
