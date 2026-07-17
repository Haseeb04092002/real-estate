<?php
require 'd:/xampp/htdocs/properties_new/application/config/database.php';
$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
$res = $conn->query('SELECT * FROM tbl_properties_features_lists');
while($row=$res->fetch_assoc()) {
    print_r($row);
}
