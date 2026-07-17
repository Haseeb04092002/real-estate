<?php $conn = new mysqli("localhost", "root", "", "properties_new"); $result = $conn->query("SHOW TABLES"); while($row = $result->fetch_array()) { echo $row[0] . "\n"; } ?>
