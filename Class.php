<!DOCTYPE html>
<html lang="en">
<?php
    date_default_timezone_set('Asia/Kolkata'); 
   
     include('Asset.php');
     include "dbconn.php";
     $page="class";
     if (isset($_POST['btnSave'])) {
        $from = $_POST['from'];
        $toD=$_POST['to'];
        $link = $_POST['link'];
    
        $newUserKey = $database->getReference('class_suspension')->push()->getKey();    
        $today = date("d, M Y"); // time in India
        
        $fromDate = date('l, d M, Y', strtotime($from));
        $toDate = date('l, d M, Y', strtotime($toD));
        $description = 'Maganda Araw BulSU. Tayo po ay magkakaroon ng Class Suspension na mag sisimula sa araw ng '.$fromDate.' at matatapos sa araw ng '.$toDate.' maari niyo pong macheck sa facebook page post na ito '.$link.'';
        $postData= [
            'from' => $fromDate,
            'to' => $toDate,
            'link' => $link,
            'is_active' => true,
            'description' => $description
        ];
        $newUserKey = $database->getReference('class_suspension')->push()->getKey();    
        
        $updates = [
            'class_suspension/'.$newUserKey => $postData,
        ];    
        
        $data = [
            "is_class_suspension" => true,
        ];
    
        $result = $database->getReference('settings/' . $key)->update($data);
        $database->getReference() // this is the root reference
           ->update($updates); 
        $notif = array(
            'title'=>'Class Suspension Alert',
            'body'=>$description
        );
        $to = '/topics/weather';
        sendNotif($to,$notif);
        header("Refresh:0");
     } else if(isset($_POST['btnUpdate'])){
        $key = $_POST['key'];
        $data = [
          "is_active" => false,
        ];
        
        $result = $database->getReference('class_suspension/' . $key)->update($data);
        if ($result) {
            $data2 = [
                "is_class_suspension" => false,
            ];
        
            $result2 = $database->getReference('settings/')->update($data2);
          header("Refresh:0");
        }
     }
     function sendNotif($to,$notif){
        $apiKey ="AAAArXK0GTY:APA91bFBjUMyItwFrvv7efA_yQzsj-yvunVnlUDTOyZVKDLFin6-ZWSBTwAH_84ngjtep3_GLMfMyq7VJe4IFsnReuhh5VShuAGJGJHuZUqAW_r0DokpVN0kuOdlIEQJXfeEoa2eQuNv";
        $ch = curl_init();
        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = json_encode(array('to'=>$to, 'notification'=>$notif));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        
        $headers = array();
        $headers[] = 'Authorization: key='.$apiKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        }
     ?>
<body>
        <div class="container-fluid">
            <?php include('Canvas.php');?>
            
            <main class="mt-5 pt-5">
                <button type="button" class="btn btn-warning ms-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    NEW
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title  fw-bold" id="exampleModalLabel"> Class Suspension Alert</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="row ">   
                                    <div class="col-12 col-md-6">
                                        <label for="from">From: </label>
                                        <input type="date" class="form-control shadow-none with" name="from" id="from">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 mt-md-0">
                                        <label for="to">To: </label>
                                        <input type="date" name="to" id="to" class="form-control shadow-none with">
                                    </div>
                                    <div class="col-12  mt-2">
                                        <label for="link">Facebook Post: </label>
                                        <input type="text" name="link" placeholder="www.facebook.com/bulsu" id="link" class="form-control shadow-none with">
                                    </div>
                                </div>
                            

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primar" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="btnSave" id="btnSave" class="btn btn-warning">Add</button></form>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row px-3" style="overflow-x:auto;">
                    <table id="table_employee" class=" mt-3 container table align-middle">
                        <thead>
                        <tr class="table-row-employee">
                            <th>From</th>
                            <th>To</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php

                                $ref = $database->getReference('class_suspension');
                                $floods = $ref->getSnapshot()->getValue();
                                if(!empty($floods)){
                                foreach ($floods as $key => $value) {?>
                                <tr>
                                    <td><?=$value['from']?></td>
                                    <td><?=$value['to']?></td>
                                    <td>
                                        <a href="<?=$value['link']?>" class="btn btn-primary">  
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg>
                                   
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                            $status = $value['is_active'];
                                            if($status){ ?>
                                                <p class="text-danger">ACTIVE</p>
                                        <?php } else { ?>
                                                <p class="text-success">NOT ACTIVE</P>
                                        <?php } ?>
                                    
                                    </td>
                                    <td>
                                        <?php 
                                           $status = $value['is_active'];
                                          if($status){?>
                                            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                                <input type="text" hidden name="key" value=<?=$key?>>
                                                <button name="btnUpdate" class="btn btn-warning">UPDATE</button>
                                            </form>
                                        <?php } else {?>
                                          <button type="button" class="btn btn-success">DONE</button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php
                                 }   
                                }
                            ?>

                        </tbody>
                        
                    </table>

                </div>
            <p></p> 
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