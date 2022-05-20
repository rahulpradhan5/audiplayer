<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="popup">
        <div class="close-btn">&times;</div>
        <div class="form">
            <h2>Add Song</h2>
            <div class="form-element">
                <label>Title</label>
                <input type="text" class="song_name" id="title" placeholder="Enter Title" require>
            </div>
            <div class="form-element">
                <label>Artist</label>
                <input type="text" class="artist" id="artist" placeholder="Enter artist name" require>
            </div>
            <div class="form-element">
                <label>Song</label>
                <input type="file" id="song" placeholder="Enter Title" hidden="hidden" require>
                <div class="custom-choose" >
                <button type="button" class="uplaod_song_button " id="uplaod_song_button" style="width: 40%;">Choose</button>
                <span class="custum-text song" id="custum-text" >No song choosen,yet</span>
                </div>
            </div>
            <div class="form-element">
                <label>Thumbnail</label>
                <input type="file" id="thumbnail" placeholder="Enter Title" hidden="hidden" require>
                <div class="custom-choose">
                <button type="button" class="uplaod_song_button " id="thumb_btm" style="width: 40%;">Choose</button>
                <span class="custum-text thumb" id="thumb_text">No song choosen,yet</span>
                </div>
            </div>
            <div class="form-element">
                <button id="submit">Upload</button>
            </div>
        </div>
    </div>
    <script>

        // custom select file
        const realfilebtn = document.getElementById("song");
        const custombtn = document.getElementById("uplaod_song_button");
        const customtxt = document.getElementById("custum-text");
        const thumbfilebtn = document.getElementById("thumbnail");
        const thumbbtn = document.getElementById("thumb_btm");
        const thumbtxt = document.getElementById("thumb_text");

        custombtn.addEventListener("click", function() {
            realfilebtn.click();

        });

        realfilebtn.addEventListener("change", function() {
            if (realfilebtn.value) {
                customtxt.innerHTML = realfilebtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            } else {
                customtxt.innerHTML = "No file choosen,yet";
            }
        });

        thumbbtn.addEventListener("click", function() {
            thumbfilebtn.click();

        });

        thumbfilebtn.addEventListener("change", function() {
            if (thumbfilebtn.value) {
                thumbtxt.innerHTML = thumbfilebtn.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            } else {
                thumbtxt.innerHTML = "No file choosen,yet";
            }
        });

//  add song popup

        document.querySelector("#show-login").addEventListener("click", function() {
            document.querySelector(".popup").classList.add("active");

        });
        document.querySelector(".popup .close-btn").addEventListener("click", function() {
            document.querySelector(".popup").classList.remove("active");

        });
        //send data to all .php

        $(document).ready(function() {
            // song file save js
            $(document).on('change', '#song', function() {

                var property = document.getElementById("song").files[0];
                var song_name = property.name;
                var song_extension = song_name.split(".").pop().toLowerCase();
                if(song_extension !== 'mp3' ){
                    alert("Invalid Audio Formate");
                    $("#submit").prop('disabled', true);
                }else{
                var from_data = new FormData();
                from_data.append("song", property);
                $.ajax({
                    url: "file_upload.php",
                    method: "POST",
                    data: from_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#custum-text").html("uplaoding...");
                        $("#submit").prop('disabled', true);

                    },
                    success: function(data) {
                        console.log(data);
                        if (data == "failed") {
                            alert("Failed Try Again")
                        } else {
                            $("#custum-text").html(data);
                            $("#submit").prop('disabled', false);
                        }
                    }
                });
            }
            });

            // thumbanil file save js

            $(document).on('change', '#thumbnail', function() {
                var tproperty = document.getElementById("thumbnail").files[0];
                var image_name = tproperty.name;
                var image_extension = image_name.split(".").pop().toLowerCase();
                console.log(image_extension);
                if(image_extension !== 'gif' && image_extension !== 'png' && image_extension !== 'jpg' && image_extension !== 'svg' && image_extension !== 'jpeg'){
                    alert("Invalid File Formate");
                    $("#submit").prop('disabled', true);
                }else{
                var from_data = new FormData();
                from_data.append("thumbnail", tproperty);
                $.ajax({
                    
                    url: "thumbanilupload.php",
                    method: "POST",
                    data: from_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#thumb_text").html("uplaoding...");
                        $("#submit").prop('disabled', true);

                    },
                    success: function(data) {
                        console.log(data);
                        if (data == "failed") {
                            alert("Failed Try Again")
                        } else {
                            $("#thumb_text").html(data);
                            $("#submit").prop('disabled', false);
                        }
                    }
                });
            }
            });


        // send data into db
            $("#submit").click(function(e) {
                e.preventDefault();
                var title = $(".song_name").val();
                var artist = $(".artist").val();
                var song = $(".song").html();
                var songIn = $("#song").val();
                var thumbanail = $(".thumb").html();
                var thumbIn = $("#thumbnail").val();
                if(title == "" || artist == "" || songIn == "" || thumbIn == ""){
                    alert("All Fields are require");
                }else{
                $.ajax({
                    url: "all.php",
                    type: "post",
                    data: {
                        sub: 1,
                        name: title,
                        artist: artist,
                        song: song,
                        thumb: thumbanail
                    },
                    success: function(data) {
                        if (data = "success") {
                            $(".close-btn").click();
                            alert("success");
                        } else {
                            alert("failed");
                        }
                    },
                });
            }
            });
        });
    </script>
</body>

</html>