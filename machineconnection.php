 <?php
 include('connecting.php');
 include('functions.php');
 include('checking3.php');
 include('RQMessage.php');

 $Orderid="";
 $TestRequests=True;
 function setdemographics($sid)
 {
     date_default_timezone_set("Europe/Dublin");
    $date=date("Y-m-d h:i:s");
    $servername="localhost";
    $username="root";
    $pass="";
    $database="ocm";
    $conn=mysqli_connect($servername,$username,$pass,$database);
    $codes = [];
    $longname=[];
    $j=0;
    $sql="SELECT * FROM `ocmrequesttestsdetails` WHERE `sampleID`='$sid'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $hospitalid=$row['hospital'];
    $patientid=$row['patient'];
    echo $sql2="SELECT * FROM `patientifs` WHERE `id`='$patientid'";
    $result2=mysqli_query($conn,$sql2);
    $row2=mysqli_fetch_assoc($result2);
    $chart=$row2['Chart'];
    $Episode=$row2['Episode'];
    include('connecting.php');
    echo $sql="Select *from PatientIFs where Episode='$Episode' and Chart='$chart'";
    $res = sqlsrv_query($conn_hq, $sql);
    $row3=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC);
    $name=$row3['PatName'];
    $sex=$row3['Sex'];
    $dob=$row3['DoB'];

    $age="23";
    $ward=$row3['Ward'];
    $clinician=$row3['Clinician'];
    $add0=$row3['Address0'];
    $add1=$row3['Address1'];
    $gp=$row3['GP_Name'];
    $fname=$row3['PatForeName'];
    $sname=$row3['PatSurName'];
    $sql4="SELECT * FROM `facilities` WHERE `id`='$hospitalid'";
    $result4=mysqli_query($conn,$sql4);
    $row4=mysqli_fetch_assoc($result);
    $hospital=$row4['name'];
 
    echo $sql5="insert into demographics (SampleID,Chart,PatName,Age,Sex,DoB,Addr0,Addr1,Ward,Clinician,GP,Hospital,SurName,ForeName,DateTimeDemographics) values ('$sid','$chart','$name','$age','$sex','$dob','$add0','$add1','$ward','$clinician','$gp','$hospital','$sname','$fname','$date')";
    $res5 = sqlsrv_query($conn_hq, $sql5);

 }
function getdata($sid)
{
    $servername="localhost";
    $username="root";
    $pass="";
    $database="ocm";
    $conn=mysqli_connect($servername,$username,$pass,$database);
    $codes = [];
    $longname=[];
    $j=0;
    $sql="SELECT * FROM `ocmrequesttestsdetails` WHERE `sampleID`='$sid'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result))
    {

        $sampletype=$row['sampletype'];
        $sql3="select * from lists where id='$sampletype' AND ListType='STP'";
        $result3=mysqli_query($conn,$sql3);
        $row2=mysqli_fetch_assoc($result3);
        $code=$row2['Code'];//sampletype
        $unit=$row['units'];//units
        $deptid=$row['department'];
        $sql4="select * from lists where id='$deptid' AND ListType='DPT'";
        $result4=mysqli_query($conn,$sql4);
        $row3=mysqli_fetch_assoc($result4);
        $deptcode=$row3['Code']; //dep 
      $testid=$row['test'];
        $sql5="SELECT * FROM `testdefinitions` WHERE `id`='$testid'";
        $result5=mysqli_query($conn,$sql5);
        $row4=mysqli_fetch_assoc($result5);
        $codes[$j]=$row4['shortname'];
        $longname[$j]=$row4['longname'];
        $j++;   
    }
   
date_default_timezone_set("Europe/Dublin");

include('connecting.php');
for($i=0;$i<$j;$i++)
{
    $date=date("Y-m-d h:i:s");
    $testid=$codes[$i];
    if($deptcode=='Bio')
    {
        $sql="insert into BioRequests (SampleID,Code,SampleType,DateTimeOfRecord) values('$sid','$testid','$code','$date')";
        $res = sqlsrv_query($conn_hq, $sql);

    }
    if($deptcode=='Coag')
    {
        $sql="insert into CoagRequests (SampleID,Code,Units,DateTime) values('$sid','$testid','$unit','$date')";
         $res = sqlsrv_query($conn_hq, $sql);
    
    }
    if($deptcode=='Haem')
    {
        $sql="insert into HaemRequests (SampleID,OrderString,DateTimeOfRecord) values('$sid','$testid','$date')";
        $res = sqlsrv_query($conn_hq, $sql);
    }
    if($deptcode=='Ext')
    {
        $testid=$longname[$i];
        $testid2=$codes[$i];
        $sql="insert into ExtResults (SampleID,Analyte,Units) values('$sid','$testid','$unit')";
        $res = sqlsrv_query($conn_hq, $sql);
        $sql2="insert into BiomnisRequests(SampleID,TestCode,TestName,SampleType,Department,SendTo,DateTimeOfRecord) values('$sid','$testid2','$testid','$code','Ext','BL1200','$date')";
        $res2 = sqlsrv_query($conn_hq, $sql2);
    }
}

}
 function findclient()
 {
  
include('connecting.php');
$Description="UWAMResultPort";
$sql="Select *From Options Where Description='$Description'";
$res = sqlsrv_query($conn_hq, $sql);
if($res)
{
  $row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC);
  $portable=$row['Contents'];
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

 return 0;

} else {

  return 1;
}

 }
 function Explicit($arr):string
 {
 $array=(explode("|",$arr));
 unset($array[0]);
 $msg2=implode("|",$array);
 return $msg2;
 }
 function parsemessage($msg)
{
 $parsemessage=explode('|',$msg);
 $msg=$parsemessage[2];
 $ETX="03";
 $ETX=hex2bin($ETX);
 $msg=str_replace($ETX,'',$msg);
 $msg=str_replace(' ','',$msg);
 return $msg;
}
 function checksymbol($msg)
 {
     $arr=(explode("|",$msg));
     $str1=$arr[0];
    $arr1 = str_split($str1);
    $count=count($arr1);
    $msg2=$arr1[$count-1];
    return $msg2;
 }
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
 function getlastCounter(){
    $counterFinal=0;
    include('connecting.php');
    $sql="Select TOP 1* From TraceBL1200 Where Trace like 'm%' order by DateTime desc";
    $res = sqlsrv_query($conn_hq, $sql);
    if($res)
    {
        $row=sqlsrv_fetch_array($res,SQLSRV_FETCH_ASSOC);
        $getTrace=$row['Trace'];
    }
    preg_match_all('!\d+!', $getTrace, $matches);
    if($matches[0][0] == 63){
        $counterFinal = 0;
    } else {
        $counterFinal = $matches[0][0] + 1;
    }

    return $counterFinal;
 }

 $ENQ="05";
 $EOT="04";
 $ETX="03";
 $ACK="06";
  $x1="UWAMResultIPAddress";
  $x2="UWAMResultPort";
  $val1="127.0.0.1";
  $val2="8080";
  $counterFinal=0;
  $checkMsgFlag=0;
  $finalmsg="ACK";
 $host=GetOptionSetting($x1,$val1);
 $port=(int)GetOptionSetting($x2,$val2);

 $socket=socket_create(AF_INET,SOCK_STREAM,0)
 or die('NOT CREATED');
 $result=socket_bind($socket,$host,$port) or die('not binding');
 $result=socket_listen($socket,3) or die('not listening');
