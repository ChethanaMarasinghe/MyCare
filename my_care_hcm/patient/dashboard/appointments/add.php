<?php

require "../../../dbConfig/dbConfig.php";

if (!isset($_SESSION["Patient_name"])) {
    header("Location: /my_care_hcm/patient/index.php?error=You are not logged in");
    exit();
}

// define variables and set to empty values
$date = $time  = $doctor_id = "";

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = validate($_POST["doctor"]);
    $date = validate($_POST["date"]);
    $time = validate($_POST["time"]);

    if (empty($doctor_id) || empty($date) || empty($time)) {
        header("Location: add.php?error=All fields are required");
        exit();
    } else {
        $timeParts = explode(" - ", $time);
        $startTime = trim($timeParts[0]);
        $endTime = trim($timeParts[1]);

        $sql = "INSERT INTO appointment (Doctor_id, Patient_id, Date, Start_time, End_time) VALUES ('$doctor_id', '$_SESSION[Patient_id]', '$date', '$startTime', '$endTime')";

        if (mysqli_query($conn, $sql)) {
            header("Location: view.php?success=Appointment added successfully");
            exit();
        } else {
            header("Location: add.php?error=Something went wrong");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../css/common.css">
</head>

<body>
    <h2>Add Appointment</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onchange="enableFields()">

        <label for="department">Department:
            <select id="department" name="department" required>
                <option value="" selected disabled>Select a department</option>
                <?php
                $sql = "SELECT Department_id, Department_name FROM department";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["Department_id"] . "'>" . $row["Department_name"] . "</option>";
                }
                mysqli_close($conn);
                ?>
            </select>
        </label>

        <label for="doctor">
            <span id="doctor_label">Doctor:</span>
            <select name="doctor" id="doctor" disabled required>
                <option value="" selected disabled>Select a doctor</option>
            </select>
        </label>

        <label for="date">
            Date:
            <input type="date" id="date" name="date" required disabled>
        </label>

        <label for="time">
            <span id="time_label">Time:</span>
            <select name="time" id="time" disabled required>
            </select>
        </label>

        <input type="submit" value="Submit">
    </form>

    <script>
        function enableFields() {
            const department = document.getElementById("department");
            const doctor = document.getElementById("doctor");
            const date = document.getElementById("date");
            const time = document.getElementById("time");

            doctor.disabled = department.selectedIndex == '0';
            date.disabled = doctor.selectedIndex == '0';
            time.disabled = date.value == '';
        }

        document.getElementById("department").addEventListener("change", function() {
            document.getElementById('doctor_label').innerText = "Doctor: (Updating...)";
            var department_id = this.value;
            var doctor_dropdown = document.getElementById("doctor");
            doctor_dropdown.innerHTML = `<option value="" selected disabled>Select a doctor</option>`;

            let doctor_count = 0;

            // API
            const URL = `http://localhost/my_care_hcm/admin/api/get_doctors.php?department=${department_id}`;
            const xhr = new XMLHttpRequest();
            xhr.open("GET", URL, true);
            xhr.getResponseHeader("Content-type", "application/json");
            xhr.onload = function() {
                const doctors = JSON.parse(this.responseText);
                if (doctors.length > 0) {
                    doctor_count = doctors.length;
                    doctors.map((doctor, index) => {
                        const optionElement = document.createElement("option");
                        optionElement.setAttribute("value", doctor.Doctor_id);
                        optionElement.innerText = doctor.Doctor_name + " - $" + doctor.Doctor_fee;
                        doctor_dropdown.appendChild(optionElement);
                        doctor_dropdown.disabled = false;
                    });
                } else {
                    doctor_dropdown.disabled = true;
                    doctor_dropdown.innerHTML = `<option value="" selected disabled>No Doctors found for this department</option>`;
                }
                document.getElementById('doctor_label').innerText = `Doctor: (${doctor_count})`;
            }
            xhr.send();
        });

        function generateTimeSlots(startTime, endTime, interval) {
            const slots = [];
            const start = new Date(`1970-01-01T${startTime}:00`);
            const end = new Date(`1970-01-01T${endTime}:00`);

            let current = start;

            while (current < end) {
                let next = new Date(current.getTime() + interval * 60000); // 30 minutes later
                let startSlot = formatTime(current);
                let endSlot = formatTime(next);

                slots.push(`${startSlot} - ${endSlot}`);
                current = next;
            }

            return slots;
        }

        function formatTime(date) {
            let hours = date.getHours();
            let minutes = date.getMinutes();
            let period = "AM";

            if (hours >= 12) {
                period = "PM";
                if (hours > 12) {
                    hours -= 12;
                }
            }

            if (hours === 0) {
                hours = 12;
            }

            minutes = minutes < 10 ? `0${minutes}` : minutes;

            return `${hours}:${minutes} ${period}`;
        }

        document.getElementById("date").addEventListener("change", function() {
            const doctor_label = document.getElementById('doctor_label');
            const time_dropdown = document.getElementById('time');
            time_dropdown.innerHTML = `<option value="" selected disabled>Select a time</option>`;
            const date = document.getElementById('date').value;
            const doctor = document.getElementById('doctor').value;
            const startTime = "08:00";
            const endTime = "16:00";
            const interval = 30; // in minutes
            const timeSlots = generateTimeSlots(startTime, endTime, interval);

            let slots_count = timeSlots.length;
            let bookedTimes = [];

            // API
            const URL = `http://localhost/my_care_hcm/admin/api/get_timeslots.php?doctor=${doctor}&&date=${date}`;

            const xhr = new XMLHttpRequest();
            xhr.open("GET", URL, true);
            xhr.getResponseHeader("Content-type", "application/json");
            xhr.onload = function() {
                bookedTimes = JSON.parse(this.responseText);
                if (bookedTimes.length > 0) {
                    slots_count = timeSlots.length - bookedTimes.length;
                    timeSlots.map((timeSlot) => {
                        isTaken = false;
                        bookedTimes.map((bookedTime) => {
                            if (timeSlot == bookedTime) {
                                isTaken = true;
                            }
                        })

                        const optionElement = document.createElement("option");
                        optionElement.setAttribute("value", timeSlot);
                        optionElement.innerText = timeSlot;

                        if (isTaken) {
                            optionElement.setAttribute("disabled", "disabled");
                        }
                        time_dropdown.appendChild(optionElement);
                    });
                } else {
                    timeSlots.map((timeSlot) => {
                        const optionElement = document.createElement("option");
                        optionElement.setAttribute("value", timeSlot);
                        optionElement.innerText = timeSlot;
                        time_dropdown.appendChild(optionElement);
                    });
                }

                time_label.innerText = `Time: (${slots_count} slots available)`;
            }
            xhr.send();
        });
    </script>
</body>

</html>