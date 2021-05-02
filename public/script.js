function dataURLtoBlob(dataurl) {
  var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
      bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
  while(n--){
      u8arr[n] = bstr.charCodeAt(n);
  }
  return new Blob([u8arr], {type:mime});
}

var video = document.querySelector("#video-webcam");

    // minta izin user
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

    // jika user memberikan izin
    if (navigator.getUserMedia) {
        // jalankan fungsi handleVideo, dan videoError jika izin ditolak
        navigator.getUserMedia({ video: true }, handleVideo, videoError);
    }

    // fungsi ini akan dieksekusi jika  izin telah diberikan
    function handleVideo(stream) {
        video.srcObject = stream;
    }

    // fungsi ini akan dieksekusi kalau user menolak izin
    function videoError(e) {
        // do something
        alert("Izinkan menggunakan webcam untuk demo!")
    }

  function takeSnapshot() {
      // buat elemen img
      var img = document.createElement('img');
      img.setAttribute("id", "hasil-image");
      var context;
  
      // ambil ukuran video
      var width = video.offsetWidth
              , height = video.offsetHeight;
  
      // buat elemen canvas
      canvas = document.createElement('canvas');
      canvas.width = width;
      canvas.height = height;
  
      // ambil gambar dari video dan masukan 
      // ke dalam canvas
      context = canvas.getContext('2d');
      context.drawImage(video, 0, 0, width, height);
      
      return dataURLtoBlob(canvas.toDataURL('image/png'));
  }


const imageUpload = document.getElementById('absensi')


Promise.all([
  faceapi.nets.faceRecognitionNet.loadFromUri('./models'),
  faceapi.nets.faceLandmark68Net.loadFromUri('./models'),
  faceapi.nets.ssdMobilenetv1.loadFromUri('./models')
]).then(start)

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
    /* Dijalankan ketika terjadi file upload  di sini pencocokan data di lakukan*/
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
          container.append(image)
          container.append(canvas)
          const box = resizedDetections[i].detection.box
          const drawBox = new faceapi.draw.DrawBox(box, { label: result.toString() })
          drawBox.draw(canvas)
        }
      })

    }


  })
}

async function loadLabeledImages() {
  const labels = ['ferdi']
  return Promise.all(
    labels.map(async label => {
      const descriptions = []
        const img = await faceapi.fetchImage(`./photos/1.png`)
        const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
        descriptions.push(detections.descriptor)

      return new faceapi.LabeledFaceDescriptors(label, descriptions)
    })
  )
}
