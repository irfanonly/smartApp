<?php

//check whether request parameters are comming or not
if (empty($_REQUEST["device_id"]))
{

    //error message if those values contain null or not assign

    $returnArray["status"]=800;
    $returnArray["message"]="Missing Required information";
    echo json_encode($returnArray);
    return;
}
//success if all the values enterd correctly
else {
    $device_id = $_REQUEST["device_id"];
    //access the Test.ini file
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


//call the register_device function to check whether the given username and password is available in the database
$result = $access->get_by_month($device_id);
if (count($result) > 0) {
    //found result
    $output["status"] = "200";
    $output["history"] = $result;
    $output["message"] = "Monthly electricity Usage and Wastage recorded successfully";
    echo json_encode($output);
} else {
    //error result
    $returnArray["status"] = "400";
    $returnArray["message"] = "Monthly electricity Usage and Wastage not recorded";
    echo json_encode($returnArray);
}

//disconnect the database connection
$access->disconnect();
}

?>
