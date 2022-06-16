<?php
include("connection.php");
?>
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