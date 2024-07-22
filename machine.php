<?php


$host="127.0.0.10";
$port=88010;


$socket=socket_create(AF_INET,SOCK_STREAM,0)
or die('NOT CREATED');
$result=socket_bind($socket,$host,$port) or die('not binding');//hello
$result=socket_listen($socket,3) or die('not listening');

do
{
$accept=socket_accept($socket) or die('not accept');
$msg=socket_read($accept,1024);
echo $msg;

} while(true);

socket_close($accept,$socket);
 
?>