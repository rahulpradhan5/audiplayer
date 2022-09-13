
<?php 
$host = "localhost";
$database = "musy_mysusic";
$username = "root";
$password = "";
$sql = new mysqli($host, $username, $password, $database);
if ($sql->connect_error) {
    $host = "localhost";
$database = "musy_mysusic";
$username = "musy_rahulpradhan";
$password = "rahulpradhan";
    $sql = new mysqli($host, $username, $password, $database);
}
// else{
//     echo("<script>alert('conected')</script>");
// }
?>