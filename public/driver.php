<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_trip = array(
             "driverID"  => $_POST['driverID'],
            "driverName"  => $_POST['driverName'],
            "driverTeleNo"     => $_POST['driverTeleNo'],
            "LicenseNo"     => $_POST['LicenseNo'],
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "driver",
            implode(", ", array_keys($new_trip)),
            ":" . implode(", :", array_keys($new_trip))
        );


        $statement = $connection->prepare($sql);
        $statement->execute($new_trip);
    } catch (PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote>Driver successfully added.</blockquote>
<?php endif; ?>

<h2>Add a driver</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
 <label for="driverID">Driver ID</label>
    <input type="text" name="driverID" id="driverID">
    <label for="driverName">Driver Name</label>
    <input type="text" name="driverName" id="driverName">


    <label for="driverTeleNo">Driver Telephone Number </label>
    <input type="text" name="driverTeleNo" id="driverTeleNo">
    <label for="LicenseNo">License Number</label>
    <input type="text" name="LicenseNo" id="LicenseNo">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
