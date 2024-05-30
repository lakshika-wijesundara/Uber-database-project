<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM trip
            WHERE startlocation = :startlocation";

    $startlocation = $_POST['startlocation'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':startlocation', $startlocation, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Trip Number</th>
         <th>Start Location</th>
          <th>End Location</th>
          <th>Number of Trip Days</th>
          <th>vehicle Type</th>
          <th>Date</th>

        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["tripNo"]); ?></td>
          <td><?php echo escape($row["startlocation"]); ?></td>
          <td><?php echo escape($row["endlocation"]); ?></td>
          <td><?php echo escape($row["noOfTripDays"]); ?></td>
          <td><?php echo escape($row["vehicleType"]); ?></td>
          <td><?php echo escape($row["Date"]); ?></td>

        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['startlocation']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find user based on startlocation</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="startlocation">Start Location</label>
  <input type="text" id="startlocation" name="startlocation">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>