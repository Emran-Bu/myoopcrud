<?php

    include 'database.php';

    $obj = new query();

    $result = $obj->getData('student','*','','sid','desc','');

    // if(isset($_GET['status']) AND $_GET['status'] == 'delete')
    // {
    //     $id = $obj->get_safe_string($_GET['id']);

    //     $condition_arr = array('sid'=>$id);
    //     $d_result = $obj->deleteData('student',$condition_arr);

    // }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>CRUD | APP</title>

    <style>
        th{
            text-align:center;
        }
        td{
            line-height: 100px;
            text-align:center;
        }

        .alert{
            position: fixed;
            right: 10px;
            top: 10px;
            z-index: 1;
        }
    </style>
</head>
<body>

    <?php
        session_start();
        if (isset($_SESSION['add_record']) OR isset($_SESSION['delete_record']) OR isset($_SESSION['update_record'])) {?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span class="me-2" id="counter"></span>
            <?php
            if(isset($_SESSION['delete_record']))
            {
                echo $_SESSION['delete_record'];
                unset($_SESSION['delete_record']);
            }

            if(isset($_SESSION['add_record']))
            {
                echo $_SESSION['add_record'];
                unset($_SESSION['add_record']);
            }

            if(isset($_SESSION['update_record']))
            {
                echo $_SESSION['update_record'];
                unset($_SESSION['update_record']);
            }
            ?>

            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close">
            </button>
        </div>

    <?php } ?>

    <div class="container my-4 p-4 shadow">
        <h2 class=""><a class="text-decoration-none" href="index.php">Student Database</a><a class="text-decoration-none float-end" style="background: darkblue; color: white; font-size: 27px; padding: 4px; border-radius: 8px; cursor: pointer;" href="add.php">Add Record</a></h2>
    </div>

    <div class="container my-4 p-4 shadow">

        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody >
                <?php 
                    if(isset($result[0])){
                        $sl = 1;
                        foreach ($result as $value) {
                            
                ?>
                <tr style="height:100px;">
                    <td><?php echo $sl 
                    //$value['sid'];?></td>
                    <td><?php echo $value['sname'];?></td>
                    <td><?php echo $value['saddress'];?></td>
                    <td><?php echo $value['sphone'];?></td>
                    <td><img src="image/<?php echo $value['simage'];?>" alt="No Image" height="100px" width="130px"></td>
                    <td>
                        <a class="btn btn-success" href="edit.php?status=edit&&id=<?php echo $value['sid'];?>">Edit</a>
                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#user<?php echo $value['sid'];?>">Delete</a>

                        <!--  -->

                        <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="user<?php echo $value['sid'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
          Are You Sure Permanently Deleted?
      <?php //echo $value['sid'];?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Yes</button> -->
        <a class="btn btn-danger" href="delete.php?status=delete&&id=<?php echo $value['sid'];?>">Yes</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal End -->
                        <!--  -->
                    </td>
                </tr>
                <?php
                $sl++;
                  }
                    } 
                ?>
            </tbody>
        </table>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
    if(isset($_SESSION['message'])) {
?>

<script>
            setTimeout(() => {
                location.href = 'session.php'
               }, 5000);

            let count = 5
            var stop = setInterval(() => {

                if (count <= 0) {
                    clearInterval(stop)
                }

                count--
                counter.innerHTML = count
                counter.style.color = "blue"

            }, 1000);
</script>

<?php    
// echo" <script>
//                setTimeout(() => {
//                     location.href = 'session.php'
//                     <span></span>
//                }, 5000);
            
//     </script>";
    }
?>



