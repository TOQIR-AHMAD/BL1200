<?php

$host="127.0.0.1";
$port=9005;
$message= $_POST['message'];



    $socket=socket_create(AF_INET,SOCK_STREAM,0)
    or die('NOT CREATED');
    socket_connect($socket,$host,$port);
    socket_write($socket,$message,strlen($message));
    //$message=socket_read($socket,1024);
    socket_close($socket);




 
?>