<?php include "templates/header.php"; ?>

<ul>
    <li><strong>Trip Page</strong>
        <ul>
            <li><a href="trip.php"><strong>Create</strong></a> - create a trip</li>
            <li><a href="readTrip.php"><strong>Read</strong></a> - read trip details</li>
        </ul>
    </li>
</ul>
<?php



/**
*
* Retrieve and show the last 3 created
* entries from trip table
*
*/



try {
    require "../config.php";
    require "../common.php";



    $connection = new PDO($dsn, $username, $password, $options);



    $query = "SELECT * FROM trip ORDER BY tripNo DESC LIMIT 3";



    // Execute the query
    $result = $connection->query($query);
    } catch (PDOException $error) {
    // Display an error message if there's a PDO exception
    echo "Error: Connection failure" . $error->getMessage();
}
?>





    <?php if (!empty($result)) : ?>
<h2> Last trip orders </h2>
<table>
<thead>
<tr>
<th>Trip Number</th>
<th>Start Location</th>
<th>End Location</th>
<th>Number of Trip Days</th>
<th>Vehicle Type</th>
<th>Date</th>

<th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($result as $row) : ?>
<tr>

<td><?php echo escape($row["tripNo"]); ?></td>
<td><?php echo escape($row["startlocation"]); ?></td>
<td><?php echo escape($row["endlocation"]); ?></td>
<td><?php echo escape($row["noOfTripDays"]); ?> </td>
<td><?php echo escape($row["vehicleType"]); ?> </td>
<td><?php echo escape($row["Date"]); ?> </td>

 <td><a href="viewtrip.php?tripNo=<?php echo $row['tripNo']; ?>">View</a></td>


</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php else : ?>

<blockquote>No results found.</blockquote>
<?php endif; ?>



<br></br>



<a href="index.php">Back to home</a>




<?php require "templates/footer.php"; ?>


