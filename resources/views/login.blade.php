<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/login.css">

    <title>Login #7</title>
  </head>
  <body>
  

  
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="images/undraw_remotely_2j6y.svg" style="width : 100%;" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign In</h3>
              <p class="mb-4">Selamat datang di website E-Voting</p>
            </div>
            <form action="#" method="post" id="form" enctype="multipart/form-data">
              @csrf
              
                <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">

              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
              </div>

              <input value="Log In" class="btn btn-block btn-primary" onClick="login()" id="submit">

             
            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/sweetalert2@11.js"></script>

    <script>
        let form = document.getElementById("form");
        function login(){
            $.ajax({
                url : "/login",
                method : "POST", 
                contentType : false,
                cache : false,
                processData : false,
                data : new FormData(form),
                success : async (res)=>{



                    let conf = await Swal.fire({
                        title : res.status == 200 ? "Sukses" : "Error",
                        icon : res.status == 200 ? "success" : "error",
                        text : res.message
                    });

                    if(res.status == 200 && conf){
                      window.localStorage.setItem("api-key", res.data.token);
                      window.location.href = (res.data.user.role??"user") == "admin"? "/admin":"/";
                    }
                },
                error : (err)=>{
                    console.log(err);
                    Swal.fire({
                        title : "Error",
                        icon : "error",
                        text : err.responseJSON.message
                    });
                }
            });
        }

     
    </script>
  </body>
</html>