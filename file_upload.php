<?php
if($_FILES['song']['name'] != ''){
     $test = explode(".",$_FILES['song']['name']);
     $ext = end($test);
     $name = rand(1111111111111,99999999999999).".".$ext;
     $loacation = 'audio/'.$name;
     if(move_uploaded_file($_FILES['song']['tmp_name'],$loacation)){
     echo $loacation;
    }else{
        echo "failed";
    }
}


?>