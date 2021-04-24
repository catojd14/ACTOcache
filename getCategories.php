<?php

    include "dbConnect.php";

    $sql = "select * from categories";
    $stmt=$conn->prepare($sql);
  
    $stmt->execute();
    $response = array();
    while ($res = $stmt->fetch()) {
        $response[] = $res;
    }

    echo json_encode($response);
 
    exit;