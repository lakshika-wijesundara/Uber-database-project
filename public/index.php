<?php include "templates/header.php"; ?>

<style>
    ul {
        list-style-type: none; /* Remove bullets */
        margin: 10;
        padding: 10;
    }

    ul li {
        margin-bottom: 10px;
    }

    ul li a {
        text-decoration: none;
        font-weight: bold;
    }
</style>

<div>
    <h2>Trip</h2>
    <ul>
        <li><a href="hometrip.php">HomeTrip</a></li>
        <li><a href="trip.php">CreateTrip</a> - add a trip</li>
        <li><a href="readtrip.php">ReadTrip</a> - find a trip</li>
        <!-- Add more Trip-related links here -->
    </ul>
</div>

<div>
    <h2>Driver</h2>
    <ul>
        <li><a href="homedriver.php">HomeDriver</a></li>
       
    </ul>
</div>

<?php include "templates/footer.php"; ?>
