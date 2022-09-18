<?php

    include 'database.php';

    $obj = new query();

    if(isset($_POST['add_info']))
    {
        $sname = $obj->get_safe_string($_POST['sname']);
        $saddress = $obj->get_safe_string($_POST['saddress']);
        $sphone = $obj->get_safe_string($_POST['sphone']);

        if (isset($_FILES['simage'])) {
            $simage_name = $_FILES['simage']['name'];

            $simage_tmp_name = $_FILES['simage']['tmp_name'];

            $file_size = $_FILES['simage']['size'];

            $permitted = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'docx', 'pptx');

            $ext_div = explode('.', $simage_name );
            $ext = strtolower(end($ext_div));

            date_default_timezone_set("Asia/Dhaka");

            $unique_name = date('d_m_Y_H_i_sa') . '.' . $ext;

            if($simage_name == null){
                $condition_arr = array('sname'=>$sname, 'saddress' => $saddress, 'sphone'=>$sphone);
                
                $result = $obj->insertData('student', $condition_arr);
                header('location: index.php');
            } elseif($file_size > 3145728){
                $msg = "File size must be less then 3 MB";
            } elseif (in_array($ext, $permitted) == false) {
                $msg = "<i>You can upload only " . implode(', ', $permitted) . "</i>";
            } else {
                move_uploaded_file($simage_tmp_name, 'image/'. $unique_name);

                $condition_arr = array('sname'=>$sname, 'saddress' => $saddress, 'sphone'=>$sphone, 'simage' => $unique_name);
                
                $result = $obj->insertData('student', $condition_arr);
                header('location: index.php');
            }

        }
        
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>CRUD | OOP |APP</title>
</head>
<body>
    <div class="container my-4 p-4 shadow">
        <h2><a class="text-decoration-none" href="index.php">Student Database</a></h2>
        <form class="form" action="add.php" method="post" enctype="multipart/form-data">
        
            <?php

                if(isset($msg)){
            ?>
                
                <div class="alert alert-danger show fade fw-bold p-1">
                    <?php
                        echo $msg;
                    ?>
                </div>

            <?php
                }            
            ?>
        
            <input class="form-control mb-2" type="hidden" name="sid" id="" value="">
            <input class="form-control mb-2" type="text" name="sname" id="" value="">
            <input class="form-control mb-2" type="text" name="saddress" id="" value="">
            <input class="form-control mb-2" type="number" name="sphone" id="" value="">

            <label for="image">Upload Your Image</label>

            <input class="form-control mb-2" type="file" name="simage" id="">

            <input class="form-control bg-warning" type="submit" value="Add Information" name="add_info">
    
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>