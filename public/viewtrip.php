<?php
require "../config.php"; // Include your database configuration
require "../common.php"; // Include any common functions you might need

if (isset($_GET['tripNo'])) {
    $tripNo = $_GET['tripNo'];

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM trip WHERE tripNo = :tripNo";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':tripNo', $tripNo);
        $statement->execute();
        $trip = $statement->fetch();

        if ($trip) {
            echo '<h2>View Trip Details</h2>';
            echo '<table>';
            echo '<tr><td><strong>Trip No:</strong></td><td>' . escape($trip['tripNo']) . '</td></tr>';
            echo '<tr><td><strong>Start Location:</strong></td><td>' . escape($trip['startlocation']) . '</td></tr>';
            echo '<tr><td><strong>End Location:</strong></td><td>' . escape($trip['endlocation']) . '</td></tr>';
            echo '<tr><td><strong>Number of Trip Days:</strong></td><td>' . escape($trip['noOfTripDays']) . '</td></tr>';
            echo '<tr><td><strong>Vehicle Type:</strong></td><td>' . escape($trip['vehicleType']) . '</td></tr>';
            echo '<tr><td><strong>Date:</strong></td><td>' . escape($trip['Date']) . '</td></tr>';

            // Add more rows for additional fields
            echo '</table>';

            // Add an "Edit" link to go to the edit page
            echo '<a href="editTrip.php?tripNo=' . $tripNo . '"><strong>Edit</strong></a>';
        } else {
            echo 'Trip not found.';
        }
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
} else {
    echo 'No trip number provided.';
}
?>

<a href="hometrip.php">Back to Home</a>





























