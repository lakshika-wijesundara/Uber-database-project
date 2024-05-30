<?php

/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $user = [
      "tripNo"        => $_POST['tripNo'],
      "Date" => $_POST['Date'],
      "startlocation"  => $_POST['startlocation'],
      "endlocation"     => $_POST['endlocation'],
      "noOfTripDays"       => $_POST['noOfTripDays'],
      "vehicleType"  => $_POST['vehicleType'],
    ];

    $sql = "UPDATE trip
            SET tripNo = :tripNo,
              Date = :Date,
              startlocation = :startlocation,
              endlocation = :endlocation,
              noOfTripDays = :noOfTripDays,
              vehicleType = :vehicleType
            WHERE tripNo = :tripNo"; // Remove the comma at the end

    $statement = $connection->prepare($sql);
    $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['tripNo'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $tripNo = $_GET['tripNo'];

    $sql = "SELECT * FROM trip WHERE tripNo = :tripNo";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':tripNo', $tripNo);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <blockquote><?php echo escape($_POST['Date']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Update a driver</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'tripNo' ? 'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
