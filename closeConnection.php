<?php
include('connecting.php');
$Description="UWAMResultPort";
$sql="Select *From Options Where Description='$Description'";
$res = sqlsrv_query($conn_hq, $sql);
if($res)
{
  $row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC);
  $port=$row['Contents'];
}
$str = exec( "netstat -ano | findstr $port ");
 $str = substr($str,-5);
  exec("taskkill /F /PID $str ");

if(isset($_GET['id'])) {

    if($_GET['id'] == 1 || $_GET['id'] == 2 ) {
      
      $pass = 1;

      if($_GET['id'] == 1) {

       $pass = 2;
      } 
      elseif($_GET['id'] == 2) { 

        header('location:machineconnection.php');

      }
      ?>
   <script>
window.location.replace('Simple.php?id='+'<?=$pass;?>');
</script>
<?php

    } else {

header('location:machineconnection.php');
    }

}

?>