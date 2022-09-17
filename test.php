<?php

    include 'database.php';

    $obj = new query();

    // show data
    // $condition_arr = array('sid' => 1);

    // if(empty($condition_arr)){
    //     $condition_arr ='';
    // }

    // $result = $obj->getData('student');
    // $result = $obj->getData('student','*', $condition_arr,'','');
    // echo '<pre>';
    // print_r($result);
    // echo '</pre>';
    // die();

    // insert obj

    // $insert_arr = array('sname' => 'Tania', 'sclass'=>2, 'saddress'=>'shylet', 'sphone'=>'0147565445');

    // $result = $obj->insertData('student', $insert_arr);

    // delete data

    $delete_arr = array('sid' => 23);

    $result = $obj->deleteData('student', $delete_arr);

    echo '<pre>';
    print_r($result);
    echo '</pre>';

?>