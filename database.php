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
        public function insertData($table, $update_arr = ''){
            if($update_arr != ''){
                // first rule
                $key = implode(', ',array_keys($update_arr));
                $value = implode("', '" ,$update_arr);
                $value = "'" .$value . "'"; 

                // 2nd rule

                // foreach($update_arr as $key => $value){
                //     $key_arr[] = $key;
                //     $value_arr[] = $value;
                // }

                // $o_key = implode(',',$key_arr);
                // $o_value = implode("', '" ,$update_arr);
                // $o_value = "'" .$o_value . "'"; 
                // die($o_value);

                $sql = "INSERT INTO $table ($key) VALUES ($value)";

                // die($sql);

                $result = $this->dbconnect()->query($sql);

                if($result){
                    return 'Record saved successfully';
                } else{
                    return 'Record not  saved';
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

                if($result){
                    return 'Record Deleted successfully';
                } else{
                    return 'Record not Deleted';
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
                echo $sql;
                // die();
                
                $result = $this->dbconnect()->query($sql);

                if($result){
                    return 'Record Updated successfully';
                } else{
                    return 'Record not updated';
                }

            }
            
        }
    }


?>