<?php
require_once 'db_connect.php';

// Get customer ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$id) {
    header("Location: index.php?error=Invalid customer ID");
    exit;
}

// Delete the customer
$stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php?success=deleted");
} else {
    header("Location: index.php?error=" . urlencode($conn->error));
}

$stmt->close();
$conn->close();
?>
