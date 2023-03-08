<!DOCTYPE html>
<html lang="en">
<?php include('Asset.php');?>
<style>
    .offcanvas.show {
    transform: none;
    width: 150px !important;
    }
    .offcanvas-start {
        top: 0;
        left: 0;
        width: 400px !important;
        border-right: 1px solid rgba(0,0,0,.2);

    }
    body{
        overflow:hidden !important;
    }
</style>
<body>
    <div class="min-vh-100 container-fluid bg-light p-0">
        <div class="row sticky-top">
            <nav class="navbar navbar-expand-lg py-0 navbar-light bg-danger shadow">
                <div class="container-fluid">
                    <div class="navbar-brand d-flex  align-items-center">
                    <img src="asset/images/bsu.png"  class="img-fluid" width="85">

                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse u-custom-menu u-nav-container" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto  d-flex align-items-center">
                            <li class="nav-item me-4">
                            
                            </li>
                            <li class="nav-item me-4 ">
                                <a style="letter-spacing: 5px" class="h5 text-uppercase fw-monospace text-dark m-0 fw-bold nav-link text-white" >Bulacan State University</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav> 
        </div>
        <div class="row  " > 
            <div class="col-lg-5 mx-auto mt-5">
                <div class="bg-white border mx-4 rounded shadow">
                    <div class="form-group mb-3 bg-danger py-3 d-flex flex-column justify-content-center align-items-center">
                        <h1 class=" text-white m-0"><i class=" fa-solid fa-user"></i></h1>
                    
                    </div>
                    <form id="loginForm">
                                
                        <div class="px-3 pb-5">
                            <div class="mb-3">
                                <input type="hidden" value="false" id="isNewLoginStudent" name="isNewLoginStudent">
                                <label for="username" class="form-label m-0">Username:</label>
                                <input type="text" class="form-control with shadow-none" id="username" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label m-0">Password: </label>
                                <input type="password" name="password" placeholder="*****************" class="with shadow-none form-control" id="password">
                                            
                            </div>   
                            <div class="d-flex flex-sm-row flex-column  justify-content-between mt-2" >
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="showPassword">
                                        <label class="form-check-label" for="showPassword">
                                        Show Password
                                        </label>
                                    </div>
                                </div>                       
                            <div class="form-group  d-flex justify-content-end">
                                       
                                <button type="submit" name="btn_Login" class="col-12 col-lg-3 btn btn-danger"><i class="fa-solid fa-arrow-right-to-bracket me-2"></i>LOGIN</button>   
                            </div>
                        </div>
                    </form>
                                
                </div>
            </div>
        </div>
    </div>
        <script>
            $(document).ready(function(){
                $('#showPassword').click(function(){
                    $(this).is(':checked') ? $('#password').attr('type', 'text') : $('#password').attr('type', 'password');       
                });
                $("#loginForm").on('submit',function(e){
                    
                    e.preventDefault();
                    $("#isNewLoginStudent").val("true");
                    
                    if( $("#isNewLoginStudent").val() === "true"){
                        
                        $.ajax({
                            type:"POST",
                            url:"Script.php",
                            data: new FormData(this),
                            dataType:'json',
                            contentType: false,
                            cache:false,
                            processData:false,
                            success:function(res){
                                $("#isNewLoginStudent").val("false");
                                if(res == "SUCCESS"){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Bulacan State University',
                                        text: 'Login Successfull',
                                        showConfirmButton: false,
                                        showCancelButton: false,
                                        timer:3000
                                    }).then(()=>{
                                        window.location.href ="Typhoon.php";
                                    })
                                } else if(res == "INVALID_PASSWORD"){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Bulacan State University',
                                        text: 'Username or password is incorrect!',
                                        showConfirmButton: false,
                                        showCancelButton: false,
                                        timer:3000
                                    }).then(()=>{
                                        
                                    })
                                } 
                            }
                        });
                    }
                })
            });
        </script>
    </body>
</html>