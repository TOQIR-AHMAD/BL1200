<?php

trait ESaveAction
{
 public $ESaveActionAdd;
 public  $ESaveActionUpdate;
 public function _GetESaveActionAdd():int 
 {
  $ESaveActionAdd=0;
  return $ESaveActionAdd;
 }
 public function _GetESaveActionUpdate():int 
 {
  $ESaveActionUpdate=1;
  return $ESaveActionUpdate;
 }
}

class IQ200
{

  use ESaveAction;
        Private $_SampleId;
        Private $_TestCode;
        Private $_ShortName;
        Private $_LongName;
        Private $_Range;
        Private $_Result;
        Private $_WorklistPrinted;
        Private $_DateTimeOfRecord;
        Private $_Validated;
        Private $_ValidatedBy;
        Private $_Printed;
        Private $_PrintedBy;
        Private $_Unit;
        public $counter;
        public $IQ200Array=array();
      
        public function _SetSampleId(&$Value)
        {
            $this->_SampleId=$Value;
        }
        public function _GetSampleId()
        {
            return $this->_SampleId;
        }
        public function _SetTestCode(&$Value)
        {
           $this->_TestCode=$Value;
        }
        public function _GetTestCode()
        {
            return $this->_TestCode;
        }
        public function _SetShortName(&$Value)
        {
            $this->_ShortName=$Value;
        }
        public function _GetShortName()
        {

            return $this->_ShortName;
        }
        public function _SetLongName(&$Value)
        {
          $this->_LongName=$Value;
        }
        public function _GetLongName()
        {
            return $this->_LongName;
        }
        public function _SetRange(&$Value)
        {
          $this->_Range=$Value;
        }
        public function _GetRange()
        {
            return $this->_Range;
        }
        public function _SetResult(&$Value)
        {
          $this->_Result=$Value;
        }
        public function _GetResult()
        {
            return $this->_Result;
        }
        public function _SetWorklistPrinted(&$Value)
        {
          $this->_WorklistPrinted=$Value;
        }
        public function _GetWorklistPrinted()
        {
            return $this->_WorklistPrinted;
        }
        public function _SetDateTimeOfRecord(&$Value)
        {
          $this->_DateTimeOfRecord=$Value;
        }
        public function _GetDateTimeOfRecord()
        {
            return $this->_DateTimeOfRecord;
        }
        public function _SetValidated(&$Value)
        {
          $this->_Validated=$Value;
        }
        public function _GetValidated()
        {
            return $this->_Validated;
        }
        public function _SetValidatedBy(&$Value)
        {
          $this->_ValidatedBy=$Value;
        }
        public function _GetValidatedBy()
        {
            return $this->_ValidatedBy;
        }
        public function _SetPrinted(&$Value)
        {
          $this->_Printed=$Value;
        }
        public function _GetPrinted()
        {
            return $this->_Printed;
        }
        public function _SetPrintedBy(&$Value)
        {
          $this->_PrintedBy=$Value;
        }
        public function _GetPrintedBy()
        {
            return $this->_PrintedBy;
        }
        public function _SetUnit(&$Value)
        {
          $this->_Unit=$Value;
        }
        public function _GetUnit()
        {
            return $this->_Unit;
        }
        public function _SetCount()
        {
          $this->counter=0;
        }
        public function _GetCount()
        {
          return $this->counter;
        }
        public function _IncrCount()
        {
          $this->counter=$this->counter+1;
        }
    public function PopulateIQ200(&$IQ200Instance,$sql):bool
    {
        if($sql['SampleId']!=NULL)
        {
          $IQ200Instance->_SetSampleId($sql['SampleId']);
        }
        if($sql['TestCode']!=NULL)
        {
          $IQ200Instance->_SetTestCode($sql['TestCode']);
        }
        if($sql['ShortName']!=NULL)
        {
          $IQ200Instance->_SetShortName($sql['ShortName']);
        }
        if($sql['LongName']!=NULL)
        {
          $IQ200Instance->_SetLongName($sql['LongName']);
        }
        if($sql['Range']!=NULL)
        {
          $IQ200Instance->_SetRange($sql['Range']);
        }
        if($sql['Result']!=NULL)
        {
          $IQ200Instance->_SetResult($sql['Result']);
        }
        if($sql['WorklistPrinted']!=NULL)
        {
          $IQ200Instance->_SetWorklistPrinted($sql['WorklistPrinted']);
        }
        if($sql['DateTimeOfRecord']!=NULL)
        {
          $IQ200Instance->_SetDateTimeOfRecord($sql['DateTimeOfRecord']);
        }
        if($sql['Validated']!=NULL)
        {
          $IQ200Instance->_SetValidated($sql['Validated']);
        }
        if($sql['ValidatedBy']!=NULL)
        {
          $IQ200Instance->_SetValidatedBy($sql['ValidatedBy']);
        }
        if($sql['Printed']!=NULL)
        {
          $IQ200Instance->_SetPrinted($sql['Printed']);
        }
        if($sql['PrintedBy']!=NULL)
        {
          $IQ200Instance->_SetPrintedBy($sql['PrintedBy']);
        }
        if($sql['Unit']!=NULL)
        {
          $IQ200Instance->_SetUnit($sql['Unit']);
        }
        return true;
      }
      public function  PopulateIQ200List(&$sql):array
      {
      
         include('connecting.php');
         $count= sqlsrv_has_rows( $sql );
         if($count==false)
         {
          return NULL;
         }
         else{
      
          while($row=sqlsrv_fetch_array($sql,SQLSRV_FETCH_ASSOC))
          {
          
            $NewIQ200=new IQ200();
            $NewIQ200->PopulateIQ200($NewIQ200,$row);
            $this->Add($NewIQ200);
          }
          
          return $this->IQ200Array;
         }

      }
      public function GetIQ200List():array
      {
        include('connecting.php');
       $sql="SELECT *FROM IQ200";
       $res = sqlsrv_query($conn_hq, $sql);
       $this->_SetCount();
       return $this->PopulateIQ200List($res);
      }
      public Function GetIQ200(&$SampleId,&$TestCode):bool
      {
        include('connecting.php');
         $sql="SELECT *FROM IQ200 Where SampleId='$SampleId' and TestCode='$TestCode'";
         $res = sqlsrv_query($conn_hq, $sql);
         $row = sqlsrv_fetch_array( $res, SQLSRV_FETCH_ASSOC);
     
         if($rows = sqlsrv_has_rows( $res )==true)
         {
          $this->PopulateIQ200($this,$row);
          return true;
         }
         else
         {
          return false;
         }
      }
      public function IQ200Exist(&$SampleId,&$TestCode):bool
      {
        include('connecting.php');
         $sql="SELECT *FROM IQ200 Where SampleId='$SampleId' and TestCode='$TestCode'";
         $res = sqlsrv_query($conn_hq, $sql);
     
         if($rows = sqlsrv_has_rows( $res )==true)
         {
          return true;
         }
         else
         {
          return false;
         }
      }
      public function Save(&$ESaveAction) :bool
      {
        include('connecting.php');
        $RowAffected=False;
        $sql="";
        $val1=$this->_GetSampleId();
        $val2=$this->_GetTestCode();
        $val3=$this->_GetShortName();
        $val4=$this->_GetLongName();
        $val5=$this->_GetRange();
        $val6=$this->_GetResult();
        $val7=$this->_GetWorklistPrinted();
        $val8=$this->_GetDateTimeOfRecord();
        $val9=$this->_GetValidated();
        $val10=$this->_GetValidatedBy();
        $val11=$this->_GetPrinted();
        $val12=$this->_GetPrintedBy();
        $val13=$this->_GetUnit();
        switch ($ESaveAction)
        {
          
          case $this->_GetESaveActionAdd():
         echo $sql="insert into IQ200 (SampleId,TestCode,ShortName,LongName,Range,Result,WorklistPrinted
          ,DateTimeOfRecord,Validated,ValidatedBy,Printed,PrintedBy,Unit) values ('$val1','$val2','$val3','$val4','$val5','$val6','$val7','$val8','$val9','$val10','$val11','$val12','$val13')";
          $res = sqlsrv_query($conn_hq, $sql);
          if($res)
          {

          
          return true;
          }
          else{
            return false;
          }
          case $this->_GetESaveActionUpdate():
            $sql="Update IQ200 SET SampleId='$val1',TestCode='$val2',ShortName='$val3',LongName='$val4',Range='$val5',Result='$val6',WorklistPrinted='$val7'
            ,DateTimeOfRecord='$val8',Validated='$val9',ValidatedBy='$val10',Printed='$val11',PrintedBy='$val12',Unit='$val13' Where SampleId='$val1' and TestCode='$val2'";
            $res = sqlsrv_query($conn_hq, $sql);
            return true;
            break;
            return false;
        } 
      }
      public function Add(&$IQ200Obj){
      $this->IQ200Array[$this->counter] = new IQ200();
      $this->IQ200Array[$this->counter]=$IQ200Obj;
      $this->counter++;
      }
      // public function display2()
      // {
      //   for($i=0;$i<$this->counter;$i++)
      //   {
      //    $this->IQ200Array[$i]->display();
      //   }
      // }
      public function display()
      {
        foreach($this as $key=>$value)
        {
          echo $key."=>".$value;
        }
      }

    }
    // for testing
    // $obj=new IQ200();
    // // $id1=13;
    // // $id2="code";
    // // $obj->GetIQ200($id1,$id2);
    // // // $obj->display();
    // // $id=0;
    // // $obj->Save($id);
    // // echo"\n";
    // // $IQ200Array=array();
    // $obj->GetIQ200List();
    // $obj->display2();

    // print_r($IQ200Array);
    // echo"-------------------.\n";
    // $obj->display($IQ200Array[2]);
?>
    