<?php
$servername="localhost";
$username="root";
$pass="";
$database="ocm";
$conn=mysqli_connect($servername,$username,$pass,$database);
$connectionInfo_hq = array("Database"=>"Midlands",'ReturnDatesAsStrings'=> true);
             $conn_hq = sqlsrv_connect('localhost', $connectionInfo_hq);            
$sql="SELECT * FROM ocmrequest where RequestState='In Progress' OR RequestState='Results Ready' OR RequestState='Sent to the lab'";
   $result=mysqli_query($conn,$sql);
   while($row=mysqli_fetch_assoc($result))
   {
    $reqid=$row['ReqestID'];
    $sql5="SELECT * FROM results where request='$reqid'";
   $result5=mysqli_query($conn,$sql5);
   while($row5=mysqli_fetch_assoc($result5))
   {
     $sampid=$row5['sampleid'];
     $cod=$row5['Code'];
    $sql2="SELECT *FROM HaemResults50 Where SampleID='$sampid' and Code='$cod'";
    $res = sqlsrv_query($conn_hq, $sql2);
    if(sqlsrv_has_rows($res)==true)
    {
    $row2 = sqlsrv_fetch_array( $res, SQLSRV_FETCH_ASSOC);
    echo $sampleid=$row2['SampleID'];
    $code=$row2['Code'];
    $result=$row2['Result'];
    $flag=$row2['Flags'];
    $units=$row2['Units'];
    $Runtime=$row2['RunDateTime'];
    $username=$row2['UserName'];
    $sampletype=$row2['SampleType'];
    $analyser=$row2['Analyser'];
    $comment=$row2['Comment'];
    $rangeindex=$row2['RangesIndex'];
    $datetimeofrecord=$row2['DateTimeOfRecord'];
    $defindex=$row2['DefIndex'];
    $valtime=$row2['ValidateTime'];
    $signoff=$row2['SignOff'];
    $signoffby=$row2['SignOffBy'];
    $signoffdatetime=$row2['SignOffDateTime'];

    $sql3="SELECT *from results where sampleid='$sampleid'and Code='$code'";
    $result3=mysqli_query($conn,$sql3);
    $rowcount=mysqli_num_rows($result3);
    if($rowcount>0)
    {
        $sql4="Update results set result='$result',ValidateTime='$valtime',Flags='$flag',Units='$units',SampleType='$sampletype',Analyser='$analyser',SignOff='$signoff',SignOffBy='$signoffby',SignOffDateTime='$signoffdatetime',Comment='$comment',DefIndex='$defindex',resulted=1 where sampleid='$sampleid' and Code='$code'";
        $result4=mysqli_query($conn,$sql4);

    }
    else{

        $sql4="insert into results (sampleid,Code,result,ValidateTime,Flags,Units,SampleType,Analyser,SignOff,SignOffBy,SignOffDateTime,Comment,DefIndex,resulted) values('$sampleid','$code','$result','$valtime','$flag','$units','$sampletype','$analyser','$signoff','$signoffby','$signoffdatetime','$comment','$defindex',1)";
         $result4=mysqli_query($conn,$sql4);
         if($result4)
         {
            
         }
    }



    }


}
$counter=0;
$sql6="SELECT * FROM results where request='$reqid'";
$result6=mysqli_query($conn,$sql6);
$rowcount2=mysqli_num_rows($result6);
while($row6=mysqli_fetch_assoc($result6))
{
    $resulted=$row6['resulted'];
    if($resulted==1)
    {
       $counter++;
    }
}
if($counter==$rowcount2)
{
    $sql7="update ocmrequest set RequestState='Results Ready' where ReqestID='$reqid'";
    mysqli_query($conn,$sql7);
}

   }
?>