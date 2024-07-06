<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require "../../dbConfig/dbConfig.php";

if (isset($_GET['doctor']) && isset($_GET['date'])) {
    $doctor = $_GET['doctor'];
    $date = $_GET['date'];

    $sql = "SELECT Start_time, End_time FROM appointment WHERE Doctor_id = $doctor AND Date = '$date'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // data array
        $data = array();
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $time_slot = $row["Start_time"] . " - " . $row["End_time"];
            $time_slot_array = $time_slot;
            array_push($data, $time_slot_array);
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
