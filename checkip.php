<?php
function sendMsg($id, $msg) {
    echo "id: $id" . PHP_EOL;
    echo "data: $msg" . PHP_EOL;
    echo PHP_EOL;
    ob_flush();
    flush();
  }
include('connecting.php');
$Description="UWAMResultIPAddress";
$sql="Select *From Options Where Description='$Description'";
$res = sqlsrv_query($conn_hq, $sql);
if($res)
{
  $row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC);
  $portable=$row['Contents'];
 }
  $localIP = getHostByName(php_uname('n'));
  if($localIP==$portable)
  {
   
  }
  else{
    include('closeConnection.php');
  }
?>