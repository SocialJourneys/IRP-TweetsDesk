<?php
session_start();
//session_write_close();

http_response_code(200);
header("Content-Type: application/json");
echo json_encode($_SESSION);
?>