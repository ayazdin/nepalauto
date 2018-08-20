<?php
    $con = mysqli_connect('localhost','root','','nepalaut_nepalauto');

   $con2 = new mysqli('localhost','root','','dac_nepalauto');


if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    mysqli_set_charset($con, 'utf8');

	mysqli_set_charset($con2, 'utf8');


?>
