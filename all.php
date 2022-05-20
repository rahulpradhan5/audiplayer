<?php
include("connection.php");
if(isset($_POST['sub'])){
      $name = $_POST['name'];
      $artist = $_POST['artist'];
      $song = $_POST['song'];
      $thumbnail = $_POST['thumb'];
     $save = $sql->prepare("INSERT INTO `music`(`song_title`, `artist_name`, `thumbnail`, `song`) VALUES (?,?,?,?)");
     $save->bind_param('ssss',$name,$artist,$thumbnail,$song);
     $save->execute();
     if($save->affected_rows>0){
         echo "success";
     }
}
?>