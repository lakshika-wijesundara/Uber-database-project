-- Create the 'test' database if it doesn't exist
CREATE DATABASE IF NOT EXISTS test;

-- Switch to the 'test' database
USE test;

-- Create the 'trip' table
CREATE TABLE trip (
    tripNo INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    startlocation VARCHAR(30) NOT NULL,
    endlocation VARCHAR(30) NOT NULL,
    noOfTripDays INT(11) NOT NULL,
    vehicleType VARCHAR(30) NOT NULL,
    Date DATE NOT NULL, -- Changed to DATE data type
    AddedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the 'driver' table
CREATE TABLE driver (
    driverID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    driverName VARCHAR(30) NOT NULL,
    driverTeleNo INT(11) NOT NULL,
    LicenseNo VARCHAR(11) NOT NULL,
    CreatedDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Create the 'trip_driver' table
CREATE TABLE trip_driver (
    trip_driverID INT(11) AUTO_INCREMENT PRIMARY KEY,
    tripNo INT(11) UNSIGNED,
    driverID INT(11) UNSIGNED,
    FOREIGN KEY (tripNo) REFERENCES trip(tripNo),
    FOREIGN KEY (driverID) REFERENCES driver(driverID)
);
