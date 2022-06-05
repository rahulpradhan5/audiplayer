<?php
include("connection.php");

if(isset($_POST['up'])){
    $last_index = $_POST['indexNo'];
    $last_time = $_POST['lastTime'];
}
$id = '1';
$insert_last_time = $sql->prepare("UPDATE `last_time` SET `last_index`=?,`last_time`=? WHERE `id` = ?");
$insert_last_time->bind_param('sss',$last_index,$last_time,$id);
$insert_last_time->execute();
if($insert_last_time->affected_rows>0){
    echo "success";
}else{
    echo "failed";
}
?>