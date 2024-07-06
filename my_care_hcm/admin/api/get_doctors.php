<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require "../../dbConfig/dbConfig.php";

if (isset($_GET['department'])) {
    $department = $_GET['department'];

    $sql = "SELECT Doctor_id, Doctor_name, Doctor_fee FROM doctor WHERE Department_id = $department";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // data array
        $data = array();
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }

        echo json_encode($data);
    } else {
        echo json_encode(array(
            "message" => "No results found"
        ));
    }
} else {
    echo json_encode(array(
        "message" => "Invalid Parameters"
    ));
}
