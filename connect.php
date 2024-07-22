<?php
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');
            include('connecting.php');
            function sendMsg($id, $msg) {
                echo "id: $id" . PHP_EOL;
                echo "data: $msg" . PHP_EOL;
                echo PHP_EOL;
                ob_flush();
                flush();
              }
            $name="none";
            $hex="06";
            $symbol=hex2bin($hex);
            $sql = "SELECT Top 2 * FROM TraceBL1200 where Analyser='$name' order by DateTime desc";
            $res = sqlsrv_query($conn_hq, $sql);
            $count1=0;
            $data1="";
            $data="";

          while($row2 = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC))
          {
            $data2=$row2['Analyser'];
              $data=$row2['Trace'];
          
            // $count1++;
            if($data2=="none")
            { 
              $analyser="UWAM";
              $per_analyser="none";
              $sql3="update TraceBL1200 set Analyser= '$analyser' where Analyser='$per_analyser' and Trace='$data'";
              $res3 = sqlsrv_query($conn_hq, $sql3);

              if($data[0] == 'm'){
                $data = ltrim($data, $data[0]);
                sendMsg('Count','S: '.$data); 
              } else {
                sendMsg('Count','R: ' .$data); 
              }
            }
          }
 ?>