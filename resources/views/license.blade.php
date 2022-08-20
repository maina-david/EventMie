<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Eventmie Pro License Verification</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

<!-- Styles -->
<style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 3rem;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }

    .field {
        display:flex;
        position:realtive;
        margin:1rem auto;
        width:500px;
        flex-direction:row;
        -moz-box-shadow:    0px 0px 2px 0px rgba(0,0,0,0.2);
        -webkit-box-shadow: 0px 0px 2px 0px rgba(0,0,0,0.2);
        box-shadow:         0px 0px 2px 0px rgba(0,0,0,0.2);
    }

    .field>input[type=text],
    .field>button {
        display:block;
        font:1.2em 'Open sans';
    }

    .field>input[type=text] {
        flex:1;
        padding:0.6em;
        border:0.2em solid #444e60;
        border-left: none;
        border-top: none;
        outline: none;
    }

    .field>button {
        padding:0.6em 0.8em;
        background-color: #444e60;
        color: #fff;
        border:none;
        outline: none;
        cursor: pointer;
    }
</style>
</head>
<body>

<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="title m-b-md">
            Eventmie Pro License Verification
        </div>

        <div class="field">
            <input type="text" id="license" placeholder="Enter License Key or Purchase Code" />
            <button type="button" id="verify">Proceed</button>
        </div>
        
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>var s_host = "{{$_SERVER['REMOTE_ADDR']}}",base_url = "{{url('52cab7070ba5124895a63a3703f66893232')}}";</script>
<script src="{{ asset('js/eventmie-pro.js') }}"></script>

</body>
</html>
