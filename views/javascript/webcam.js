(function () {

    // Reference all the elements we will need
    var streaming = false;
    var errsession = document.querySelector('#err_session') !== null;
    var video = document.querySelector('#video');
    var snapshot = document.querySelector('#snapshot');
    var canvas = document.querySelector('#canvas');
    var photo = document.querySelector('#photo');
    var filter = document.querySelector('#filters');

    Object.defineProperty(HTMLMediaElement.prototype, 'playing', {
        get: function(){
            return !!(video.currentTime > 0 && !video.paused && !video.ended && video.readyState > 2);
        }
    });

    // It will be calculated late
    var width = 480 ;
    var height = 320;

    // Get video without audio from webcam according to the web browser
    navigator.getMedia = (  navigator.getUserMedia ||
                            navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia ||
                            navigator.msGetUserMedia );

    navigator.getMedia(
        {video: true, audio: false},
        function (stream) {
            if (navigator.mozGetUserMedia) {
                video.mozSrcObject = stream;
            } else {
                var navigatorURL = window.URL || window.webkitURL;
                video.src = navigatorURL.createObjectURL(stream);
            }
            video.play();
        },
        function (err) {
            console.log("The following error occured: " + err);
        }
    );

    if (video !== null) {
        // Set size of video and canvas
        video.addEventListener('canplay', function () {
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth / width);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);
    }

    // Take a snapshot
    // Re-assign size of canvas to delete previous canvas
    if (!errsession) {
        snapshot.addEventListener('click', function (event) {
            event.preventDefault();
            if (filter.value > 0 && video.playing) {
                takephoto();
            }
        }, false);
    } else {
        return;
    }

    function takephoto() {
        var data;

        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        data = canvas.toDataURL('image/png');

        loadphoto("./mergetool.php", data, filter, function (xhttp) {
            var newphoto = document.createElement("IMG");
            newphoto.setAttribute('src', xhttp.responseText);
            newphoto.setAttribute('alt', 'New snap with filter ' + filter.value);
            newphoto.setAttribute('width', '340px');
            newphoto.setAttribute('height', '320px');
            photo.appendChild(newphoto);
        });
    }

    function loadphoto(url, data, filter, callback) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                callback(this);
            }
        };
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xhttp.send("raw="+data+"&f="+filter.value);
    }
})();