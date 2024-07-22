
 <?php
 // header('Content-Type: text/event-stream');
 // header('Cache-Control: no-cache');
 
 
 include('mode.php');
 include('IQ200.php');
 include('IQ200TestDefination.php');
 include('Obervation.php');
 include('connecting.php');
 include('functions.php');
 
 // $IQ200Arr=array();
 // $ObservationArr=array();
 // $counter1=0;
 // $counter2=0;
 $Orderid="";
 $TestRequests=True;
 // function AddIQ200(&$IQ200):bool
 // {
     
 //    // $counter=$GLOBALS['counter1'];
 //     $IQ200Arr[$GLOBALS['counter1']] = new IQ200();
 //     $IQ200Arr[$GLOBALS['counter1']]=$IQ200;
 //     $GLOBALS['counter1']=$GLOBALS['counter1']+1;
 //     return true;
    
 // }
 // function AddComments(&$Ob)
 // {
 //     $counter=$GLOBALS['counter2'];
 //     $ObservationArr[$counter] = new Observation();
 //     $ObservationArr[$counter]=$Ob;
 //     $GLOBALS['counter2']=$GLOBALS['counter2']+1;
 
 // }
 function Explicit($arr):string
 {
 $array=(explode("|",$arr));
 unset($array[0]);
 $msg2=implode("|",$array);
 return $msg2;
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
 
 
  $x1="UWAMResultIPAddress";
  $x2="UWAMResultPort";
  $val1="192.168.0.1";
  $val2="8080";
 $host=GetOptionSetting($x1,$val1);
 $port=(int)GetOptionSetting($x2,$val2);
 $socket=socket_create(AF_INET,SOCK_STREAM,0)
 or die('NOT CREATED');
 $result=socket_bind($socket,$host,$port) or die('not binding');
 $result=socket_listen($socket,3) or die('not listening');
 $IQ=new IQ200();
 $IQ->_SetCount();
 $Observation=new Observation();
 $Observation->_SetCount();
 while(true)
 {    
 $accept=socket_accept($socket) or die('not accept');
 $msg=socket_read($accept,1024);
 
 $data="NACK";
 
             if($TestRequests)
             {
                 if($Orderid!="")
                 {
                     $TestRequests=False;
                 }
 
             }
             $flag=0;//flag for termination condition
             $DATA=$msg;
              //check which element ha sbeen sended
              $msg=checksymbol($DATA);
              $msg2=Explicit($DATA);
              $msg2=$msg."|".$msg2;
                     if($msg == 'ENQ') {
                         
                         $data="ENQ";
                         
                     }
 
                     else if($msg == 'H') {
 
                         
                         $data="Header-ACK";
                         
                     }
 
                     else if($msg == 'O') {
                        
                         $obj=new ASTMOrder();
                         $obj=$obj->ParseOrder($msg2);
                         $Orderid=$obj->_GetSpecimenID();
                         if(is_numeric($Orderid))
                         {
                            
                             $data="Order-ack";     
                             
                         }
                         else
                         {
                             $data="NACK";
                             $Orderid ="";
                         }
                         
                        
                     }
                     else if($msg=='P')
                     {
                         
                         $data="Pat-ACK";
                         // $sql="insert into log (logs,val) values ('$data',1)";
                         // $res = sqlsrv_query($conn_hq, $sql);
                     }
 
                     else if($msg == 'R') {
                     
             $obj = new ASTMResult();
             $obj = $obj->ParseResult($msg2);
             $finalResult="";
             $result=$obj->_GetDataMeasurement();
             $sep="^";
             $num=1;
             $m=GetStringComponent($result,$sep,$num);
             $result1=trim($m," ");
             if($result1=="RAW"&&$Orderid!="")
             {
                 
               $UrineResult = New IQ200();
               $UrineResult->_SetSampleId($Orderid);
               $UtestId=$obj->_GetUniversalTestID();
               $UtestId1=str_replace("^^^","",$UtestId);
               $sep = "^";
               $num = 0;
               $UtestId2 = GetStringComponent($UtestId1, $sep, $num);
               $UrineResult->_SetTestCode($UtestId2);
               $finalResult=GetStringComponent($result,$sep,$num);
               if(is_numeric($finalResult))
               {
 
               }
               else{
                 $finalResult="";
               }
             
             
             $TD=new IQ200TestDefinition();
             if($TD->GetIQ200TestDefinition($UtestId2))
             { 
                 $SN=$TD->_Getshortname();
                 $LN=$TD->_Getlongname();
                 $range=$obj->_GetReferenceRanges();
                 $unit=$TD->_Getunits();
                 $val=false;
                 $val2="";
                 $UrineResult->_SetShortName($SN);
                 $UrineResult->_SetLongName($LN);
                 $UrineResult->_SetResult($finalResult);
                 $UrineResult->_SetRange($range);
                 $UrineResult->_SetWorklistPrinted($val);
                 $date=$obj->_GetDateTimeTestCompleted();
                 $dateandtime=ParseDateyyyyMMddhhmmss($date);
                 $UrineResult->_SetDateTimeOfRecord($dateandtime);
                 $UrineResult->_SetValidated($val);
                 $UrineResult->_SetPrinted($val);
                 $UrineResult->_SetValidatedBy($val2);
                 $UrineResult->_SetPrintedBy($val2);
                 $UrineResult->_SetUnit($unit);
                 //$UrineResult->_SR($sr+1);
             }
              
             // $array = array();
             //  AddIQ200($UrineResult);
              
             //  $array[] = $UrineResult;
             //  $array[] = $UrineResult;
             //  session_start();
             //  $_SESSION['results1'] = $array;
             
             $data="Result-ACK";
             $IQ->Add($UrineResult);
 
 
             //  $data=$sr;
         }
         }
 
     
 
                     elseif($msg == 'C') {
                         $obj=new ASTMComment();
                         $obj=$obj->ParseComment($msg2);
                         if($Orderid!="")
                         {
                             $OB=new Observation();
                             if(is_numeric($Orderid))
                             {
                               $OB->_SetSampleID($Orderid);
                             }
                             $dicipline="MicroGeneral";
                             $com=$obj->_GetCommentText();
                             $sep="^";
                 $num = 1;
                 $data2 = GetStringComponent($com, $sep, $num);
                 $comment= strtok($data2,  '<');
                             $date=date("Y/m/d")." ".date("h:i:sa");
                             $username="UWAM";
                             $OB->_SetDiscipline($dicipline);
                             $OB->_SetComment($comment);
                             $OB->_SetDateTimeOfRecord($date);
                             $OB->_SetUserName($username);
                             $data="Com-ACK";
                             $Observation->Add($OB);
                             //$OB->display();
 
                         }
                     }
                      else if($msg=='Q')
                      {
                         $AQ=new ASTMQuery();
                         $AQ=$AQ->ParseQuery($msg2);
                         $Srange=$AQ->_GetStartingRangeIDNumber();
                         if(is_numeric($range))
                         {
                             $Orderid=$range;
                             $TestRequests=true;
                             $data="Query-ACK";
 
                         }
                         else
                         {
                             $Orderid="";
                             $TestRequests=False;
                             $data="Query-Nack";
                         }
                          
 
 
                      }
                      elseif($msg == 'L') {
                           
                         $message = 'End of Machine';
                         $AL=new ASTMTerminator();
                         $AL=$AL->ParseTerminator($msg2);
                        if($Orderid!="")
                        {
                         $counter1=$IQ->_GetCount();
                         for($j=0;$j<$counter1;$j++)
                         {
                             $IQ200obj=new IQ200;
                             $IQ200obj=$IQ->IQ200Array[$j];
                             $id=$IQ200obj->_GetSampleId();
                             $code=$IQ200obj->_GetTestCode();
                             if($IQ200obj->IQ200Exist($id,$code))
                             {
                                 $bit=1;
                             }
                             else{
                                 $bit=0;
                             }
                             $IQ200obj->Save($bit);
                         }
                         $counter2=$Observation->_GetCount();
                         echo $counter2;
                         for($i=0;$i<$counter2;$i++)
                         {
                             $Observations=new Observation();
                             $Observations=$Observation->ObservationArray[$i];
                             $id=$Observations->_GetSampleID();
                             $code="MicroGeneral";
                             $Obs=new Observation();
                             if($Obs->GetObservation($id)==true)
                             {
                                 $str1=$Obs->_GetComment();
                                 $str2=$Observations->_GetComment();
                                 if (strpos($str1,$str2)==false)
                                 {
                                 $str3=$str1." ".$str2;
                                 $Observations->_SetComment($str3);
                                 $bit=1;
                                 }
                                 else{
                                     $bit=3;//data not to be inserted
                                 }
                             }
                             else{
                                 $bit=0;
                             }
                             if($bit>1)
                             {
 
                             }
                             else
                             {
                             $Observations->Save($bit);
                             }
                         }
                        }
                         $data="terminate";
                         $flag=1;
                     } 
                     else {
 
                         $message = $msg;
                     } 
                     if($msg=="")
                     {
 
                     }
                     else 
                     {
                       socket_write($accept,$data,strlen($data));
                       LogTrace($msg2,$Orderid);
               
                     }
                      if($flag==1)
                      {
 
                             $IQ=new IQ200();
                             $IQ->_SetCount();
                             $Observation = new Observation();
                             $Observation->_SetCount();
                             //clear log table where ack is store to store new graph of data
                             $Orderid="";
                             $TestRequests=True;
                             socket_write($accept,$data,strlen($data));
                             LogTrace($msg2,$Orderid);
                             
                      }            
 }
 socket_close($socket);
 ?> 
 