<?php
include("connection.php");
if (isset($_POST['search'])) {
    $input = $_POST['inputs'];
    $inputs = '%' . $input . '%';
}
$search_song = $sql->prepare("SELECT * FROM `music` WHERE `song_title` LIKE ?");
$search_song->bind_param('s', $inputs);
$search_song->execute();
$search_song_result = $search_song->get_result();
if ($search_song_result->num_rows > 0) {
    while ($search_song_data = $search_song_result->fetch_assoc()) {
?>
        <div class="songs">
            <!-- // image and autor div -->
            <div class="image-name">
                <div class="list-song-image">
                    <img src="<?php echo $search_song_data['thumbnail']; ?>" alt="">
                </div>
                <div class="song-name-singer">
                    <p><?php echo $search_song_data['song_title']; ?></p>
                    <span>
                        <?php echo $search_song_data['artist_name']; ?>
                    </span>
                </div>
            </div>
            <!-- // action btns------------ -->
            <div class="action-btn">
                <div class="play-btn btn-play"><i class="fa fa-play"></i></div>
                <div class="play-btn"><i class="fa fa-pencil"></i></div>
                <div class="play-btn delete-btn"><i class="fa fa-trash-o"></i></div>
            </div>
        </div>
<?php

    }
}

?>