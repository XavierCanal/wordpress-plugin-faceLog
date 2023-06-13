const canvasEl = document.getElementById('canvas');
const context = canvasEl.getContext('2d');
const videoEl = document.getElementById('video');
const zoomInButton = document.getElementById('zoomIn');
const zoomOutButton = document.getElementById('zoomOut');
const moveRightButton = document.getElementById('moveRight');
const moveLeftButton = document.getElementById('moveLeft');
const moveUpButton = document.getElementById('moveUp');
const moveDownButton = document.getElementById('moveDown');

// Accedir a la webcam
navigator.mediaDevices.getUserMedia({ video: true })
  .then(function(stream) {
    videoEl.srcObject = stream;
    videoEl.play();
  })
  .catch(function(error) {
    console.error(error);
  });


// Funció per fer zoom i desplaçar l'element de vídeo
function transformVideo(scale, top = 0, left = 0) {
    const currentZoom = videoEl.getAttribute("data-zoom") ? parseFloat(videoEl.getAttribute("data-zoom")) : 1;
    const currentTop = videoEl.getAttribute("data-top") ? parseFloat(videoEl.getAttribute("data-top")) : 0;
    const currentLeft = videoEl.getAttribute("data-left") ? parseFloat(videoEl.getAttribute("data-left")) : 0;
    const scaleFactor = currentZoom + scale;
    const moveLeft = currentLeft + left;
    const MoveTop = currentTop + top;
    videoEl.style.transform = "scale(" + (-scaleFactor) + "," + scaleFactor +") translate(" + moveLeft + "px," + MoveTop + "px)";
    videoEl.setAttribute("data-zoom", scaleFactor);
    videoEl.setAttribute("data-top", MoveTop);
    videoEl.setAttribute("data-left", moveLeft);
  }
  
// Afegim els events als botons
zoomInButton.addEventListener("click", function() {
    transformVideo(0.1);
  });

zoomOutButton.addEventListener("click", function() {
    transformVideo(- 0.1);
});

moveDownButton.addEventListener("click", function() {
    transformVideo(0, 10);
});

moveUpButton.addEventListener("click", function() {
    transformVideo(0, -10);
});

moveRightButton.addEventListener("click", function() {
    transformVideo(0, 0, -10);
});

moveLeftButton.addEventListener("click", function() {
    transformVideo(0, 0, 10);
});

