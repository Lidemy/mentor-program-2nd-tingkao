<!-- connect to db -->
<?php

$servername = "localhost"; 

$username = "";

$password = "";

$dbname = "mentor_program_db";


//連接資料庫
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("SET NAMES 'UTF8'");
$conn->query("set time_zone = '+8:00'");
if ($conn->connect_error) {
    die("Connection failed(連接失敗): " . $conn->connect_error);
}
// else{
//     echo "連接成功";
// };
?>