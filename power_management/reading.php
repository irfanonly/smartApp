<?php

//check whether request parameters are comming or not
if (empty($_REQUEST["device_id"]) || empty($_REQUEST["is_on"]) || empty($_REQUEST["value"]))
{

    //error message if those values contain null or not assign

    $returnArray["status"]=800;
    $returnArray["message"]="Missing Required information8";
    echo json_encode($returnArray);
    return;
}
//success if all the values enterd correctly
else {
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

    $device_id = $_REQUEST["device_id"];
    $is_on = $_REQUEST["is_on"];
    $value = $_REQUEST["value"];

    $check_device = $access->check_device($device_id);
    if (($is_on == 1 || $is_on == 2) && $check_device == 1 && is_numeric($value)){
        //user passing correct values
        //call the register_device function to check whether the given username and password is available in the database
        $result = $access->register_reading($device_id, $is_on, $value);
        if ($result != "") {
            //found result
            $output["status"] = "200";
            $output["id"] = $result;
            $output["message"] = "Reading value recorded successfully";
            echo json_encode($output);
        } else {
            //error result
            $returnArray["status"] = "400";
            $returnArray["message"] = "Reading values are not recorded";
            echo json_encode($returnArray);
        }

        //disconnect the database connection
        $access->disconnect();
    }
    else {
        //user passing wrong values
        $returnArray["status"]=800;
        $returnArray["message"]="Missing Required information";
        echo json_encode($returnArray);
        return;
    }





}

?>
