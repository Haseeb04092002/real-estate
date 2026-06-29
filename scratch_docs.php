<?php
$db = new mysqli('127.0.0.1', 'root', '', 'properties_new', 3307);
$r = $db->query("SHOW COLUMNS FROM tbl_documents");
while($row = $r->fetch_assoc()) { echo $row['Field'] . ' - ' . $row['Type'] . "\n"; }
?>
