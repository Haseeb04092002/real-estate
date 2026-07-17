<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'properties_new', 3307);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$res = $conn->query("SELECT * FROM tbl_properties_features_lists");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
