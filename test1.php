<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <link href="custom.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <form method="post" id="form">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 mt-3">
                        <h5 class="card-title">Send Message</h5>
                        <label class="text-start form-control-plaintext">Type a Message</label>
                        <input type="text" class="form-control w-100" id="message" name="message">

                        <div class="buttons pt-2">
                        <button class="btn btn-primary float-start" id="send" type="button" name="req">Send</button>
                        </div>

                    </div>

                </div>


                
                
            </form>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>

    <script> 
          $(document).ready(function() {
            

         $(document).on('click','#send',function(e) {

                
             let myform = document.getElementById("form");
             let data = new FormData(myform);

             $.ajax({

                 url: "sendResults.php",
                 data: data,
                 cache: false,
                 processData: false,
                 contentType: false,
                 type: 'POST',
                
                success: function(data) {
                    
                    $('#message').val('');
                }

             })
              e.preventDefault();



             });       
         
     });

             $(document).on('keypress','#message',function(event) {
        
                  if (event.which == 13) {
                    $('#send').trigger('click');

                        event.preventDefault();
                            return false;

                  }   

          })


    </script>
 


</body>
</html>