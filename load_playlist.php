<?php
include("connection.php");
?>
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
<script>
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
</script>