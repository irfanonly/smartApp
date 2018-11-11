<?php

//check whether request parameters are comming or not
if (empty($_REQUEST["device_name"]) || empty($_REQUEST["suport_device"]) || empty($_REQUEST["limit_value"]) || empty($_REQUEST["created_by"]) || empty($_REQUEST["watt"]))
{

    //error message if those values contain null or not assign

    $returnArray["status"]=800;
    $returnArray["message"]="Missing Required information";
    echo json_encode($returnArray);
    return;
}
//success if all the values enterd correctly
else {
    $voltage = $_REQUEST["watt"];
    $device_name = $_REQUEST["device_name"];
    $suport_device = $_REQUEST["suport_device"];
    $limit_value = $_REQUEST["limit_value"];
    $created_by = $_REQUEST["created_by"];
    if (is_numeric($limit_value)){

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
    $result = $access->register_device($device_name, $suport_device, $limit_value, $created_by,$voltage);
    if ($result != "") {
        //found result
        $output["status"] = "200";
        $output["id"] = $result;
        $output["message"] = "Device registered successfully";
        echo json_encode($output);
    } else {
        //error result
        $returnArray["status"] = "400";
        $returnArray["message"] = "Device not registered";
        echo json_encode($returnArray);
    }

//disconnect the database connection
    $access->disconnect();
    }
    else {
        $returnArray["status"]=800;
        $returnArray["message"]="Missing Required information";
        echo json_encode($returnArray);
        return;
    }

}

?>
