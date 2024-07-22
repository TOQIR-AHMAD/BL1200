<?php 

function calculateChecksum($str)
{
    $crpos = strpos($str, chr(10));
    $ans =$str[1]^$str[2];  
    for ($i = 3; $i <= $crpos; $i++) {
           $ans = $str[$i]^$ans;
    }
    $an1 = bin2hex($ans);
    $an2 = hexdec($an1);
    $bin=255;
    $ans=$bin^$an2;
    $ans = $ans + 1;
    $ans = $ans&$bin;
    $ans = dechex($ans);
    return $ans;
}

$host = "127.0.0.1";
$port = 8080;

$finalmsg="";

set_time_limit(0);
// Create socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// Bind socket to port
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
// Start listening for connections
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
// Accept incoming connections
// spawn another socket to handle communication
$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
// Read client input
$input = socket_read($spawn, 1024) or die("Could not read input\n");
// Clean up input string
$input = trim($input);

$message = "FN:55|TYP:SYN|".chr(13).chr(10)."EA";
$a=calculateChecksum($message);
$lfpos = strpos($message, chr(10));
$etxpos = strpos($message, chr(03));
$getmessage="";
$c1=0;
for ($i=$lfpos+1; $i < $etxpos; $i++) { 
   $getmessage[$c1] = $message[$i];
   $c1++;
}
$cr = chr(13);
$lf = chr(10);
$counter=0;
$num_padded = sprintf("%02d", $counter);

echo strtoupper($a);
if(strcmp(strtoupper($a), $getmessage) == 0){
    $apnaMessage="FN:".$num_padded."|TYP:ACK|CHK:".strtoupper($a)."|".$cr.$lf;
    $b=calculateChecksum($apnaMessage);
    $finalmsg = $apnaMessage.strtoupper($b).chr(03);
    
} else {
    $apnaMessage="FN:".$num_padded."|TYP:NAK|ERR:CS|CHK:".strtoupper($a)."|".$cr.$lf;
    $b=calculateChecksum($apnaMessage);
    $finalmsg = $apnaMessage.strtoupper($b).chr(03);
}

$output = $finalmsg."\n";
socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
// Close sockets
socket_close($spawn);
socket_close($socket);
?>