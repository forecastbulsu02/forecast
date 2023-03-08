<!DOCTYPE html>
<html lang="en">
    <?php
     include('Asset.php');
     include "dbconn.php";
     $page="typhoon";
     ?>
<body>
        <div class="container-fluid">
            <?php include('Canvas.php');?>
            <main class="mt-5 pt-5">
                <a href="Typhoon.php" class="ms-1 btn btn-danger">
                    BACK
                </a>
                <div class="row px-3" style="overflow-x:auto;">
                   

                </div>
            
             
            </main>
        </div>
       
        <script>

            $(document).ready(function () {
                
            });
            function displayProfile(e){
            if (e.files[0].type.match('image/jpeg') || e.files[0].type.match('image/png') || e.files[0].type.match('image/jpg')){
                var file = Math.round((e.files[0].size/1024));
                if(file >= 3072) {
                
                }
                else{
                    var reader = new FileReader();
                    reader.onload = function(e){
                        document.querySelector('.profile').setAttribute('src',e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]); 
                } 
            }
            }

        </script>
       
    </body>
</html>