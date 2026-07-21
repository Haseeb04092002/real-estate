<?php
$hostname = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'properties_new';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1 = "CREATE TABLE IF NOT EXISTS `tbl_property_media` (
  `MediaId` int(11) NOT NULL AUTO_INCREMENT,
  `PropertyId` int(11) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `FileSize` varchar(50) DEFAULT NULL,
  `MediaType` enum('Image','Video') NOT NULL DEFAULT 'Image',
  `IsCover` tinyint(1) NOT NULL DEFAULT 0,
  `UploadedBy` int(11) NOT NULL,
  `UploadTime` datetime NOT NULL,
  PRIMARY KEY (`MediaId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

$sql2 = "CREATE TABLE IF NOT EXISTS `tbl_client_documents` (
  `DocumentId` int(11) NOT NULL AUTO_INCREMENT,
  `ClientId` int(11) NOT NULL,
  `DocumentTypeId` int(11) DEFAULT NULL,
  `DocumentTitle` varchar(150) DEFAULT NULL,
  `FileName` text NOT NULL,
  `FileSize` varchar(50) DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  `ReferenceNumber` varchar(100) DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL,
  `VerificationStatus` enum('Pending','Verified','Rejected') DEFAULT 'Pending',
  `StationId` int(11) DEFAULT 0,
  `UploadedBy` int(11) NOT NULL,
  `UploadTime` datetime NOT NULL,
  PRIMARY KEY (`DocumentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql1) === TRUE) {
  echo "Table tbl_property_media created successfully\n";
} else {
  echo "Error creating table: " . $conn->error . "\n";
}

if ($conn->query($sql2) === TRUE) {
  echo "Table tbl_client_documents created successfully\n";
} else {
  echo "Error creating table: " . $conn->error . "\n";
}

$conn->close();
?>
