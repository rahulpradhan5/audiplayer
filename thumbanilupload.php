<?php
if($_FILES['thumbnail']['name'] != ''){
    $test = explode(".",$_FILES['thumbnail']['name']);
    $ext = end($test);
    $name = rand(1111111111111,99999999999999).".".$ext;
    $loacation = 'image/'.$name;
    if(move_uploaded_file($_FILES['thumbnail']['tmp_name'],$loacation)){
    echo $loacation;
   }else{
       echo "failed";
   }
}
?>