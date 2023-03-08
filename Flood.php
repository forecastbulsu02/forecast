<!DOCTYPE html>
<html lang="en">
    <?php
    date_default_timezone_set('Asia/Kolkata'); 
   
     include('Asset.php');
     include "dbconn.php";
     $page="flood";
     if (isset($_POST['btnSave'])) {
        $high_date = $_POST['high_date'];
        $high_tide_time=$_POST['high_tide_time'];
        $high_meter = $_POST['high_meter'];
        $peak_time = $_POST['peak_time'];
        $low_tide_time = $_POST['low_tide_time'];
        $low_meter = $_POST['low_meter'];
        $to = '/topics/weather';
        
        $ft = doubleval($high_meter) * doubleval(3.28);
        $ft2 = doubleval($low_meter) * doubleval(3.28);
        
        // Create a key for a new user in users table
        // Note: if you have user key then you don't need to create a key
        $newUserKey = $database->getReference('floods')->push()->getKey();    
        $today = date("d, M Y"); // time in India
        
        $highDes = $high_meter.'m / '.$ft.'ft.';
        $lowDes = $low_meter.'m / '.$ft2.'ft.';
        $day = date('l, d M, Y', strtotime($high_date));
        $description = 'Maganda Araw Maloleños ang oras po ng pag taas ng tubig ngayon araw ('.$day.') ay '.date('h:i A',strtotime($high_tide_time)).' at may taas na '.$highDes.' at maaring huminto sa paglaki sa oras na '.date('h:i A',strtotime($peak_time)).' at pag sapit ng '.date('h:i A',strtotime($low_tide_time)).' ang taas ng tubig ay maaring bumaba hanggang '.$lowDes.' Maraming Salamat po!';
        $postData= [
            'date' => $day,
            'high_tide_time' => date('h:i A',strtotime($high_tide_time)),
            'high_meter' => $highDes,
            'peak_time' => date('h:i A',strtotime($peak_time)),
            'low_tide_time' => date('h:i A',strtotime($low_tide_time)),
            'low_meter' => $lowDes,
            'is_active' => true,
            'description' => $description
        
        ];
        // Create a key for a new user in users table
        // Note: if you have user key then you don't need to create a key
        $newUserKey = $database->getReference('floods')->push()->getKey();    
        
        $updates = [
            'floods/'.$newUserKey => $postData,
        ];    
        
        $data = [
            "is_flood_alert" => true,
        ];
    
        $result = $database->getReference('settings/')->update($data);
        $database->getReference() // this is the root reference
           ->update($updates); 
        $notif = array(
            'title'=>'High Tide Alert',
            'body'=>$description
        );
        sendNotif($to,$notif);
        header("Refresh:0");
     } else if(isset($_POST['btnUpdate'])){
        $key = $_POST['key'];
        $data = [
          "is_active" => false,
        ];
        
        $result = $database->getReference('floods/' . $key)->update($data);
        if ($result) {
            $data2 = [
                "is_flood_alert" => false,
            ];
        
            $result2 = $database->getReference('settings/' . $key)->update($data2);
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
                            <h5 class="modal-title  fw-bold" id="exampleModalLabel">New Flood Alert</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                                <div class="row ">   
                                    <div class="col-12">
                                        <label for="high_date">Date: </label>
                                        <input type="date" class="form-control shadow-none with" name="high_date" id="high_date">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="high_tide_time">High Tide Time: </label>
                                        <input type="time" name="high_tide_time" id="high_tide_time" class="form-control shadow-none with">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="high_meter">Height (Meter): </label>
                                        <input type="text" name="high_meter" placeholder="Example: -0.16m or 0.9m" id="high_meter" class="form-control shadow-none with">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                
                                    <div class="col-12">
                                        <label for="peak_time">Peak Time: </label>
                                        <input type="time" name="peak_time" id="peak_time" class="form-control shadow-none with">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="low_tide_time">Low Tide Time: </label>
                                        <input type="time" name="low_tide_time" id="low_tide_time" class="form-control shadow-none with">
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <label for="low_meter">Height (Meter): </label>
                                        <input type="text" name="low_meter" placeholder="Example: -0.16m or 0.9m" id="low_meter" class="form-control shadow-none with">
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
                            <th>Date</th>
                            <th>High Tide</th>
                            <th>Peak Time </th>
                            <th>Low Tide</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php

                                $ref = $database->getReference('floods');
                                $floods = $ref->getSnapshot()->getValue();
                                if(!empty($floods)){
                                foreach ($floods as $key => $value) {?>
                                <tr>
                                    <td><?=$value['date']?></td>
                                    <td><?=$value['high_tide_time']."<br>".$value['high_meter']?></td>
                                    <td><?=$value['peak_time']?></td>
                                    <td><?=$value['low_tide_time']."<br>".$value['low_meter']?></td>
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