<?php

session_start();
$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

// Correct variable name from $hosts to $host
$data = mysqli_connect($host, $user, $password, $db);

// Check connection
if ($data === false) {
    die("Connection error: " . mysqli_connect_error());
}

// Check if the table exists
$check_table_query = "SHOW TABLES LIKE 'addmission'";
$result_check = mysqli_query($data, $check_table_query);
if (mysqli_num_rows($result_check) == 0) {
    die("Table 'addmission' does not exist. Please create it.");
}

if(isset($_POST['apply'])){
    $data_name = mysqli_real_escape_string($data, $_POST['name']);
    $data_email = mysqli_real_escape_string($data, $_POST['email']);
    $data_phone = mysqli_real_escape_string($data, $_POST['phone']);
    $data_massage = mysqli_real_escape_string($data, $_POST['massage']);

    // Validate and sanitize input as needed

    $sql = "INSERT INTO addmission(name,email,phone,massage) 
            VALUES('$data_name','$data_email','$data_phone','$data_massage')";

    $result = mysqli_query($data, $sql);

    if ($result) {
        $_SESSION['message']="YOUR APPLICATION SENT SUCCESSFUL";
        header("location:index.php");
    } else {
        echo "Apply Failed";
    }
}


?>
