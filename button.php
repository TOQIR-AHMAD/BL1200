<?php 
$server = 'localhost';
$user = 'root';
$pass = '';
$db = 'ocm';
$conn = new mysqli($server, $user, $pass, $db);
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
} 




			$connectionInfo_hq = array("Database"=>"Cavan", "Uid"=>"LabUser", "PWD"=>"DfySiywtgtw$1>)*",'ReturnDatesAsStrings'=> true);
            $conn_hq = sqlsrv_connect('78.46.156.93', $connectionInfo_hq);

            if( $conn_hq ) { 


		              $sql3 = "SELECT top 100 * FROM patientIFs where ocm = 0";
		             $result3 = sqlsrv_query($conn_hq, $sql3);
		             $rrrrow = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC);

					//echo 	count($rrrrow);

		             while ($row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC)) {
		             	
		             		 $row3['Ward'];
		             		//echo '<br>';

		             		if($row3['Ward'] != '') {

	             			 $sql22 = "SELECT * from wards where `text` =  '".$row3['Ward']."' ";
								$res22ult = $conn->query($sql22);
								 $count22 = $res22ult->num_rows;
									//echo '<br>';

								if($count22 == 0) {

								$sql22 = "SELECT max(id)+1 as id from wards ";
								$res222ult = $conn->query($sql22);
								$row111111 = $res222ult->fetch_assoc();
								$ward = $row111111['id'];
								if($ward == '') {

									$ward = 1;
								}
							//	echo '<br>';
										
								 $sql311 = "insert into  wards  (id, Code, Text, InUse, created_at) values ($ward, '".str_replace(' ','_',$row3['Ward'])."', '".$row3['Ward']."', 1, '".date('Y-m-d H:i:s')."' )";
		             			$conn->query($sql311);
		             		//echo '<br>';		

								} else {

									$row1111111 = $res22ult->fetch_assoc();
								 $ward = $row1111111['id'];
									'<br>';	 

									}

								} else {

								$ward = '';

							}


								if($row3['Clinician'] != '') {

								$sql22 = "SELECT * from clinicians where `Text` =  '".$row3['Clinician']."' ";
								$res22222ult = $conn->query($sql22);
								$count22 = $res22222ult->num_rows;

								if($count22 == 0) {

								$sql22 = "SELECT max(id)+1 as id from clinicians ";
								$res2222ult = $conn->query($sql22);
								$row112222211 = $res2222ult->fetch_assoc();
								$clinician = $row112222211['id'];	
								if($clinician == '') {

									$clinician = 1;
								}	

								 $sql32222 = "insert into  clinicians  (id, Code, Text, InUse, created_at) values ($clinician, '".str_replace(' ','_',$row3['Clinician'])."', '".$row3['Clinician']."', 1, '".date('Y-m-d H:i:s')."' )";
		             			$conn->query($sql32222);

								}
								 else {

									$row111111 = $res22222ult->fetch_assoc();
									$clinician = $row111111['id'];

								}

							} else {

								$clinician = '';

							}
                         
                            if($row3['GP_Name'] != '') {

								$sql22 = "SELECT * from gps where `GP_Name` =  '".$row3['GP_Name']."' ";
								$res22222ult = $conn->query($sql22);
								$count22 = $res22222ult->num_rows;

								if($count22 == 0) {
                                
								$sql22 = "SELECT max(id)+1 as id from gps ";
								$res2222ult = $conn->query($sql22);
								$row112222211 = $res2222ult->fetch_assoc();
								$gp = $row112222211['id'];	
								if($gp == '') {

									$gp = 1;
								}	

								  $sql32222 = "insert into  gps  (id,GP_Name,GP_Practice_Address,GP_Medical_Council_Number,GP_Practice_identifier,Facility, InUse,created_at) values ($gp, '".$row3['GP_Name']."', '".$row3['GP_Practice_Address']."','".$row3['GP_Medical_Council_Number']."','".$row3['GP_Practice_identifier']."','".$row3['Facility']."', 1, '".date('Y-m-d H:i:s')."' )";
		             		$conn->query($sql32222);

								}
								 else {

								
                                    $sql32222 = "Update gps set GP_Practice_Address= '".$row3['GP_Practice_Address']."',GP_Medical_Council_Number='".$row3['GP_Medical_Council_Number']."',GP_Practice_identifier='".$row3['GP_Practice_identifier']."',Facility='".$row3['Facility']."', InUse=1,created_at= '".date('Y-m-d H:i:s')."' where`GP_Name`= '".$row3['GP_Name']."'";
                                    if($conn->query($sql32222))
                                    {
                                        
                                    }
								}

							} else {

								$gp = '';

							}





                                $ep=$row3['Episode'];
                                $chart=$row3['Chart'];

                                $sql="SELECT * FROM patientifs WHERE Chart LIKE '$chart' AND Episode LIKE '$ep'";
                                $result=mysqli_query($conn,$sql);
                                $num=mysqli_num_rows($result);
                                if($num==0)
                                {
		             			 $sql3 = "insert into  patientifs (Chart,Episode,DateTimeAmended) values ('".$row3['Chart']."','".$row3['Episode']."','".$row3['DateTimeAmended']."')";
		             		
		             			 if ($conn->query($sql3) === true) { 
                              
		             			  $sql4 = "update  patientifs set
		             			
                                  PatName = '".str_replace("'", '', $row3['PatName'])."',
                                  Sex = '".$row3['Sex']."',
                                  DoB = '".$row3['DoB']."',
                                  Ward = '".str_replace("'", '', $ward)."',
                                  Clinician = '".str_replace("'", '', $clinician)."',
                                  Address0 = '".str_replace("'", '', $row3['Address0'])."',
                                  Address1 = '".str_replace("'", '', $row3['Address1'])."',
                                  Entity = '".$row3['Entity']."',
                                  RegionalNumber = '".$row3['RegionalNumber']."',
                                  DateTimeAmended = '".$row3['DateTimeAmended']."',
                                  NewEntry = '".$row3['NewEntry']."',
                                  AandE = '".$row3['AandE']."',
                                  MRN = '".$row3['MRN']."',
                                  AdmitDate = '".$row3['AdmitDate']."',
                                  GP = '".$row3['GP']."',
                                  eMedRenalFlag = '".$row3['eMedRenalFlag']."',
                                  Address2 = '".str_replace("'", '', $row3['Address2'])."',
                                  Address3 = '".str_replace("'", '', $row3['Address3'])."',
                                  PatSurName = '".str_replace("'", '', $row3['PatSurName'])."',
                                  PatForeName = '".str_replace("'", '', $row3['PatForeName'])."',
                                  PrivatePatient = '".$row3['PrivatePatient']."',
                                  PatTitle = '".$row3['PatTitle']."',
                                  AreaCode = '".$row3['AreaCode']."',
                                  PatPhone = '".$row3['PatPhone']."',
                                  InsurancePolicyNumber = '".$row3['InsurancePolicyNumber']."',
                                  InsurancePolicyExpiry = '".$row3['InsurancePolicyExpiry']."',
                                  InsurancePlanType = '".$row3['InsurancePlanType']."',
                                  InsuranceCompanyName = '".$row3['InsuranceCompanyName']."',
                                  MedicalCardNumber = '".$row3['MedicalCardNumber']."',
                                  ADTmessage = '".$row3['ADTmessage']."',
                                  GP_Practice_Address = '".str_replace("'", '', $row3['GP_Practice_Address'])."',
                                  GP_Practice_identifier = '".$row3['GP_Practice_identifier']."',
                                  GP_Medical_Council_Number = '".$row3['GP_Medical_Council_Number']."',
				             			GP_Name = '".str_replace("'", '', $row3['GP_Name'])."',
				             			HistoryNumber = '".$row3['HistoryNumber']."',
				             			Facility = '".$row3['Facility']."',
				             			Eircode= '".$row3['Eircode']."',
				             			County = '".$row3['County']."',
				             			BedNumber = '".$row3['BedNumber']."',
				             			Consultant= '".$row3['Consultant']."',
				             			DischargeDate = '".$row3['DischargeDate']."',
				             			DischargedTo = '".$row3['DischargedTo']."',
				             			State = '".$row3['State']."'

		             			 where Chart =  '$chart' and DateTimeAmended='".$row3['DateTimeAmended']."' ";

		             		 if ($conn->query($sql4) === true) { 
                                
		             		 		$sql1119 = "update patientIFs set ocm = 1 where Chart = '$chart' and Episode='$ep' ";
				             		sqlsrv_query($conn_hq, $sql1119);
				             		 }
				             		}
					
                                }
                                else{



                 // $sql="SELECT max(DateTimeAmended) as Lastest FROM patientifs WHERE  SUBSTRING(Episode, 0, 1) != 'I' and Chart = '$chart' ";
                 //    $result__=mysqli_query($conn,$sql);
                 //     $row__ = $result__->fetch_assoc();
                 //     $Lastest = $row__['Lastest'];




                 //     $sql = "Delete from patientifs where Chart = '".$row3['Chart']."' and DateTimeAmended != '".$Lastest."'  ";
              			
 


                        if(substr($row3['Episode'], 1) != 'i') {

                        	
                        		
                        }      	

								$sql4 = "update patientifs set 
		             			
		             			PatName = '".str_replace("'", '', $row3['PatName'])."',
		             			Sex = '".$row3['Sex']."',
		             			DoB = '".$row3['DoB']."',
		             			Ward = '".str_replace("'", '', $ward)."',
		             			Clinician = '".str_replace("'", '', $clinician)."',
		             			Address0 = '".str_replace("'", '', $row3['Address0'])."',
		             			Address1 = '".str_replace("'", '', $row3['Address1'])."',
		             			Entity = '".$row3['Entity']."',
		             			RegionalNumber = '".$row3['RegionalNumber']."',
		             			DateTimeAmended = '".$row3['DateTimeAmended']."',
		             			NewEntry = '".$row3['NewEntry']."',
		             			AandE = '".$row3['AandE']."',
		             			MRN = '".$row3['MRN']."',
		             			AdmitDate = '".$row3['AdmitDate']."',
		             			GP = '".$row3['GP']."',
		             			eMedRenalFlag = '".$row3['eMedRenalFlag']."',
		             			Address2 = '".str_replace("'", '', $row3['Address2'])."',
		             			Address3 = '".str_replace("'", '', $row3['Address3'])."',
		             			PatSurName = '".str_replace("'", '', $row3['PatSurName'])."',
		             			PatForeName = '".str_replace("'", '', $row3['PatForeName'])."',
		             			PrivatePatient = '".$row3['PrivatePatient']."',
		             			PatTitle = '".$row3['PatTitle']."',
		             			AreaCode = '".$row3['AreaCode']."',
		             			PatPhone = '".$row3['PatPhone']."',
		             			InsurancePolicyNumber = '".$row3['InsurancePolicyNumber']."',
		             			InsurancePolicyExpiry = '".$row3['InsurancePolicyExpiry']."',
		             			InsurancePlanType = '".$row3['InsurancePlanType']."',
		             			InsuranceCompanyName = '".$row3['InsuranceCompanyName']."',
		             			MedicalCardNumber = '".$row3['MedicalCardNumber']."',
		             			ADTmessage = '".$row3['ADTmessage']."',
		             			GP_Practice_Address = '".str_replace("'", '', $row3['GP_Practice_Address'])."',
		             			GP_Practice_identifier = '".$row3['GP_Practice_identifier']."',
		             			GP_Medical_Council_Number = '".$row3['GP_Medical_Council_Number']."',
		             			GP_Name = '".str_replace("'", '', $row3['GP_Name'])."',
		             			HistoryNumber = '".$row3['HistoryNumber']."',
		             			Facility = '".$row3['Facility']."',
		             			Eircode = '".$row3['Eircode']."',
		             			County = '".$row3['County']."',
		             			BedNumber = '".$row3['BedNumber']."',
		             			Consultant = '".$row3['Consultant']."',
		             			DischargeDate = '".$row3['DischargeDate']."',
		             			DischargedTo = '".$row3['DischargedTo']."',
		             			State = '".$row3['State']."'
		             			 where Chart ='$chart' and DateTimeAmended='".$row3['DateTimeAmended']."' ";
								
								 if ($conn->query($sql4) === true) { 

		             		 		$sql1119 = "update patientIFs set ocm = 1 where Chart = '$chart' and Episode='$ep'";
				             		sqlsrv_query($conn_hq, $sql1119);
		             		 }


						
		             }

		             
            
			

			}
        }



						






?>
<script type="text/javascript">
	setTimeout(function() {
  location.reload();
}, 30000);
</script>