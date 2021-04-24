<?php

    include "dbConnect.php";
    if(isset($_GET['category_id'])) {
        $id = $_GET['category_id'];
    }
    
    $sql = "select * from documents where category_id = :id";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":id",$id,PDO::PARAM_INT,1);
  
    $stmt->execute();
    $response = array();
    while ($res = $stmt->fetch()) {
        $response[] = $res;
    }

    echo json_encode($response);
 
    exit;