<?php 

include "dbConnect.php";
//include "getCategories.php";

$action = '';
$result = array('error'=>false);

if(isset($_GET['action'])) {
    $action = $_GET['action'];
}

if($action == 'read') {
    $sql = "select * from categories";
    $stmt=$conn->prepare($sql);
  
    $stmt->execute();
    //$docus = array();
    while ($res = $stmt->fetch()) {
        array_push($result, $res['category']);
    }
}

if($action == 'create') {
    $name = $_POST['name'];
    try {
        $sql = 'INSERT INTO categories(category) VALUES (:category)';
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(":category",$name,PDO::PARAM_STR,1);
    
        $stmt->execute();

        $result['message'] = "Category added successfully";

    }catch (PDOException $e)
    {
        $result['error'] = true;
        $result['message'] = "Failed to add Category";
    }
    
    //$categories = array();
    //  while ($res = $stmt->fetch()) {
    //      array_push($result, $res['category']);
    //  }
}

if($action == 'update') {
    $name = $_POST['name'];
    $sql = 'UPDATE documents SET name=?';
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(":name",$name,PDO::PARAM_STR,1);
  
    $stmt->execute();
    //$categories = array();
     while ($res = $stmt->fetch()) {
         array_push($result, $res['name']);
     }
}

if($action == 'Delete') {
    $id = $_POST['id'];
    
    try {
        $sql = 'Delete FROM documents WHERE id=?';
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(":id",$name,PDO::PARAM_INT,1);
    
        $stmt->execute();

        $result['message'] = "Document deleted successfully";

    }catch (PDOException $e)
    {
        $result['error'] = true;
        $result['message'] = "Failed to delete document";
    }
}
//$conn->close();
echo json_encode($result);