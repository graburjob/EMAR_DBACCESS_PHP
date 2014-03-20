<?php

/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '/db_connect_emars.php';

// connecting to db
$db = new DB_CONNECT();

// check for post data
if (isset($_GET["patientID"])) {
    $patientID = $_GET['patientID'];

    // get a product from products table
    $query = "select Name, Gender, DOB, Address from patient_profile where Email='".$patientID."'";
    $result = mysql_query($query);

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {

            $result = mysql_fetch_array($result);

            $patient = array();
            $patient["Name"] = $result["Name"];
            $patient["Gender"] = $result["Gender"];
            $patient["DOB"] = $result["DOB"];
            $patient["Address"] = $result["Address"];
            
            // success
            $response["success"] = 1;
            // user node
            $response["patient"] = array();

            array_push($response["patient"], $patient);

            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "No Patient found";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "No Patient found";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>