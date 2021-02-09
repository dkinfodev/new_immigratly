<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

if($_SERVER['HTTP_HOST'] == 'localhost'){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "immigrat_immigratly_fastzone"; // Host Database

    // Users database

    $servername2 = "localhost";
    $username2 = "root";
    $password2 = "";
}else{
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "immigrat_immigratly_fastzone"; // Host Database

    // Users database

    $servername2 = "localhost";
    $username2 = "root";
    $password2 = "";
}

$conn_new = new mysqli($servername, $username, $password, $dbname);
if ($conn_new->connect_error) {
    $response['status'] = true;
    $response['error_exists'] = true;
    $html = '<tr class="text-danger"><td><i class="fa fa-times"></i> '.$dbname.'</td>';
    $html .= '<td>'.$conn_new->connect_error.'</td></tr>';
    $response['html'] = $html;
    echo json_encode($response);
    exit;  
}


$html = '';
if(isset($_REQUEST['database']) && $_REQUEST['database'] != ''){
    $dbname2 = $_REQUEST['database'];
    $conn_old = new mysqli($servername2, $username2, $password2, $dbname2);
    if ($conn_old->connect_error) {
        $response['status'] = true;
        $html = '<tr class="text-danger"><td><i class="fa fa-times"></i> '.$dbname2.'</td>';
        $html .= '<td><span>Database not found</span></td></tr>';
        $response['database'] = $dbname2;
        $response['html'] = $html;
        echo json_encode($response);
        exit;    
    }


    $error = 0;
    $errorMsg = '';
    $success = 0;
    $sql = "SHOW TABLES";
    $results_new = $conn_new->query($sql);

    $new_tables = array();
    if ($results_new->num_rows > 0) {
        // output data of each row
        while($row = $results_new->fetch_assoc()) {
            $new_tables[] = $row['Tables_in_'.$dbname];
        }
    }

    $sql = "SHOW TABLES";
    $result_old = $conn_old->query($sql);

    $old_tables = array();
    if ($result_old->num_rows > 0) {
        // output data of each row
        while($row = $result_old->fetch_assoc()) {
            $old_tables[] = $row['Tables_in_'.$dbname2];
        }
    }


    $tables_new = array_diff($new_tables,$old_tables);
    $tables_new = array_values($tables_new);

    // Create New Tables
    for($t = 0;$t < count($tables_new);$t++){
            $sql = "SHOW COLUMNS FROM ".$tables_new[$t];
            $results = $conn_new->query($sql);
            $columns = array();
            while($row = $results->fetch_assoc()) {
                // pre($row);
                $null = '';
                $primary = '';
                if($row['Null'] == 0){
                    $null = "NOT NULL";
                }
                if($row['Key'] == 'PRI'){
                    $primary = "PRIMARY KEY AUTO_INCREMENT";
                }
                $columns[] = '`'.$row['Field'].'` '.$row['Type'].' '.$null.' '.$primary;
            }
            $cols = implode(",",$columns);
            $sql2 = "CREATE TABLE `$tables_new[$t]` ($cols)";
            if($conn_old->query($sql2)){
                $success++;
            }else{
                $error++;
                $errorMsg .='<i class="fa fa-check"></i> Error while creating Table '.$tables_new[$t].'<br>';
                $errorMsg .='<div class="text-warning">'.$sql2.'</div>';
            }
            // echo $sql2."<br>";
    }

    // Create New Columns
    $tables = array();
    for($c = 0;$c < count($new_tables);$c++){
        $tbl = $new_tables[$c];
    
        if(!isset($tables[$tbl])){
            $sql = "SHOW COLUMNS FROM ".$tbl;
            $results = $conn_new->query($sql);
            $columns = array();
            while($row = $results->fetch_assoc()) {
                $column = $row['Field'];
            
                $sql2 = "SHOW COLUMNS FROM `$tbl` LIKE '$column'";
                $res2 = $conn_old->query($sql2);
                if ($res2->num_rows <= 0) {
                    $tables[$tbl][] = $column;
            
                    $null = '';
                    $primary = '';
                    if($row['Null'] == 0){
                        $null = "NOT NULL";
                    }
                    if($row['Key'] == 'PRI'){
                        $primary = "PRIMARY KEY AUTO_INCREMENT";
                    }
                    $sql3 = "ALTER TABLE $tbl ADD COLUMN $column ".$row['Type']." ".$null." ".$primary;
                    if($conn_old->query($sql3)){
                        $success++;
                    }else{
                        $error++;
                        $errorMsg .='Error while Alter Table '.$tbl.'<br>';
                        $errorMsg .='<div class="text-warning">'.$sql3.'</div>';
                    }
                    
                }
            }
        
        }
    }

    $sql = "SHOW TABLES";
    $results_new = $conn_new->query($sql);

    $new_tables = array();
    if ($results_new->num_rows > 0) {
        while($row = $results_new->fetch_assoc()) {
            $new_tables[] = $row['Tables_in_'.$dbname];
        }
    }

    $sql = "SHOW TABLES";
    $result_old = $conn_old->query($sql);

    $old_tables = array();
    if ($result_old->num_rows > 0) {
        // output data of each row
        while($row = $result_old->fetch_assoc()) {
            $old_tables[] = $row['Tables_in_'.$dbname2];
        }
    }

    $tables = array();
    for($c = 0;$c < count($new_tables);$c++){
        $tbl = $new_tables[$c];
    
        if(!isset($tables[$tbl])){
            $sql = "SHOW COLUMNS FROM ".$tbl;
            $results = $conn_new->query($sql);
            $columns = array();
            // echo "TABLE: ".$tbl."<br>";


            while($row = $results->fetch_assoc()) {
                // pre($row);
                $column = $row['Field'];
            
                $sql2 = "SHOW COLUMNS FROM `$tbl` LIKE '$column'";
                $res2 = $conn_old->query($sql2);
                $column_detail = $res2->fetch_assoc();

                foreach($row as $k => $value){
                    
                    if($row[$k] != $column_detail[$k]){
                        if($k != 'Extra'){
                            // echo $k."<br>";
                            $null = '';
                            $default = '';
                            $key = '';
                            $type = $row['Type'];
                            if($type == 'int(255)'){
                                $type = 'int(11)';
                            }
                            if($k == 'Null'){
                                if(strtolower($value) == 'yes'){
                                    $null = ' NULL';
                                }else{
                                    $null = '';
                                }
                            }
                            if($k == 'Key'){
                                if($value == 'PRI'){
                                    $key = " PRIMARY KEY AUTO_INCREMENT";
                                }
                            }
                            if($k == 'Default'){
                                if($value != NULL){
                                    if($value == 'current_timestamp()' || $value == 'CURRENT_TIMESTAMP'){;
                                        $default = " NOT NULL DEFAULT CURRENT_TIMESTAMP";
                                    }else{
                                        $default = " NOT NULL DEFAULT '".$value."'";
                                    }
                                    
                                }else{
                                    $default = " NOT NULL DEFAULT ".$value;
                                }
                            }
                            $sql3 = "ALTER TABLE `$tbl` CHANGE `$column` `$column` $type ".$key.$null.$default;
                            if($value != ''){
                                if($conn_old->query($sql3)){
                                    $success++;
                                }else{
                                    $error++;
                                    $errorMsg .='Error while Alter Table '.$tbl.'<br>';
                                    $errorMsg .='<div class="text-warning">'.$sql3.'</div>';
                                    // echo "<pre>";
                                    // print_r($column_detail);
                                    // echo "</pre>";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $conn_new->close();
    $conn_old->close();
    $response['status'] = true;
    $response['database'] = $dbname2;
    if($error > 0){
        $message ="<div class='text-danger'>".$error." Errors while updating database<br>".$errorMsg."</div>";
    }else{
        $message ="<div class='text-success'> Database Updated successfully</div>";
    }
    // $response['message'] = 'Database replicate successfully';
    $response['status'] = true;
    if($errorMsg != ''){
        $response['error_exists'] = true;
    }else{
        $response['error_exists'] = false;
    }
    echo $message;
    $html = '<tr><td>'.$dbname2.'</td>';
    $html .= '<td>'.$message.'</td></tr>';
    $response['html'] = $html;
    echo json_encode($response);
    exit;  
}else{
    $response['status'] = false;
    $response['message'] = 'database not selected';
    echo json_encode($response);
    exit;
}

function pre($value){
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}
?> 