//  socket_set_option($socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>1, "usec"=>0));
 $data="";
 $counteriterate=0;
 $counterFinal = getlastCounter();
 $sendDatamsg = "";
 $cr = chr(13);
 $lf = chr(10);

 while(true)
 {    
 $accept=socket_accept($socket);
//  StopWatch::start();

 while(true){
    $message = socket_read($accept, 1024);
    // if(StopWatch::elapsed() >= 0.00000 && StopWatch::elapsed() <= 3.00000 && $message!="" && $counteriterate >= 1){
    //     $output ="NAK";
    //     socket_write($accept, $output, strlen ($output));
    // }
    // if((StopWatch::elapsed() > 3.00000 && $message!="") || $counteriterate==0) {

    if($message!="")
    {
     $data=1;
     $msg = $message;

   //   $message="FN:02|TYP:SYN|".chr(13).chr(10)."EC";
     $msg = "FN:03|TYP:LA|SID:90000005|".$cr.$lf."B8";
     $message = "FN:03|TYP:LA|SID:90000005|".$cr.$lf."B8";
     LogTrace($msg);
   //   $message = $msg;
     $a=calculateChecksum($message);
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
     $finalmsg1="m".$finalmsg;
     LogTrace($finalmsg1);

     $RQM = new RQMessage();
     $RQM = $RQM->ParseRQMessage($msg);

     $getmsgtype = $RQM->_GetType();
     $arrmsgtype = explode(':',$getmsgtype);
     $arrmsgtype1 = $arrmsgtype[1];

     if(strcmp($arrmsgtype1, "LA") == 0){  
        $sid = $RQM->_GetSID();
        $arrsid = explode(':',$sid);
        $sid = $arrsid[1];
        $counterFinal++;
        $num_padded = sprintf("%02d", $counterFinal);

        if(is_numeric($sid) == 1){
            $res1 = $RQM->SearchSIDData($sid);
            $apnaMessage="FN:".$num_padded."|".$res1;
            $checksum1 = calculateChecksum($apnaMessage);
            $sendDatamsg = $apnaMessage.strtoupper($checksum1).$etx;
            $sendDatamsg1 = "m".$sendDatamsg; 
            LogTrace($sendDatamsg1);
        }
    }

     socket_write($accept,$finalmsg,strlen($finalmsg));
     if(strcmp($arrmsgtype1, "LA") == 0){  
        socket_write($accept,$sendDatamsg,strlen($sendDatamsg));
        getdata($sid);
        setdemographics($sid);
     }
     $counteriterate++;
     $counterFinal++;

    //  StopWatch::start();
    }  
    // else if($message!=""){
    //     $msg = $message;
    //     $arrAftersyn=(explode("|",$msg));
    // }
// }
$check = findclient();
if($check == 1){
break;
} else {

} 
 }
}
 socket_close($socket);
 ?> 

