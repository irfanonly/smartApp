<?php

//check whether request parameters are comming or not
if (empty($_REQUEST["device_id"]))
{

    //error message if those values contain null or not assign

    $returnArray["status"]=800;
    $returnArray["message"]="Missing Required information8";
    echo json_encode($returnArray);
    return;
}
//success if all the values enterd correctly
else {
    
    $device_id = $_REQUEST["device_id"];
$file = parse_ini_file("Test.ini"); //get the database name,username ,password values

//get the values form Test.ini and assign those values to the variable
$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);


//require the access.php file to call the function for the future purpose
require("Secure/access.php");

//call the class and assign the values get from the Test.ini
$access = new access($host, $user, $pass, $name);

//call the connect function to connect with the database
$access->connect();
$result = $access->get_result($device_id);
if ($result != "") {
    //found result
    $output["status"] = "200";
    $output["result"] = $result;
    $output["message"] = "Result found";
    echo json_encode($output);
} else {
    //error result
    $returnArray["status"] = "400";
    $returnArray["message"] = "No result available";
    echo json_encode($returnArray);
}

    //disconnect the database connection
    $access->disconnect();
}

?>
