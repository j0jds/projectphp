<?php
require_once 'api/config/database.php';

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo "Funciona.";
}
?>
