<?php
require "../config.php";
require "../common.php";

$trip_driverTable = ""; // Initialize an empty string to store the table HTML

try {
    $connection = new PDO($dsn, $username, $password, $options);

    // Fetch data from trip_driver table
    $sql = "SELECT * FROM trip_driver";
    $result = $connection->query($sql);

    if ($result->rowCount() > 0) {
        // Start creating the table HTML
        $trip_driverTable .= '<h2></h2>';
        $trip_driverTable .= '<table>';
        $trip_driverTable .= '<tr><th>trip_driverID</th><th>driverID</th><th>tripNo</th></tr>';

        foreach ($result as $row) {
            // You can directly access the values from the $row array
           $trip_driverID = $row["trip_driverID"];
            $driverID = $row["driverID"];
            $tripNo = $row["tripNo"];

            // Add a row for each record
            $trip_driverTable .= "<tr><td>$trip_driverID</td><td>$driverID</td><td>$tripNo</td></tr>";
        }

        $trip_driverTable .= '</table>';
    } else {
        $trip_driverTable = "<p>No data available in Trip-Driver table.</p>";
    }
} catch (PDOException $error) {
    echo 'Error: ' . $error->getMessage();
}

?>

<?php require "templates/header.php"; ?>

<h2>Trip-Driver Table</h2>

<?php echo $trip_driverTable; // Display the Trip-Driver table ?>

<a href="driver.php">Back to driver page
