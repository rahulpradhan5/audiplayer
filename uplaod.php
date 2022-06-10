<?php
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <script src="jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            <div class="select ">
                <label>Playlist</label>
                <select class="playlist " name="playlist" id="sele" style="width: 320px;" multiple>
                    <option value="hi">Hii</option>
                    <option value="hii">Hii</option>
                    <option value="hiii">Hii</option>
                </select>
                <script>
                    $("#sele").select2({
                        maximumSelectionLength: 6,
                    });
                </script>
            </div>
            <div class="form-element">
                <label>Song</label>
                <input type="file" id="song" placeholder="Enter Title" hidden="hidden" require>
                <div class="custom-choose">
                    <button type="button" class="uplaod_song_button " id="uplaod_song_button" style="width: 40%;">Choose</button>
                    <span class="custum-text song" id="custum-text">No song choosen,yet</span>
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
    <!-- ----------------show songs list------------------------- -->
    <div class="popup playlis_popup song_list">
        <div class="close-btn">&times;</div>
        <div class="search_and_play">
            <!-- play list ---------------------------- -->
            <div class="playlist">
                <div class="playlist-list">
                    <div class="plalist-image add-playlist">
                        +
                    </div>
                    <div class="playlist-img-div">
                        <div class="plalist-image cd" id="0">
                            <img src="image/unkownplaylist.svg">
                            <div class="icon">
                                <i class="fa fa-bolt"></i>
                                <p>All Songs</p>
                            </div>
                        </div>
                        <?php
                        $load_playlist = $sql->prepare("SELECT * FROM `playlist`");
                        $load_playlist->execute();
                        $load_playlist_result = $load_playlist->get_result();
                        if ($load_playlist_result->num_rows > 0) {
                            while ($load_playlist_data = $load_playlist_result->fetch_assoc()) {
                                $pimage = $load_playlist_data['p_image'];
                                if (!empty($pimage)) {
                        ?>
                                    <div class="plalist-image" id="<?php echo $load_playlist_data['pid']; ?>" value="<?php echo $load_playlist_data['pname']; ?>">
                                        <img class="playimg" src="<?php echo $pimage; ?>">
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="plalist-image cd" id="<?php echo $load_playlist_data['pid']; ?>" value="<?php echo $load_playlist_data['pname']; ?>">
                                        <img src="image/unkownplaylist.svg">
                                        <div class="icon">
                                            <i class="fa fa-bolt"></i>
                                            <p><?php echo $load_playlist_data['pname']; ?></p>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- /// search btn------------------------- -->
            <div class="play_button_search">
                <div class="play_button">
                    <button class="play " onclick="playAll()"><i class="fa fa-play"></i> PLAY</button>
                </div>
                <div class="search_div">
                    <button class="play search" id="search" onclick="seach()"><i class="fa fa-search"></i><span class="search-span"> Search</span></button>
                    <i class="fa fa-search search-input-i"></i>
                    <input class="search-input" id="search-input" type="text" oninput="searchData()" placeholder="Search here....">
                </div>
            </div>
        </div>
        <!-- // all songs in play list --------------------------- -->
        <p class="all-songs">All Songs</p>
        <div class="list-songs">
            <!-- // song div---------------------------- -->
            <?php
            $all_songs = $sql->prepare("SELECT * FROM `music`");
            $all_songs->execute();
            $all_songs_result = $all_songs->get_result();
            if ($all_songs_result->num_rows > 0) {
                while ($all_songs_data = $all_songs_result->fetch_assoc()) {
            ?>
                    <div class="songs">
                        <!-- // image and autor div -->
                        <div class="image-name">
                            <div class="list-song-image">
                                <img src="<?php echo $all_songs_data['thumbnail']; ?>" alt="">
                            </div>
                            <div class="song-name-singer">
                                <p><?php echo $all_songs_data['song_title']; ?></p>
                                <span>
                                    <?php echo $all_songs_data['artist_name']; ?>
                                </span>
                            </div>
                        </div>
                        <!-- // action btns------------ -->
                        <div class="action-btn">
                            <div class="play-btn btn-play" id="edit-song"><i class="fa fa-play"></i></div>
                            <div class="play-btn"><i class="fa fa-pencil"></i></div>
                            <div class="play-btn delete-btn" data-id="<?php echo $all_songs_data['mid']; ?>" onclick="songDelete(this.getAttribute('data-id'))"><i class="fa fa-trash-o song-d"></i></div>

                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <!-- // edit part of song----------------- -->
    <div class="popup edit-popup">
        <div class="close-btn">&times;</div>
        <div class="form edit-form">

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
        /// song list 
        document.querySelector("#all-songs-list").addEventListener("click", function() {
            document.querySelector(".song_list").classList.add("active");

        });
        document.querySelector(".song_list .close-btn").addEventListener("click", function() {
            document.querySelector(".song_list").classList.remove("active");
            document.querySelector("#search").classList.remove("search-active");
            document.querySelector(".search-span").classList.remove("search-span-dactive");
            document.querySelector(".search-input-i").classList.remove("search-input-i-active");
            document.querySelector(".search-input").classList.remove("search-input-active");
        });

        document.querySelector("#edit-song").addEventListener("click", function() {
            document.querySelector(".edit-popup").classList.add("active");
            $(".edit-form").load("song_edit.php");

        });
        document.querySelector(".edit-popup .close-btn").addEventListener("click", function() {
            document.querySelector(".edit-popup").classList.remove("active");
        });
        //send data to all .php

        $(document).ready(function() {
            // song file save js
            $(document).on('change', '#song', function() {

                var property = document.getElementById("song").files[0];
                var song_name = property.name;
                var song_extension = song_name.split(".").pop().toLowerCase();
                if (song_extension !== 'mp3') {
                    alert("Invalid Audio Formate");
                    $("#submit").prop('disabled', true);
                } else {
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
                if (image_extension !== 'gif' && image_extension !== 'png' && image_extension !== 'jpg' && image_extension !== 'svg' && image_extension !== 'jpeg') {
                    alert("Invalid File Formate");
                    $("#submit").prop('disabled', true);
                } else {
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
                var song_extension = songIn.split(".").pop().toLowerCase();
                var thumbanail = $(".thumb").html();
                var image_extension = thumbanail.split(".").pop().toLowerCase();
                var thumbIn = $("#thumbnail").val();
                if (title == "" || artist == "" || songIn == "" || thumbIn == "") {
                    alert("All Fields are require");
                } else if (image_extension !== 'gif' && image_extension !== 'png' && image_extension !== 'jpg' && image_extension !== 'svg' && image_extension !== 'jpeg') {
                    alert("Invalid Image Formate");
                    $("#submit").prop('disabled', true);
                } else if (song_extension !== 'mp3') {
                    alert("Invalid Audio Formate");
                    $("#submit").prop('disabled', true);
                } else {
                    $("#submit").prop('disabled', false);
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
                            console.log(data);
                            if (data = "success") {
                                $(".close-btn").click();
                                $(".list-songs").load("search.php");
                                alert("success");
                            } else {
                                alert("failed");
                            }
                        },
                    });
                }
            });
        });

        // play all song 
        function searchData() {
            var inputs = $("#search-input").val();
            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    search: 1,
                    inputs: inputs
                },
                success: function(data) {
                    console.log(data);
                    $(".list-songs").html(data);
                    $(".all-songs").html("Search result for '" + inputs + "'");
                }
            });
        }

        // Delete a song data------------------

        function songDelete(data_id) {
            $.ajax({
                url: "all.php",
                data: {
                    delete: 1,
                    sid: data_id
                },
                type: "post",
                success: function(data) {
                    console.log(data);
                    if (data == "failed") {
                        alert("Failed");
                    } else {
                        alert("Succesfully Deleted Song Permanently");
                        $(".list-songs").load("search.php");
                    }
                }
            })
        }

        // paly all song

        /// load playlist song...............-------
        $(".plalist-image").click(function() {
            var fid = $(this).attr('id');
            var pname = $(this).attr('value');
            alert(pname)
            $.ajax({
                url: "search.php",
                data: {
                    playlist: 1,
                    pid: fid
                },
                type: "post",
                success: function(data) {
                    console.log(data);
                    $(".list-songs").html(data);
                    $(".all-songs").html("Playlist name '" + pname + "'");
                }
            })
        })

        // serach animation

        let i = 0;
        let placeholder = "";
        const txt = document.getElementById("search-input").placeholder;
        const speed = 120;

        function type() {
            placeholder += txt.charAt(i);
            document.getElementById("search-input").setAttribute("placeholder", placeholder);
            i++;
            setTimeout(type, speed);
        }

        //search animation
        var search = document.querySelector("#search");

        function seach() {
            i = 0;
            placeholder = "";
            search.classList.add("search-active");
            document.querySelector(".search-span").classList.add("search-span-dactive");
            document.querySelector(".search-input-i").classList.add("search-input-i-active");
            document.querySelector(".search-input").classList.add("search-input-active");
            type();
        }
    </script>
</body>

</html>