<?php

    include 'database.php';

    $obj = new query();

    if(isset($_GET['status']) AND $_GET['status'] == 'edit')
    {
        $id = $obj->get_safe_string($_GET['id']);

        $condition_arr = array('sid'=>$id);
        $result = $obj->getData('student', '*',$condition_arr);

    }

    if(isset($_POST['update_info']))
    {
        $sname = $obj->get_safe_string($_POST['sname']);
        $saddress = $obj->get_safe_string($_POST['saddress']);
        $sphone = $obj->get_safe_string($_POST['sphone']);

        if (isset($_FILES['simage'])) {
            $old_image = $_POST['old_image'];

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
                
                $result = $obj->updateData('student', $condition_arr, 'sid', $id);
                header('location: index.php');
            } elseif($file_size > 3145728){
                $msg = "File size must be less then 3 MB";
            } elseif (in_array($ext, $permitted) == false) {
                $msg = "<i>You can upload only " . implode(', ', $permitted) . "</i>";
            } else {
                if (isset($old_image)) {
                    $old_image = 'image/' . $old_image;
                    unlink($old_image);
                }
                move_uploaded_file($simage_tmp_name, 'image/'. $unique_name);

                $condition_arr = array('sname'=>$sname, 'saddress' => $saddress, 'sphone'=>$sphone, 'simage' => $unique_name);
                
                $result = $obj->updateData('student', $condition_arr, 'sid', $id);
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
        <form class="form" action="" method="post" enctype="multipart/form-data">
        
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

        <?php

        if(isset($result[0])){
            foreach($result as $value){
        ?>
        
            <input class="form-control mb-2" type="hidden" name="sid" id="" value="<?php echo $value['sid'] ?>">
            <input class="form-control mb-2" type="text" name="sname" id="" value="<?php echo $value['sname'] ?>">
            <input class="form-control mb-2" type="text" name="saddress" id="" value="<?php echo $value['saddress'] ?>">
            <input class="form-control mb-2" type="number" name="sphone" id="" value="<?php echo $value['sphone'] ?>">

            <img src="image/<?php echo $value['simage'];?>" alt="" height="100px" width="130px">

            <label class="d-block py-0 my-0" for="image">Upload Your Image</label>

            <input class="form-control mb-2 w-25  mt-0 pt-0 d-inline-block" style="text-align: center; height: 93px !important; border: 2px dotted;" type="file" name="simage" id="">

            <input class="form-control mb-2" type="hidden" name="old_image" id="" value="<?php echo $value['simage'] ?>">

            <input class="form-control bg-warning" type="submit" value="Update Information" name="update_info">
                
         <?php   } }
        ?>
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>