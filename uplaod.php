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
            <div class="select" id="select_play">
                <label>Playlist</label>
                <select class="playlist " name="playlist[]" id="sele" style="width: 320px;" multiple>
                    <?php
                    $select_playlist = $sql->prepare("SELECT * FROM `playlist`");
                    $select_playlist->execute();
                    $select_playlis_result = $select_playlist->get_result();
                    if ($select_playlis_result->num_rows > 0) {
                        while ($select_playlis_data = $select_playlis_result->fetch_assoc()) {
                    ?>
                            <option value="<?= $select_playlis_data['pid']; ?>"><?= $select_playlis_data['pname']; ?></option>
                    <?php
                        }
                    }
                    ?>
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
                    <div class=" add-playlist" id="ad-playlist" onclick="palyListAdd()">
                        +
                    </div>
                    <div class="playlist-img-div" id="playlist_palce">
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
                            <div class="play-btn btn-play edit-song"  data-id="<?php echo $all_songs_data['sno']; ?>" onclick="loadData(sno=this.getAttribute('data-id')),psong = true,playin_song = false,playsong(),playOne(soid = 'so<?php echo $all_songs_data['sno'];?>')"><i class="fa fa-play" id="so<?php echo $all_songs_data['sno'];?>"></i></div>
                            <div class="play-btn" data-id="<?php echo $all_songs_data['mid']; ?>" onclick="songEdit(this.getAttribute('data-id'))"><i class="fa fa-pencil"></i></div>
                            <div class="play-btn delete-btn" data-id="<?php echo $all_songs_data['mid']; ?>" onclick="songDelete(this.getAttribute('data-id'))"><i class="fa fa-trash-o song-d"></i></div>

                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <!-- // playlist of song----------------- -->
    <div class="popup " id="addplaylist_popup">
        <div class="close-btn" id="add-play">&times;</div>
        <div class="form edit-form">
            <div class="form">
                <h2>Add Playlist</h2>
                <div class="form-element">
                    <label>Playlist name</label>
                    <input type="text" class="song_name" id="play_title" placeholder="Enter Title" require>
                </div>
                <div class="form-element">
                    <label>Thumbnail</label>
                    <input type="file" id="playlist" placeholder="Enter Title" hidden="hidden" require>
                    <div class="custom-choose">
                        <button type="button" class="uplaod_song_button " id="playlist_thumb_btm" style="width: 40%;">Choose</button>
                        <span class="custum-text thumb" id="playlist_thumb_text">No song choosen,yet</span>
                    </div>
                </div>
                <div class="form-element">
                    <button id="save-playlist">Upload</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // song file save js
            $(document).on('change', '#song', function() {
                $('#submit').removeAttr('disabled');
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
                $('#submit').removeAttr('disabled');
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
                var playlist = $("#sele").val();
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
                    $('#submit').removeAttr('disabled');
                    $.ajax({
                        url: "all.php",
                        type: "post",
                        data: {
                            sub: 1,
                            name: title,
                            artist: artist,
                            song: song,
                            playlist: playlist,
                            thumb: thumbanail
                        },
                        success: function(data) {
                            console.log(data);
                            if (data = "success") {
                                $(".close-btn").click();
                                $(".list-songs").load("search.php");
                                alert("success");
                            } else if (data == 'faield') {
                                alert("failed");
                            }
                        },
                    });
                }
            });
        });

        //load playlist
        $(".plalist-image").click(function() {
            var fid = $(this).attr('id');
            var pname = $(this).attr('value');
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
        // add playlist popup show 

        function palyListAdd() {
            document.querySelector("#addplaylist_popup").classList.add("active");
        }
        document.querySelector("#add-play").addEventListener("click", function() {
            document.querySelector("#addplaylist_popup").classList.remove("active");
        });
        //custom button click playlistr
        const playthumbbtn = document.getElementById("playlist_thumb_btm");
        const playlistinput = document.getElementById("playlist");
        const playlistcustomtxt = document.getElementById("playlist_thumb_text");
        playthumbbtn.addEventListener("click", function() {
            playlistinput.click();

        });

        playlistinput.addEventListener("change", function() {
            if (playlistinput.value) {
                playlistcustomtxt.innerHTML = playlistinput.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
            } else {
                playlistcustomtxt.innerHTML = "No file choosen,yet";
            }
        });
        // add playlist thumbnail
        $(document).on('change', '#playlist', function() {
            $('#save-playlist').removeAttr('disabled');
            var tproperty = document.getElementById("playlist").files[0];
            var image_name = tproperty.name;
            var image_extension = image_name.split(".").pop().toLowerCase();
            console.log(image_extension);
            if (image_extension !== 'gif' && image_extension !== 'png' && image_extension !== 'jpg' && image_extension !== 'svg' && image_extension !== 'jpeg') {
                alert("Invalid File Formate");
                $("#save-playlist").prop('disabled', true);
            } else {
                var from_data = new FormData();
                from_data.append("thumbnail", tproperty);
                $.ajax({

                    url: "playlistthumbanilupload.php",
                    method: "POST",
                    data: from_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $("#playlist_thumb_text").html("uplaoding...");
                        $("#playlist_thumb_text").prop('disabled', true);

                    },
                    success: function(data) {
                        console.log(data);
                        if (data == "failed") {
                            alert("Failed Try Again")
                        } else {
                            $("#playlist_thumb_text").html(data);
                            $("#playlist_thumb_text").prop('disabled', false);
                        }
                    }
                });
            }
        });
        $("#save-playlist").click(function(e) {
            e.preventDefault();
            var palytit = document.querySelector("#play_title");
            var playtext = document.querySelector("#playlist_thumb_text");
            var title = $("#play_title").val();
            var playlistthumbanail = $("#playlist_thumb_text").html();
            var play_image_extension = playlistthumbanail.split(".").pop().toLowerCase();
            var play_thumbIn = $("#playlist").val();
            if (title == "" || play_thumbIn == "") {
                alert("All Fields are require");
            } else if (play_image_extension !== 'gif' && play_image_extension !== 'png' && play_image_extension !== 'jpg' && play_image_extension !== 'svg' && play_image_extension !== 'jpeg') {
                alert("Invalid Image Formate");
                $("#save-playlist").prop('disabled', true);
            } else {
                $('#save-playlist').removeAttr('disabled');
                $.ajax({
                    url: "all.php",
                    type: "post",
                    data: {
                        palylist: 1,
                        name: title,
                        thumb: playlistthumbanail
                    },
                    success: function(data) {
                        console.log(data);
                        if (data = "success") {
                            palytit.value = "";
                            playtext.innerHTML = "No File Choosen Yet";
                            play_image_extension = "";
                            play_thumbIn = "";
                            $("#add-play").click();
                            $("#playlist_palce").load("load_playlist.php");
                            $("#select_play").load("select.php");
                            alert("success");
                        } else if (data == 'faield') {
                            alert("failed");
                        }
                    },
                });
            }
        });

        // play song 
    </script>
    <script src="uploadscript.js">

    </script>
</body>

</html>