
			 <?php
			$serverName = "WIN-VSRLG0S17CC";
			$connectionInfo = array( "Database"=>"CavanTest",
									 "UID"=>"CSSQL",
									 "PWD"=>"Custom@321",
									 "Encrypt"=>true,
									 "TrustServerCertificate"=>true,
									 'ReturnDatesAsStrings'=> true);
			$conn_hq = sqlsrv_connect( $serverName, $connectionInfo);

			 ?>