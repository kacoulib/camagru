function upload_merge() {

    // Reference all the elements we will need
    var errsession = document.querySelector('#err_session') !== null;
    var video = document.querySelector('#video');
    var canvas = document.querySelector('#canvas');
    var filter = document.querySelector('#filters');

    // It will be calculated late
    var width = 480 ;
    var height = 320;

    canvas.setAttribute('width', width);
    canvas.setAttribute('height', height);

    // Take a snapshot
    // Re-assign size of canvas to delete previous canvas
    if (!errsession) {
        if (filter.value > 0 && (!video.paused || !video.ended)) {
            merge_upload();
        }
    } else {
        return;
    }
}

function merge_upload() {
    var canvas = document.querySelector('#canvas');
    var photo = document.querySelector('#photo');
    var filter = document.querySelector('#filters');
    var frame_upl = document.querySelector('#uploaded');
    var width = 480 ;
    var height = 360;

    var data;
    var base_frame = new Image();


    base_frame.width = width;
    base_frame.height = height;
    base_frame.src = frame_upl.src;

    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(base_frame, 0, 0, width, height);
    data = canvas.toDataURL();

    loadphoto("./mergetool.php", frame_upl.src.toString(), data, filter, function (xhttp) {
        var newphoto = document.createElement("IMG");
        newphoto.setAttribute('src', xhttp.responseText);
        newphoto.setAttribute('alt', 'New snap with filter ' + filter.value);
        newphoto.setAttribute('width', '340px');
        newphoto.setAttribute('height', '320px');
        photo.appendChild(newphoto);
    });
}

function loadphoto(url, src, data, filter, callback) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            callback(this);
        }
    };
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xhttp.send("raw="+data+"&f="+filter.value+"&src="+src);
}

function upload_on() {
    var video = document.querySelector('#video');
    var x = document.getElementById("filters").value;
    var up_sub = document.getElementById("uploadSubmit");

    if (video.paused && x > 0) {
        up_sub.disabled = false;
    }
}