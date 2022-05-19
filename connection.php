
<?php 
$host = "localhost";
$database = "mymusic";
$username = "root";
$password = "";
$sql = new mysqli($host, $username, $password, $database);
if ($sql->connect_error) {
    die($sql->connect_error);
}
// else{
//     echo("<script>alert('conected')</script>");
// }
?>