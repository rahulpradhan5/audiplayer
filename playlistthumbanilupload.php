<?php
if($_FILES['thumbnail']['name'] != ''){
    $test = explode(".",$_FILES['thumbnail']['name']);
    $ext = end($test);
    $date = date("Ymdhis");
    $name = $date.".".$ext;
    $loacation = 'image/playlist/'.$name;
    if(move_uploaded_file($_FILES['thumbnail']['tmp_name'],$loacation)){
    echo $loacation;
   }else{
       echo "failed";
   }
}
?>