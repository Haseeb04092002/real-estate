<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'properties_new', 3307);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$fields = [];
$res = $conn->query("DESCRIBE tbl_properties");
while($row = $res->fetch_assoc()) {
    $fields[] = $row['Field'];
}
if (!in_array('Status', $fields)) {
    $conn->query("ALTER TABLE tbl_properties ADD COLUMN Status varchar(20) DEFAULT 'Draft'");
    $conn->query("UPDATE tbl_properties SET Status = 'Published'"); // existing ones to published
    echo "Status added successfully.\n";
} else {
    echo "Status already exists.\n";
}
?>
