<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['loginID']) && isset($_POST['loginPassword'])) {
    
    $loginID = $_POST['loginID'];
    $loginPassword = $_POST['loginPassword'];
    
    // include db connect class
    require_once __DIR__ . '/db_connect_emars.php';

    // connecting to db
    $db = new DB_CONNECT();

    // get all products from products table
    $query="select password FROM passwords where Email='".$loginID."' and Role='D'";
    $result = mysql_query($query) or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        if($loginPassword==$row["password"]) {
            $response["success"] = 1;
            $response["message"] = "Success";
        } else {
            //Wrong Password
            $response["success"] = 0;
            $response["message"] = "Wrong Password";
        }
    } else {
        //User ID not found
        $response["success"] = 0;
        $response["message"] = "User ID not found";
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";
}
echo json_encode($response);
?>
