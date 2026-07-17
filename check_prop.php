<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'properties_new', 3307);
$conn->query("ALTER TABLE tbl_properties_contracts_type ADD COLUMN IsDeleted TINYINT(1) DEFAULT 0");
$conn->query("ALTER TABLE tbl_contract_templates ADD COLUMN IsDeleted TINYINT(1) DEFAULT 0");
$conn->query("ALTER TABLE tbl_contract_clauses ADD COLUMN IsDeleted TINYINT(1) DEFAULT 0");
echo "IsDeleted added successfully.\n";
?>
