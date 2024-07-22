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

$counterFinal =0;
$cr = chr(13);
$lf = chr(10);
$msg = "FN:03|TYP:LA|SID:90000002|".$cr.$lf."B1";
$message = "FN:03|TYP:LA|SID:90000002|".$cr.$lf."B1";
// LogTrace($msg);
//   $message = $msg;
echo $a=calculateChecksum($message);
$lfpos = strpos($message, chr(10));
$etxpos = strpos($message, chr(03));
$getmessage="";
$c1=0;
for ($i=$lfpos+1; $i < $etxpos; $i++) { 
   $getmessage[$c1] = $message[$i];
   $c1++;
}

if($counterFinal > 63){
   $counterFinal = 0;
}
$num_padded = sprintf("%02d", $counterFinal);
if(strcmp(strtoupper($a), $getmessage) == 0){
    $apnaMessage="FN:".$num_padded."|TYP:ACK|CHK:".strtoupper($a)."|".$cr.$lf;
    $b=calculateChecksum($apnaMessage);
    $finalmsg = $apnaMessage.strtoupper($b).chr(03);
} else {
    $apnaMessage="FN:".$num_padded."|TYP:NAK|ERR:CS|CHK:".strtoupper($a)."|".$cr.$lf;
    $b=calculateChecksum($apnaMessage);
    $finalmsg = $apnaMessage.strtoupper($b).chr(03);
}
$counterFinal++;
echo $finalmsg;




//  $cr = chr(13);
//  $lf = chr(10);
// $msg = "FN:34|TYP:WP|SID:4200006|WRK:KC|TRG:HIT_KC|POS:010|".$cr.$lf."BC";
// $lfpos = strpos($msg, chr(10));
// $etxpos = strpos($msg, chr(03));
// $getmessage="";
// $c1=0;
// for ($i=$lfpos+1; $i < $etxpos; $i++) { 
//    $getmessage[$c1] = $msg[$i];
//    $c1++;
// }
// echo $getmessage;
// echo "\n";

// $arrAftersyn=(explode("|",$msg));
// $d = calculateChecksum($msg);
// echo "\n";
// $d=$d."c";
// echo strtoupper($d);

// echo strcmp(strtoupper($d),$getmessage);

// print_r($arrAftersyn);

// if(str_contains($arrAftersyn[1], 'MA')){

// }
// FN:34|TYP:WP|SID:4200006|WRK:KC|TRG:HIT_KC|POS:010|<CR><LF>BC

//  echo $get;

// PHP program to illustrate
// preg_match function
// // Declare a variable and initialize it
// $geeks = 'Welcome ;52 Geeks 4 Geeks.';

// // Use preg_match_all() function to check match
// preg_match_all('!\d+!', $geeks, $matches);

// // print output of function
// echo $matches[0][0];


// // set some variables
// include('checking3.php');

// $host = "192.168.20.217";
// $port = 9005;
// // don't timeout!
// set_time_limit(0);
// // create socket
// $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// // bind socket to port
// $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
// // start listening for connections
// $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
// // socket_set_nonblock($socket);
// socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>1, "usec"=>0));

// // accept incoming connections
// // spawn another socket to handle communication
// while(true){
//     StopWatch::start();
//     $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
//     // socket_set_nonblock($socket);
//     while(true){
//         if(StopWatch::elapsed() >= 0.00000 && StopWatch::elapsed() <= 3.00000 && $input = socket_read($spawn, 1024))
//         {
//                 // read client input
//                 // clean up input string
//                 $input = trim($input);
//                 echo "Client Message : ".$input;
//                 // reverse client input and send back
//                 $output = "ACK";
//                 socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
//                 StopWatch::start();
//         } 
//         if(StopWatch::elapsed() > 3.00000) {
//             $output ="NAK";
//             socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
//             StopWatch::start();
//         }
//     }
// }
// // close sockets
// socket_close($spawn);
// socket_close($socket);
?>