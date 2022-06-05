<?php
include("connection.php");
if (isset($_POST['search'])) {
    $input = $_POST['inputs'];
    $inputs = '%' . $input . '%';

    $search_song = $sql->prepare("SELECT * FROM `music` WHERE `song_title` LIKE ?");
    $search_song->bind_param('s', $inputs);
    $search_song->execute();
    $search_song_result = $search_song->get_result();
}

if (isset($_POST['playlist'])) {
    $pid = $_POST['pid'];
    if (!empty($_POST['pid'])) {
        $search_song = $sql->prepare("SELECT * FROM `music` WHERE `pid` = ?");
        $search_song->bind_param('s', $pid);
    } else {
        $search_song = $sql->prepare("SELECT * FROM `music`");
    }

    $search_song->execute();
    $search_song_result = $search_song->get_result();
} elseif (!isset($_POST['search']) && !isset($_POST['playlist'])) {
    $search_song = $sql->prepare("SELECT * FROM `music` ");
    $search_song->execute();
    $search_song_result = $search_song->get_result();
}
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
                <div class="play-btn delete-btn" data-id="<?php echo $search_song_data['mid']; ?>" onclick="songDelete(this.getAttribute('data-id'))"><i class="fa fa-trash-o song-d"></i></div>
            </div>
        </div>
<?php

    }
}

?>