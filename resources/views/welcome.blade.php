<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.css') }}">
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
    
    <button id="absensi" class="mt-4 btn btn-info">Tekan Untuk Absensi</button>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <script>
        
        function dataURLtoBlob(dataurl) {
                var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
                    bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
                while(n--){
                    u8arr[n] = bstr.charCodeAt(n);
                }
                return new Blob([u8arr], {type:mime});
            }

            var video = document.querySelector("#video-webcam");

                navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

                if (navigator.getUserMedia) {
                    navigator.getUserMedia({ video: true }, handleVideo, videoError);
                }

                function handleVideo(stream) {
                    video.srcObject = stream;
                }

                function videoError(e) {
                    alert("Izinkan menggunakan webcam untuk demo!")
                }

            function takeSnapshot() {
                var img = document.createElement('img');
                img.setAttribute("id", "hasil-image");
                var context;
            
                var width = video.offsetWidth
                        , height = video.offsetHeight;
            
                canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, width, height);
                
                return dataURLtoBlob(canvas.toDataURL('image/png'));
            }


            const imageUpload = document.getElementById('absensi')

            let labels = []

            @if(count($users)>0)
                @foreach ($users as $key => $item)
                    labels.push({
                        'id'            : "{{ $item->id }}",
                        'nama_karyawan' : '{{ $item->nama_karyawan }}({{$item->nip}})',
                        'foto_karyawan' : '{{ $item->foto_karyawan }}'
                    })
                @endforeach
            @else
                labels.push({
                    'id'            : "0",
                    'nama_karyawan' : 'unknown',
                    'foto_karyawan' : 'unknown.jpg'
                })
            @endif

            async function loadLabeledImages() {
            
                return Promise.all(
                    labels.map(async label => {
                    const descriptions = []
                        const img = await faceapi.fetchImage(`{{ asset('foto_karyawan') }}/${label.foto_karyawan}`)
                        const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                        descriptions.push(detections.descriptor)

                        return new faceapi.LabeledFaceDescriptors(label.nama_karyawan, descriptions)
                    })
                )
            }
        async function start() {
                const coba =  document.getElementById('data')
                const container = document.createElement('div')
                container.style.position = 'relative'
                container.style.float = 'right'
                coba.append(container)

                const labeledFaceDescriptors = await loadLabeledImages()
                const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors, 0.5)
                let image
                let canvas
            
                imageUpload.addEventListener('click', async () => {
                    if (image) image.remove()
                    if (canvas) canvas.remove()
                    image = await faceapi.bufferToImage(takeSnapshot())
                    
                    canvas = faceapi.createCanvasFromMedia(image)
                    
                    
                    const displaySize = { width: image.width, height: image.height }
                    faceapi.matchDimensions(canvas, displaySize)

                    const detections = await faceapi.detectAllFaces(image).withFaceLandmarks().withFaceDescriptors()
                    const resizedDetections = faceapi.resizeResults(detections, displaySize)
                    const results = resizedDetections.map(d => faceMatcher.findBestMatch(d.descriptor))
                    
                    if(!results.length){
                        alert('wajah tidak ditemukan')
                    }else{
                        results.forEach((result, i) => {
                            if(result.label === 'unknown'){
                                alert('wajah tidak ditemukan')
                            }else{
                                // console.log(result)
                                const pegawai = labels.find((data) => data.nama_karyawan === result.label)
                                console.log(pegawai)
                                let payload = {
                                    '_token': "{{ csrf_token() }}",
                                    'karyawan_id': pegawai.id
                                }

                                $.ajax({
                                    type: "POST",
                                    url: '/absensi',
                                    data: payload,
                                    success:function(data, textStatus, jqXHR) 
                                    {
                                        var data = jqXHR.responseJSON;
                                        console.log(data)
                                        if(data.status){
                                            container.append(image)
                                            container.append(canvas)
                                            const box = resizedDetections[i].detection.box
                                            const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
                                            drawBox.draw(canvas)
                                        }else{
                                            alert(data.massage);
                                        }
                                        
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) 
                                    {
                                        var data = jqXHR.responseJSON;
                                        alert(data)
                                    }
                            });
                            
                        }
                    })

                    }


                })
            }
    </script>
</body>

</html>