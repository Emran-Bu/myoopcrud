<?php

    class database{
        private $hostname;
        private $dbusername;
        private $dbpassword;
        private $dbname;

        public function dbconnect(){
            $this->hostname='localhost';
            $this->dbusername='root';
            $this->dbpassword='';
            $this->dbname='mycrud';

            $conn = new mysqli($this->hostname, $this->dbusername, $this->dbpassword, $this->dbname);

            return $conn;
        }
    }

    class query extends database{
        // show data
        public function getData($table, $field='*', $condition_arr='', $order_by_field='', $order_by_type='', $limit=''){
            $sql = "SELECT $field FROM $table";
            if($condition_arr != ''){
                $total_arr = count($condition_arr);
                $sql .= " WHERE ";
                $i = 1;
                foreach($condition_arr as $key=>$value){
                    if($i == $total_arr){
                        $sql .= " $key = '$value'";
                    } else {
                        $sql .= " $key = '$value' AND ";
                    }
                    $i++;
                }
            }

            if($order_by_field != ''){
                $sql .= " ORDER BY $order_by_field $order_by_type";
            }

            if($limit != ''){
                $sql .= " LIMIT $limit";
            }
            // die($sql);
            $result = $this->dbconnect()->query($sql);
            $arr = [];
            if($result->num_rows>0){
                while($row = $result->fetch_assoc())
                {
                    $arr[] = $row;
                }
                return $arr;
            } else {
                return 'Record Not Found';
            }
        }

        // insert data
        public function insertData($table, $insert_arr = ''){
            if($insert_arr != ''){
                // first rule
                $key = implode(', ',array_keys($insert_arr));
                $value = implode("', '" ,$insert_arr);
                $value = "'" .$value . "'"; 

                // 2nd rule

                // foreach($insert_arr as $key => $value){
                //     $key_arr[] = $key;
                //     $value_arr[] = $value;
                // }

                // $o_key = implode(',',$key_arr);
                // $o_value = implode("', '" ,$insert_arr);
                // $o_value = "'" .$o_value . "'"; 
                // die($o_value);

                $sql = "INSERT INTO $table ($key) VALUES ($value)";
                // die( $sql);

                $result = $this->dbconnect()->query($sql);

                session_start();
                
                if($result){
                    return $_SESSION['add_record'] = '<i class="fw-bold fs-5">Record saved successfully</i>';
                } else{
                    return $_SESSION['add_record'] ='<i class="fw-bold fs-5">Record not saved</i>';
                }

            }
        }

        // delete data
        public function deleteData($table ,$condition_arr=''){
            if ($condition_arr !='') {
                $sql = "DELETE FROM $table WHERE";

                // 1st rule

                // $key = implode(',',array_keys($condition_arr));
                // $value = implode("', '" ,$condition_arr);
                // $sql .= " $key = $value";

                // 2nd rule

                $total_arr = count($condition_arr);
                $i = 1;
                foreach($condition_arr as $key=>$value){
                    if($i == $total_arr){
                        $sql .= " $key = '$value'";
                    } else {
                        $sql .= " $key = '$value' AND ";
                    }
                    $i++;
                }

                // echo $sql;
                
                $result = $this->dbconnect()->query($sql);

                session_start();
                
                if($result){
                    return $_SESSION['delete_record'] = '<i class="fw-bold fs-5">Record Deleted successfully</i>';
                } else{
                    return $_SESSION['delete_record'] ='<i class="fw-bold fs-5">Record not Deleted</i>';
                }
            }
            
        }

        // delete data
        public function updateData($table ,$condition_arr='', $where_field, $where_value){
            if ($condition_arr !='') {
                $sql = "UPDATE $table SET";

                // 1st rule

                // $key = implode(',',array_keys($condition_arr));
                // $value = implode("', '" ,$condition_arr);
                // $sql .= " $key = $value";

                // 2nd rule

                $total_arr = count($condition_arr);
                $i = 1;
                foreach($condition_arr as $key=>$value){
                    if($i == $total_arr){
                        $sql .= " $key = '$value'";
                    } else {
                        $sql .= " $key = '$value' , ";
                    }
                    $i++;
                }

                $sql .= " WHERE $where_field = $where_value";
                // echo $sql;
                // die();
                
                $result = $this->dbconnect()->query($sql);

                session_start();
                if($result){
                    return $_SESSION['update_record'] = '<i class="fw-bold fs-5">Record Updated successfully</i>';
                } else{
                    return $_SESSION['update_record'] ='<i class="fw-bold fs-5">Record not updated</i>';
                }

            }
            
        }

        // safe string
        public function get_safe_string($str)
        {
            if($str != '')
            return mysqli_real_escape_string($this->dbconnect(), $str);
        }
    }


?>