<?php

if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['person']) && isset($_POST['reservetion-date']) && isset($_POST['message'])) {
 
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $person = $_POST['person'];
    $reservationDate = $_POST['reservetion-date'];
    $message = $_POST['message'];

    $servername = "http://localhost/phpmyadmin/index.php?route=/database/structure&db=onlinedb";
    $username = "root";
    $password = "";
    $database = "http://localhost/phpmyadmin/index.php?route=/database/structure&db=onlinedb";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert the data
    $sql = "INSERT INTO your_table (name, phone, person, reservation_date, message) VALUES ('$name', '$phone', '$person', '$reservationDate', '$message')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
    } else {
        echo "Error inserting data: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>