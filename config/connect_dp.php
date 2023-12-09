<?php  
    // MYSQL or PDO - conntect to database
    $connection = mysqli_connect('localhost', 'aki', 'SAMPLEpass123', 'pizza_resto');

    // checking connection
    if(!$connection) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

?>