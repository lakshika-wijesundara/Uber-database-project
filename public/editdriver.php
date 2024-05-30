<?php
require "../config.php"; // Include your database configuration
require "../common.php"; // Include any common functions you might need

if (isset($_GET['driverID'])) {
    $driverID = $_GET['driverID'];

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * FROM driver WHERE driverID = :driverID";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':driverID', $driverID);
        $statement->execute();
        $driver = $statement->fetch();

        if ($driver) {
            // Handle form submission for updating trip details
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $driverID = $_POST['driverID'];
                $driverName = $_POST['driverName'];
                $driverTeleNo = $_POST['driverTeleNo'];
                $LicenseNo = $_POST['LicenseNo'];

                $updateSql = "UPDATE driver
                              SET driverID= :driverID,
                                  driverName = :driverName,
                                  driverTeleNo = :driverTeleNo,
                                  LicenseNo = :LicenseNo
                              WHERE driverID = :driverID";

                $updateStatement = $connection->prepare($updateSql);
                $updateStatement->bindValue(':driverID', $driverID);
                $updateStatement->bindValue(':driverName', $driverName);
                $updateStatement->bindValue(':driverTeleNo', $driverTeleNo);
                $updateStatement->bindValue(':LicenseNo', $LicenseNo);

                if ($updateStatement->execute()) {
                    // Display success message and redirect
                    $successMessage = 'driver details driver ID ' . escape($driverID) . ' successfully updated.';
                    header("Location: editdriver.php?driverID=" . $driverID . "&successMessage=" . urlencode($successMessage));
                    exit();
                } else {
                    echo 'Error updating driver details.';
                }
            }

            // Display the edit form for trip details
            ?>
            <?php require "templates/header.php"; ?>

            <h2>Edit driver Details</h2>

            <!-- Display success message if successMessage parameter is present -->
            <?php if (isset($_GET['successMessage'])) : ?>
                <p><?php echo urldecode($_GET['successMessage']); ?></p>
            <?php endif; ?>

            <form method="post">
                <label>Driver ID: <input type="text" name="driverID" value="<?php echo escape($driver['driverID']); ?>"></label><br>
                <label>Driver Name: <input type="text" name="driverName" value="<?php echo escape($driver['driverName']); ?>"></label><br>
                <label>Driver Telephone Number: <input type="text" name="driverTeleNo" value="<?php echo escape($driver['driverTeleNo']); ?>"></label><br>
                <label>License Number: <input type="text" name="LicenseNo" value="<?php echo escape($driver['LicenseNo']); ?>"></label><br>

                <input type="submit" value="Save">
            </form>

            <a href="viewdriver.php?driverID=<?php echo $driverID; ?>">Back to driver Details</a>

            <?php require "templates/footer.php"; ?>
            <?php
        } else {
            echo 'Driver not found.';
        }
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
} else {
    echo 'No driverID provided.';
}
?>

