<?php

/**
 * Function to query information based on
 * a parameter: in this case, receiverEmail.
 *
 */

try  {

    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM driver WHERE driverID = :driverID";

    $driverID = $_GET['driverID'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':driverID', $driverID, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();

    $sql2 = "SELECT * FROM `trip_driver` INNER JOIN trip ON trip_driver.tripNo = trip.tripNo WHERE driverID = :driverID";


    $statement2 = $connection->prepare($sql2);
    $statement2->bindParam(':driverID', $driverID, PDO::PARAM_STR);
    $statement2->execute();

    $result2 = $statement2->fetchAll();


} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<?php

if ($result && $statement->rowCount() > 0) { ?>


    <?php foreach ($result as $row) { ?>
        <li><strong>Driver Name : </strong><?php echo escape($row["driverName"]); ?></li>

    <?php } ?>
</table>
<?php } else { ?>
    <blockquote>No results found for driver Name : <?php echo escape($_GET['driverID']); ?>.</blockquote>
<?php }
?>

<table>
    <thead>
        <tr>
            <th>Trip Number</th>
            <th>Date</th>
            <th>Start Location</th>
            <th>End Location</th>
            <th>Number of Trip Days</th>
            <th>Vehicle Type</th>
            <th>Action</th> <!-- Add Action column -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result2 as $row) { ?>
        <tr>
            <td><?php echo escape($row["tripNo"]); ?></td>
            <td><?php echo escape($row["Date"]); ?> </td>
            <td><?php echo escape($row["startlocation"]); ?></td>
            <td><?php echo escape($row["endlocation"]); ?></td>
            <td><?php echo escape($row["noOfTripDays"]); ?></td>
            <td><?php echo escape($row["vehicleType"]); ?></td>
            <td><a href="update-single.php?tripNo=<?php echo escape($row['tripNo']); ?>">Update</a></td> <!-- Add Update link -->
        </tr>
        <?php } ?>
    </tbody>
</table>
<!--<a href="updatetrip.php?tripNo=<?php echo escape($_GET['tripNo']); ?>">Update trip</a><br>-->
<a href="homedriver.php">Back to driver</a>

<?php require "templates/footer.php"; ?>
