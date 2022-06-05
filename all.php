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

if(isset($_POST['delete'])){
    $sid = $_POST['sid'];
    $fetch_all_data = $sql->prepare("SELECT * FROM `music` WHERE `mid` = ?");
    $fetch_all_data->bind_param('s',$sid);
    $fetch_all_data->execute();
    $fetch_all_data_result = $fetch_all_data->get_result();
    $fetch_all_data_data = $fetch_all_data_result->fetch_assoc();
    $file_song = $fetch_all_data_data['song'];
    $file_thumb = $fetch_all_data_data['thumbnail'];
    if(unlink($file_song )){
        if(unlink($file_thumb)){
        $delete_data_song = $sql->prepare("DELETE FROM `music` WHERE `mid` = ?");
        $delete_data_song->bind_param('s',$sid);
        $delete_data_song->execute();
        if($delete_data_song->affected_rows>0){
            echo "success";
        }else{
            echo "failed";
        }
    }else{
        echo "failed";
    }
    }else{
        echo "failed";

    }
}
?>