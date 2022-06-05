<?php
include("connection.php");
$allsong = $sql->prepare("SELECT * FROM `music`");
$allsong->execute();
$allsong_result = $allsong->get_result();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="main">
        <p id="logo"><i class="fa fa-music" aria-hidden="true"></i>music</p>


        <!-- ---------------Left Part---------------- -->
        <div class="left ">

            <!-- ------------song image------------- -->
            <img id="track_image">
            <div class="volume">
                <p id="volume_show">90</p>
                <i class="fa fa-volume-up" aria-hidden="true" id="volume_icon" onclick="mute_sound()"></i>
                <input type="range" min="0" max="100" value="90" onchange="volume_change()" id="volume">
            </div>
        </div>

        <!-- --------------right part----------------------- -->
        <div class="right">
            <div class="show_song_no">
                <p id="present">1</p>
                <p>/</p>
                <p id="total">3</p>
            </div>

            <!-- ---------------song title---------------------- -->
            <p id="title">Title.mp3</p>
            <p id="artist">Artist Name</p>

            <!-- -------------middle part--------------- -->
            <div class="middle">
                <button onclick="previous_song()" id="pre"><i class="fa fa-step-backward" aria-hidden="true"></i></button>
                <button onclick="justplay()" id="play"><i class="fa fa-play" aria-hidden="true"></i></button>
                <button onclick="next_song()" id="next"><i class="fa fa-step-forward" aria-hidden="true"></i></button>
            </div>


            <!-- --------------- song duration---------------- -->
            <div class="duration">
                <input type="range" min="0" max="100" value="0" id="duration_slider" onchange="change_duration()">
            </div>
            <button id="auto" onclick="autoplay_switch()">Auto Play<i class="fa fa-circle-o-notch" aria-hidden="true"></i></button>
        </div>
    </div>
    <!-- --------------- sidebar add------------------------ -->
    <?php
    include("sidebar.php");
    ?>
    <!-- -------------add javascript------------------ -->
    <script>
        let data = [

            <?php

            while ($df = $allsong_result->fetch_array()){

            ?>

                {

                    name: "<?php echo $df['song_title']; ?>",
                    path: "<?php echo $df['song']; ?>",
                    img: "<?php echo $df['thumbnail']; ?>",
                    singer: "<?php echo $df['artist_name']; ?>"

                },
            <?php
            }
            ?>
        ];
        // last time play song data
        <?php
        $id = '1';
        $indexandtrimer = $sql->prepare("SELECT * FROM `last_time` WHERE `id` = ?");
        $indexandtrimer->bind_param('s',$id);
        $indexandtrimer->execute();
        $indexandtrimer_result = $indexandtrimer->get_result();
        $indexandtrimer_data = $indexandtrimer_result->fetch_assoc();
        ?>
        var index_no_l = <?php echo $indexandtrimer_data['last_index'];?>;
        var currentTime_l = <?php echo $indexandtrimer_data['last_time'];?>;
    </script>

    <script src="script.js"></script>
</body>

</html>