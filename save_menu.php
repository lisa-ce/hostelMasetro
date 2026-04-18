<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    die("Access denied");
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $override_date = $_POST['override_date'] ?? '';
    $meal_type = $_POST['meal_type'] ?? '';
    $item_name = $_POST['item_name'] ?? '';
    $item_description = $_POST['item_description'] ?? '';
    $notes = $_POST['notes'] ?? '';

    if (empty($override_date) || empty($meal_type) || empty($item_name)) {
        die("Please fill in all required fields.");
    }

    $sql = "INSERT INTO menu_overrides (override_date, meal_type, item_name, item_description, notes)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $override_date, $meal_type, $item_name, $item_description, $notes);

    if ($stmt->execute()) {
        header("Location: admin.php?success=1");
        exit();
    } else {
        echo "Error saving menu change: " . $conn->error;
    }

    $stmt->close();
} else {
    die("Invalid request.");
}

$conn->close();
?>