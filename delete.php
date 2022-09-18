<?php

    include 'database.php';

    $obj = new query();

    if(isset($_GET['status']) AND $_GET['status'] == 'delete')
    {
        $id = $obj->get_safe_string($_GET['id']);

        $deleteID = array('sid'=>$id);
        $result = $obj->getData('student', '*', $deleteID);

        // echo $result[0]['simage'];

        foreach ($result as $value) {
            $old_image = $value['simage'];
        }

        if (isset($old_image)) {
            $old_image = 'image/' . $old_image;
            unlink($old_image);
        }
        
        $condition_arr = array('sid'=>$id);
        $d_result = $obj->deleteData('student',$condition_arr);

        header('location: index.php');
    }

?>