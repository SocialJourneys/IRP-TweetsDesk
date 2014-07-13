<?php
session_start();
$session = json_encode($_SESSION);
//session_write_close();

http_response_code(200);
header("Content-Type: application/json");
echo ($session);
?>