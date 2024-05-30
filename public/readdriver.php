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
            FROM driver
            WHERE driverID = :driverID";

    $driverID = $_POST['driverID'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':driverID', $driverID, PDO::PARAM_STR);
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
          <th>Driver ID</th>
         <th>Driver Name</th>
         <th>Driver Telephone Number</th>
          <th>License Number</th>

        </tr>
      </thead>
      <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["driverID"]); ?></td>
           <td><?php echo escape($row["driverName"]); ?></td>
           <td><?php echo escape($row["driverTeleNo"]); ?></td>
          <td><?php echo escape($row["LicenseNo"]); ?></td>

        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['driverID']); ?>.</blockquote>
    <?php }
} ?>

<h2>Find user based on driverID</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="driverID">Driver ID</label>
  <input type="text" id="driverID" name="driverID">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>