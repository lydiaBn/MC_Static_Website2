<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['Name']) && isset($_POST['LastName']) &&
        isset($_POST['Major']) && isset($_POST['Email']) &&
        isset($_POST['AcademicYear']) && isset($_POST['PhoneNum'])) {
        
        $Name = $_POST['Name'];
        $LastName = $_POST['LastName'];
        $Major = $_POST['Major'];
        $Email = $_POST['Email'];
        $AcademicYear = $_POST['AcademicYear'];
        $PhoneNum = $_POST['PhoneNum'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "register";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT Email FROM register WHERE Email = ? LIMIT 1";
            $Insert = "INSERT INTO register(Name, Lastname, Major, Email, AcademicYear, PhoneNum) values(?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssss",$Name ,$LastName ,$Major, $Email, $AcademicYear,  $PhoneNum);
                if ($stmt->execute()) {
                    echo "Registration done succefully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
