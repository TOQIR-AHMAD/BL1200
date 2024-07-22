<?php 
include ('connecting.php');





 $sql="insert into PatientIFs (DateTimeAmended) values (1234,'1245')";
$result=sqlsrv_query($conn_hq,$sql);
 if (($errors = sqlsrv_errors()) != null) {
    foreach ($errors as $error) {
        echo "SQLSTATE: ".$error['SQLSTATE']."<br />";
        echo "code: ".$error['code']."<br />";
        echo "message: ".$error['message']."<br />";
    }
}
if(!$result)
{
    print_r(debug_backtrace());
    // echo "yes";
    // die(print_r( sqlsrv_errors(), true));
    // $error=sqlsrv_errors();
    // foreach($error as $key=>$value)
    // {
    //     echo $key." ".$value;
    // }
}

?>