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
            // Handle form submission for updating trip details
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tripNo = $_POST['tripNo'];
                $startlocation = $_POST['startlocation'];
                $endlocation = $_POST['endlocation'];
                $noOfTripDays = $_POST['noOfTripDays'];
                $vehicleType = $_POST['vehicleType'];
                $Date = $_POST['Date'];

                $updateSql = "UPDATE trip
                              SET tripNo = :tripNo,
                                  startlocation = :startlocation,
                                  endlocation = :endlocation,
                                  noOfTripDays = :noOfTripDays,
                                  vehicleType = :vehicleType,
                                  Date = :Date
                              WHERE tripNo = :tripNo";

                $updateStatement = $connection->prepare($updateSql);
                $updateStatement->bindValue(':tripNo', $tripNo);

               $updateStatement->bindValue(':startlocation', $startlocation);
                $updateStatement->bindValue(':endlocation', $endlocation);
                $updateStatement->bindValue(':noOfTripDays', $noOfTripDays);
                $updateStatement->bindValue(':vehicleType', $vehicleType);
                $updateStatement->bindValue(':Date', $Date);

                if ($updateStatement->execute()) {
                    // Display success message and redirect
                    $successMessage = 'Trip details for trip number ' . escape($tripNo) . ' successfully updated.';
                    header("Location: editTrip.php?tripNo=" . $tripNo . "&successMessage=" . urlencode($successMessage));
                    exit();
                } else {
                    echo 'Error updating trip details.';
                }
            }

            // Display the edit form for trip details
            ?>
            <?php require "templates/header.php"; ?>

            <h2>Edit Trip Details</h2>

            <!-- Display success message if successMessage parameter is present -->
            <?php if (isset($_GET['successMessage'])) : ?>
                <p><?php echo urldecode($_GET['successMessage']); ?></p>
            <?php endif; ?>

            <form method="post">
                <label>Trip Number: <input type="text" name="tripNo" value="<?php echo escape($trip['tripNo']); ?>"></label><br>
                <label>Start Location: <input type="text" name="startlocation" value="<?php echo escape($trip['startlocation']); ?>"></label><br>
                <label>End Location: <input type="text" name="endlocation" value="<?php echo escape($trip['endlocation']); ?>"></label><br>
                <label>Number of Trip Days: <input type="text" name="noOfTripDays" value="<?php echo escape($trip['noOfTripDays']); ?>"></label><br>
                <label>VehicleType: <input type="text" name="vehicleType" value="<?php echo escape($trip['vehicleType']); ?>"></label><br>
                 <label for="Date">Date:<input type="date" name="Date" id="Date" value="<?php echo date('Y-m-d', strtotime(escape($trip['Date']))); ?>"></label><br>

                <input type="submit" value="Save">
            </form>

            <a href="viewtrip.php?tripNo=<?php echo $tripNo; ?>">Back to Trip Details</a>

            <?php require "templates/footer.php"; ?>
            <?php
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

