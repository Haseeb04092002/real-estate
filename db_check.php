<?php
define('BASEPATH', 'dummy');
define('ENVIRONMENT', 'development');

require 'application/config/database.php';

$mysqli = new mysqli('localhost', 'root', '', 'properties_new');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$res = $mysqli->query("SHOW COLUMNS FROM tbl_properties_features_lists");
while($row = $res->fetch_assoc()){
    echo $row['Field'] . "\n";
}
