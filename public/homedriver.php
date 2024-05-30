<?php include "templates/header.php"; ?>

<ul>
    <li><strong>Driver Page</strong>
        <ul>
            <li><a href="driver.php"><strong>Create</strong></a> - add a driver</li>
            <li><a href="readdriver.php"><strong>Read</strong></a> - read driver details</li>
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



    $query = "SELECT * FROM driver ORDER BY driverID DESC";




    // Execute the query
    $result = $connection->query($query);
    } catch (PDOException $error) {
    // Display an error message if there's a PDO exception
    echo "Error: Connection failure" . $error->getMessage();
}
?>




    <?php if (!empty($result)) : ?>
<h2> Last add drivers </h2>
<table>
<thead>
<tr>
<th>Driver Id</th>
<th>Driver Name</th>
<th>Driver Telephone Number</th>
<th>License Number</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach ($result as $row) : ?>
<tr>

<td><?php echo escape($row["driverID"]); ?></td>
<td><?php echo escape($row["driverName"]); ?></td>
<td><?php echo escape($row["driverTeleNo"]); ?> </td>
<td><?php echo escape($row["LicenseNo"]); ?> </td>

 <td><a href="viewdriver.php?driverID=<?php echo $row['driverID']; ?>">View</a></td>


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


