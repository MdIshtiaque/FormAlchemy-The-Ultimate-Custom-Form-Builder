<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormAlchemy</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap');

        body {
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            font-family: 'Times New Roman', serif;
        }

        .container {
            height: 100vh;
        }

        .waviy {
            position: relative;
            font-size: 4rem;
            -webkit-box-reflect: below 0 linear-gradient(transparent, rgba(0, 0, 0, 0.2));
        }

        .waviy span {
            font-family: 'Alfa Slab One', cursive;
            position: relative;
            display: inline-block;
            color: #555555;
            text-transform: uppercase;
            animation: waviy 1s infinite;
            animation-delay: calc(.1s * var(--i));
        }

        @keyframes waviy {
            0%, 40%, 100% {
                transform: translateY(0);
            }
            20% {
                transform: translateY(-20px);
            }
        }

        .btn {
            border-radius: 12px;
            padding: 10px 30px;
            font-size: 1.2rem;
            transition: background-color 0.5s, color 0.5s;
        }

        .btn-primary:hover, .btn-secondary:hover {
            background-color: white;
            color: black;
        }
        .form {
            white-space: nowrap;
        }
        .alchemy {
            white-space: nowrap;
        }

        @media only screen and (max-width: 768px) {
            .waviy span {
                font-size: 2rem;
            }
            .space {
                display: none;  /* Hide the space on mobile */
            }
            /* other adjustments as necessary */
        }

    </style>
</head>
<body>
<div class="container text-center d-flex justify-content-center align-items-center vh-100">
    <div>
        <div class="waviy">
            <div class="form" style="display: inline-block; white-space: nowrap;">
                <span style="--i:1">F</span>
                <span style="--i:2">o</span>
                <span style="--i:3">r</span>
                <span style="--i:4">m</span>
            </div>
            <span class="space">&nbsp;&nbsp;&nbsp;</span>
            <div class="alchemy" style="display: inline-block; white-space: nowrap;">
                <span style="--i:5">A</span>
                <span style="--i:6">l</span>
                <span style="--i:7">c</span>
                <span style="--i:8">h</span>
                <span style="--i:9">e</span>
                <span style="--i:10">m</span>
                <span style="--i:11">y</span>
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <h2 style="font-weight: bold">
            <span>The Ultimate Custom Form Builder</span>
        </h2>
        <br>
        @if(auth()->check() != '')
            <span
                style="font-weight: bolder; font-size: large; padding-bottom: 20px !important;">HI, {{ auth()->user()->name }}</span>
        @endif
        <br>
        @if(auth()->check() == '')
            <a href="{{ route('login') }}" type="button" class="btn btn-primary mr-2">Login</a>
            <a href="{{ route('register') }}" type="button" class="btn btn-secondary">Register</a>
        @else

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <a href="{{ route('login') }}" type="button" class="btn btn-primary mr-2">Lets get Started</a>

                <button type="submit" class="btn btn-secondary">Sign off</button>
            </form>
        @endif
    </div>
</div>
</body>
</html>
