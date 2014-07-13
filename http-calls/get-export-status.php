<?php
session_start();
$file_status_array = json_encode($_SESSION['exportedFile']);
//session_write_close();

http_response_code(200);
header("Content-Type: application/json");
echo ($file_status_array);
?>