<?php

function new_db_connection()
{
    // Variables for the database connection
    $hostname = 'labmm.clients.ua.pt';
    $username = "deca_20L4_03_web";
    $password = "kTVE9AlJ";
    $dbname = "deca_20l4_03";

    // Makes the connection
    $local_link = mysqli_connect($hostname, $username, $password, $dbname);

    // If it fails to connect then die and show errors
    if (!$local_link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Define charset to avoid special chars errors
    mysqli_set_charset($local_link, "utf8");

    // Return the link
    return $local_link;
}
