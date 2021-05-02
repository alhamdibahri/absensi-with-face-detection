<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="{{ asset('dist/face-api.js') }}"></script>
    <script defer src="{{ asset('script.js') }}"></script>
    <title>Face Recognition</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column
        }

        canvas {
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body>

    <div id="data">
        <video autoplay="true" id="video-webcam" width="400px" style="float:left; margin-right:20px;" />
            Browsermu tidak mendukung bro, upgrade donk!
        </video>
    </div>
    
    <button id="absensi">Compare Foto</button>
</body>

</html>