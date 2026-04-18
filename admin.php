<?php
session_start();

// 🔒 protect page
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Menu Override</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 40px;
    }

    .container {
      max-width: 500px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 12px;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    textarea {
      resize: none;
    }

    button {
      width: 100%;
      margin-top: 20px;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: orange;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: darkorange;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .logout {
      text-decoration: none;
      color: red;
      font-weight: bold;
    }

    .success {
      color: green;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="container">

  <div class="top-bar">
    <p>Welcome, <?php echo $_SESSION['admin_username']; ?></p>
    <a class="logout" href="logout.php">Logout</a>
  </div>

  <h2>Update Daily Menu</h2>

  <?php if (isset($_GET['success'])): ?>
    <p class="success">Menu updated successfully!</p>
  <?php endif; ?>

  <form action="save_menu.php" method="POST">

    <!-- DATE -->
    <label>Date</label>
    <input type="date" name="override_date" required>

    <!-- MEAL TYPE -->
    <label>Meal Type</label>
    <select name="meal_type" required>
      <option value="">Select meal</option>
      <option value="breakfast">Breakfast</option>
      <option value="lunch">Lunch</option>
      <option value="dinner">Dinner</option>
    </select>

    <!-- ITEM NAME -->
    <label>Item Name</label>
    <input type="text" name="item_name" placeholder="e.g Chicken stew" required>

    <!-- DESCRIPTION -->
    <label>Item Description</label>
    <textarea name="item_description" rows="3" placeholder="Optional"></textarea>

    <!-- NOTE -->
    <label>Reason / Note</label>
    <textarea name="notes" rows="3" placeholder="e.g Brisket unavailable"></textarea>

    <button type="submit">Save Menu Change</button>

  </form>

</div>

</body>
</html>