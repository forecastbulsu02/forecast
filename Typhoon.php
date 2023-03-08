<!DOCTYPE html>
<html lang="en">
    <?php
    date_default_timezone_set('Asia/Kolkata'); 
   
     include('Asset.php');
     include "dbconn.php";
     $page="typhoon";
     if (isset($_POST['btnSave'])) {
        $from_date = $_POST['from_date'];
        $to_date=$_POST['to_date'];
        $typhoon_name = $_POST['typhoon_name'];
        $post = $_POST['fb_post'];
        $kmh = $_POST['kilometer'];
        $mph = $_POST['meter'];
        $kt = $_POST['knots'];
        $to = '/topics/weather';
        $class="";
        $intensity="";
        $category="";
        
        $kilometer = intval($kmh);
        $meter = intval($mph);
        $knots = intval($kt);


        if($knots <= 0 && $meter <= 0 && $kilometer <= 0 ){
              $category = "Low Pressure Area";
              $class = "";
              $intensity = "Low Pressure Area";
        } else if(($knots > 0 && $knots <= 33 ) && ($meter >0 && $meter <= 17) && ($kilometer>0 && $kilometer <= 62) ){
          $category = "Tropical Depression";
          $class = "2";
          $intensity = "Tropical Depression";
        } else if(($knots >= 34 && $knots <= 47 ) && ($meter >= 18 && $meter <= 24) && ($kilometer >= 63 && $kilometer <= 88) ){
          $category = "Tropical Storm";
          $class = "3";
          $intensity = "Typhoon";
        } else if(($knots >= 48 && $knots <= 63 ) && ($meter >= 25 && $meter <= 32) && ($kilometer >= 89 && $kilometer <= 118) ){
          $category = "Severe Tropical Storm";
          $class = "4";
          $intensity = "Typhoon";
        } else if(($knots >= 64 && $knots <= 84 ) && ($meter >= 33 && $meter <= 43) && ($kilometer >= 119 && $kilometer <= 156) ){
          $category = "Typhoon/Hurricane";
          $class = "5";
          $intensity = "Strong Typhoon";
        } else if(($knots >= 85 && $knots <= 104 ) && ($meter >= 44 && $meter <= 53) && ($kilometer >= 157 && $kilometer <= 192) ){
          $category = "Typhoon/Hurricane";
          $class = "5";
          $intensity = "Very Strong Typhoon";
        } else if($knots >= 105 && $meter >= 54 && $kilometer >= 19  ){
          $category = "Typhoon/Hurricane";
          $class = "5";
          $intensity = "Violent Typhoon";
        } 


        $newUserKey = $database->getReference('typhoon')->push()->getKey();    
        $today = date("d, M Y"); // time in India
        
       
        $day1 = date('l, d M, Y', strtotime($from_date));
        $day2 = date('l, d M, Y', strtotime($to_date));
        $description = 'Maganda Araw Maloleños. Mayroon po tayong bagyo na papasok sa ating bansa isang '.$category.' ('.$intensity.') at may pangalan na '.$typhoon_name.' at sa araw na '.$day1.' na mataglay ng lakas na hangin na aabot sa '.$knots.' knots ('.$kilometer.' km/h; '.$meter.' mph) at maari niyong makita and buong ditalye ng bago sa facebook post na ito '.$post.'';
        $postData= [
            'from_date' =>  date('l, d M, Y', strtotime($from_date)),
            'to_date' =>  date('l, d M, Y', strtotime($to_date)),
            'name' => $typhoon_name,
            'kilometer' => $kilometer,
            'meter' => $meter,
            'knots' => $knots,
            'class' => $class,
            'intensity_class' => $intensity,
            'category' => $category,
            'is_active' => true,
            'post' => $post,
            'description' => $description
        
        ];
        $newUserKey = $database->getReference('floods')->push()->getKey();    
        
        $updates = [
            'typhoon/'.$newUserKey => $postData,
        ];    
        
        $data = [
            "is_typhoon_alert" => true,
        ];
    
        $result = $database->getReference('settings/' . $key)->update($data);

        $database->getReference() // this is the root reference
           ->update($updates); 
        $notif = array(
            'title'=>'Typhoon or Hurricane Alert',
            'body'=>$description
        );
        sendNotif($to,$notif);
        header("Refresh:0");
     } else if(isset($_POST['btnUpdate'])){
        $key = $_POST['key'];
        $data = [
          "is_active" => false,
        ];
        
        $result = $database->getReference('typhoon/' . $key)->update($data);
        if ($result) {
            $data2 = [
                "is_typhoon_alert" => false,
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
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-warning ms-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    NEW
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title  fw-bold" id="exampleModalLabel">New Typhoon Alert</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="row ">   
                                    <div class="col-12 col-md-6">
                                        <label for="from_date">From: </label>
                                        <input type="date" class="form-control shadow-none with" name="from_date" id="from_date">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 mt-md-0">
                                        <label for="to_date">To: </label>
                                        <input type="date" name="to_date" id="to_date" class="form-control shadow-none with">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="typhoon_name">Typhoon Name: </label>
                                        <input type="text" name="typhoon_name" placeholder="Example: Juan" id="typhoon_name" class="form-control shadow-none with">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <label for="speed">Maximum Sustained Wind (10-min Mean): </label>
                                    <div class="col-12 col-md-6">
                                        <label for="knots">Knots (kt): </label>
                                        <input type="text" name="knots" id="knots" placeholder="Enter positive or negative numbers" class="form-control shadow-none with">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2 mt-md-0">
                                        <label for="meter">Meter per seconds (m/s): </label>
                                        <input type="text" name="meter" placeholder="Enter positive or negative numbers" id="meter" class="form-control shadow-none with">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="kilometer">Kilometers per hour (km/h): </label>
                                        <input type="text" name="kilometer" placeholder="Enter positive or negative numbers" id="kilometer" class="form-control shadow-none with">
                                    </div>
                                    <div class="col-12  mt-2">
                                        <label for="fb_post">Facebook Post: </label>
                                        <input type="text" name="fb_post" placeholder="https://www.facebook.com/PAGASA.DOST.GOV.PH" id="fb_post" class="form-control shadow-none with">
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
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php

                                $ref = $database->getReference('typhoon');
                                $floods = $ref->getSnapshot()->getValue();
                                if(!empty($floods)){
                                foreach ($floods as $key => $value) {?>
                                <tr>
                                    <th><?=$value['name']?></th>
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
            
             
            </main>
        </div>
       
        <script>

            $(document).ready(function () {
                
            });

        </script>
       
</body>
</html>