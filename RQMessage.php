<?php 
class RQMessage
{
    Private $stxFN;
    Private $type;
    Private $sid;
    Private $checksum;
        
    public $counter;
    public $RQMessageArray=array();

    public function _SetSTX(&$val){
        $stxFN = $val;
    }
    public function _SetType(&$val){
        $type = $val;
    }
    public function _SetSID(&$val){
        $sid = $val;
    }
    public function _SetChecksum(&$val){
        $checksum = $val;
    }  
    public function setCounter0(){
        $this->counter = 0;
    }


    public function _GetSTX(){
        return $this->stxFN;
    }
    public function _GetType(){
        return $this->type;
    }
    public function _GetSID(){
       return $this->sid;
    }
    public function _GetChecksum(){
       return $this->checksum;
    }

    public static function ParseRQMessage(&$RQMessage) : RQMessage
    {
       $AP=new RQMessage();
       $ComponentIndex=0;
       $Components="";
       try
       {
       $Components = explode("|", $RQMessage);
       $counter=count($Components);
       if($counter>0)
       {
       foreach ($AP as $key => &$value) 
       {
        $value=$Components[$ComponentIndex];
        $ComponentIndex++;
        if($ComponentIndex>$counter-1)
        {
            break;
        }
       }
       return $AP;
       } 
       else{
        return NULL;
       }
    }
    catch(Exception $ex)
    {
        echo " Class: ASTMPatient Function: PaesePatient"  .$ex->getMessage();
        return NULL;
    }

    }

    public function display()
    {
      foreach ($this as $key => $value) 
      {
        echo $key."=>".$value;
        echo"\n";
      }
    }
    public function SearchSIDData($sampleid)
    {
        $servername="localhost";
        $username="root";
        $pass="";
        $database="ocm";
        $conn=mysqli_connect($servername,$username,$pass,$database);
        $cr = chr(13);
        $lf = chr(10);
        $blcodes = [];
        $j=0;
        $sql="SELECT * FROM `ocmrequesttestsdetails` WHERE `sampleID`='$sampleid'";
        $result=mysqli_query($conn,$sql);
        $row=mysqli_fetch_assoc($result);
        $res="";
        $deptid = $row['department'];
        $reqid = $row['request'];
        $patid=$row['patient'];
        $sql9="select * from patientifs where id='$patid'";
        $result9=mysqli_query($conn,$sql9);
        $row9=mysqli_fetch_assoc($result9);
        $patdetail=$row9['PatName'];
        $res=$res."TYP:RQ|SID:".$sampleid."|NAM:".$patdetail."|TST:";

        $sql3="SELECT * FROM `ocmrequesttestsdetails` WHERE `sampleID`='$sampleid'";
        $result3=mysqli_query($conn,$sql3);
        $row3=mysqli_fetch_assoc($result3);
        // $testid=$row3['test'];
        $hospitalid = $row3['hospital'];
       echo $sql6 = "SELECT * FROM bl1200testmapping WHERE FacilityID = '$hospitalid'";
        $result6=mysqli_query($conn,$sql6);
        while($row6=mysqli_fetch_assoc($result6)){
            $blcodes[$j] = $row6['BL1200Code'];
            $j++; 
        }
        $codes=[];
        $k=0;
        for ($i=0; $i < $j; $i++) { 
            $sql5="SELECT * FROM `bl1200` WHERE `code`='$blcodes[$i]'";
            $result5=mysqli_query($conn,$sql5);
            $row4=mysqli_fetch_assoc($result5);
            $codes[$k] = $row4['text'];
            $k++;
        }
        $newcodes = array_unique($codes);
        // print_r($newcodes);
        $newcodelen = count($newcodes);
        for ($i=0; $i < $newcodelen; $i++) { 
            $res=$res.$newcodes[$i];
            if($i != ($newcodelen - 1)){
                $res=$res.",";
            }
        }
        $res=$res."|".$cr.$lf;
        return $res;
    }
}
$cr = chr(13);
$lf = chr(10);
$etx = chr(03);

$msg = "FN:03|TYP:LA|SID:90000002|".$cr.$lf."B1";
// $msg = "FN:03|TYP:RQ|SID:90000002|NAM:Ahmed Fatima|TST:Bio,Haem|".$cr.$lf."97";
$AP=new RQMessage();
// echo $chec = $AP->calculateChecksum($msg);
echo "\n";
echo "\n";
echo "\n";
echo "\n";
echo "\n";
$AP = $AP->ParseRQMessage($msg);
$AP->display();
echo $sid = $AP->_GetSID();
echo "\n";
$arrsid = explode(':',$sid);
$sid1 = $arrsid[1];
$res = "FN:03|";
$res1 = $AP->SearchSIDData($sid1);
$res=$res.$res1;
$checksum1 = $AP->calculateChecksum($res);
$res=$res.strtoupper($checksum1).$etx;
echo $res;
?>