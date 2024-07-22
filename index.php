<?php
include('connecting.php');
$sql = "SELECT *FROM Options where Description='UWAMResultIPAddress'";
$res = sqlsrv_query($conn_hq, $sql);
$row2 = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
$ip=$row2['Contents'];
$sql = "SELECT *FROM Options where Description='UWAMResultPort'";
$res = sqlsrv_query($conn_hq, $sql);
$row2 = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC);
$port=$row2['Contents'];
if(isset($_POST['save'])||isset($_POST['update']))
{
    
   include('functions.php');
   $ip1=$_POST['server'];
   $port1=$_POST['port'];
   $ip=$ip1;
   $port=$port1;
   $x1="UWAMResultIPAddress";
   $x2="UWAMResultPort";
   SaveOptionSetting($x1,$ip1);
   SaveOptionSetting($x2,$port1);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listener (Results)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="custom.css" rel="stylesheet">

</head>
<style>
        .buttons
        {
            text-align: start;
        }
        #btn1
        {
            margin-top: 14px;
            margin-left :10px ;
            padding: 0px 25px;
        }
        #image {
            float: left;
    display: flex;
    height: 170px;

        }
        .card-title
        {
            margin-left: 170px;
        }
        @media(max-width:730px)
        {
            #btn
            {
               min-width:10%;
            }
        }
    </style>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <form method="post" id="form">
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="card text-center mt-3">
                            <div class="card-body">
                                
                                <div class="card-text">
                                    <div class="wrapper">
                                    <div id="log"></div>
                                    <h5 class="card-title text-start">Listener (Results)</h5>
                                    <img src="./bl1200.png" id="image" alt="">
                                    <label class="text-start form-control-plaintext">IP Address</label>
                                    <input type="text" class="form-control w-25" id="server" name="server" value="<?php echo $ip;?>">
                                    
                                  
                                    <label class="text-start form-control-plaintext mt-2">Port</label>
                                    <input type="text" class="form-control w-25" id="port" name="port" value="<?php echo $port;?>">
                                    
                                       
                                    </div>
                                    
                                </div>
                                <div class="buttons">
                                  
                                <button id="btn1" name="update">Update</button>
                                
                                <button class="btn btn-danger float-end" id="connect" type="button" name="req" style="width:20%">Listen</button>
                                
                                <a id="disconnect" class="btn btn-success d-none float-end" style="width:20%" type="button"href="simple.php?id=1">Disconnect</a>

                                </div>
                                
                            </div>
                            
                        </div>
                  
                    </div>
                </div>


                <div class="wrapper2">
                    <div class="table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <td id="logs"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </form>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
        const btn = document.getElementById('connect');
       
        btn.addEventListener('click', function onClick() {
           
            $('#disconnect').attr('style','display:inline-block !important; width:20%;');
            $('#connect').attr('style','display:none !important;'); 
           const win= window.open('machineconnection.php','_blank');
          // win.close();
    
           
            
        })

        var timeleft = 3;
        var downloadTimer = setInterval(function(){
        if(timeleft <= 0){
            clearInterval(downloadTimer);
            var source = new EventSource("checking.php");
                source.onmessage = function(event){
            }
            timeleft = 3;
            // document.getElementById("countdown").innerHTML = "Finished";

        } else {
            document.getElementById("countdown").innerHTML = timeleft + " seconds remaining";
        }
        timeleft -= 1;
        }, 1000);
              
            
//             function checkConnection(){

//             $.ajax({

//                         url: "check.php",
//                         data: '',
//                         contentType: false,
//                         type: 'POST',
//                         async: false,

//                         success: function(response) {
//                             if(response==1)
//                             {
//                                 btn.style.backgroundColor = 'green';
//                                 btn.style.color = 'white';
//                             }
//                             else{
//                                   btn.style.backgroundColor = 'red';
//                                    btn.style.color = 'white';
//                             }
//                         }

//                 })
//         }

      
//         setInterval(function()
// { 
//     checkConnection();
// },1000);




         var source = new EventSource("server3.php");
             source.onmessage = function(event) {

                if(event.data == 0) {
                    
                    $("#log").html('<img src="./server_off.jpeg"style="float:right" />');

                } else if(event.data > 0 ) {

                    $("#log").html('<img src="./server_on.jpeg"style="float:right" />');
                }
              
             };

            //  var source = new EventSource("checkip.php");
            //  source.onmessage = function(event) {

            //     if(event.data == 0) {
                    
                   

            //     } else if(event.data > 0 ) {

                  
            //     }
              
            //  };
    
        
        var source = new EventSource("connect.php");
        source.onmessage = function(event) {
        $("#logs").prepend(event.data + "<br>");
        };


        });
    </script>


</body>

</html>