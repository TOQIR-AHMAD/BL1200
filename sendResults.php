<?php

$host="192.168.20.218";
$port=9006;
$message='06';
$c_msg=hex2bin($message);


    $socket=socket_create(AF_INET,SOCK_STREAM,0)
    or die('NOT CREATED');
    socket_connect($socket,$host,$port);
    socket_write($socket,$c_msg,strlen($c_msge));
    echo $message=socket_read($socket,1024);
    socket_close($socket);




 
?>