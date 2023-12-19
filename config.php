<?php
    $conn = new mysqli("localhost", "root", "", "toyota_service_db");

    if ($conn -> connect_error) {
        die("Connection failed: " . $conn -> connect_error);
    }