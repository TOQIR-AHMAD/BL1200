<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include('connecting.php');
$Description="UWAMResultPort";
$sql="Select *From Options Where Description='$Description'";
$res = sqlsrv_query($conn_hq, $sql);
if($res)
{
  $row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC);
  $portable=$row['Contents'];
}
function sendMsg($id, $msg) {
  echo "id: $id" . PHP_EOL;
  echo "data: $msg" . PHP_EOL;
  echo PHP_EOL;
  ob_flush();
  flush();
}

$output  = array();
$options = ( strtolower( trim( @PHP_OS ) ) === 'linux' ) ? '-atn' : '-an';

ob_start();
system( 'netstat '.$options );

foreach( explode( "\n", ob_get_clean() ) as $line )
{
    $line  = trim( preg_replace( '/\s\s+/', ' ', $line ) );
    $parts = explode( ' ', $line );

    if( count( $parts ) > 3 )
    {
        $state   = strtolower( array_pop( $parts ) );
        $foreign = array_pop( $parts );
        $local   = array_pop( $parts );

        if( !empty( $state ) && !empty( $local ) )
        {
            $final = explode( ':', $local );
            $port  = array_pop( $final );

            if( is_numeric( $port ) )
            {
                $output[ $state ][ $port ] = $port;
            }
        }
    }
 
}

$check = ($output['established']);

if(in_array($portable,$check)) {

  sendMsg('Count', 1);

} else {

  sendMsg('Count', 0);
}

?>