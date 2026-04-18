<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Menu Override</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 40px 20px;
    }

    .container {
      max-width: 550px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 14px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .welcome {
      font-weight: bold;
      color: #333;
    }

    .logout {
      text-decoration: none;
      color: red;
      font-weight: bold;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #222;
    }

    .success {
      color: green;
      text-align: center;
      margin-bottom: 16px;
      font-weight: bold;
    }

    label {
      display: block;
      margin-top: 14px;
      margin-bottom: 6px;
      font-weight: bold;
      color: #333;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    textarea {
      resize: vertical;
      min-height: 90px;
    }

    button {
      width: 100%;
      margin-top: 22px;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: orange;
      color: white;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: darkorange;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="top-bar">
      <p class="welcome">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
      <a class="logout" href="logout.php">Logout</a>
    </div>

    <h2>Update Daily Menu</h2>

    <?php if (isset($_GET['success'])): ?>
      <p class="success">Menu updated successfully!</p>
    <?php endif; ?>

    <form action="save_menu.php" method="POST">
      <label for="override_date">Date</label>
      <input type="date" id="override_date" name="override_date" required>

      <label for="meal_type">Meal Type</label>
      <select id="meal_type" name="meal_type" required>
        <option value="">Select meal type</option>
        <option value="breakfast">Breakfast</option>
        <option value="lunch">Lunch</option>
        <option value="dinner">Dinner</option>
      </select>

      <label for="item_name">Item Name</label>
      <input
        type="text"
        id="item_name"
        name="item_name"
        placeholder="e.g Chicken stew"
        required
      >

      <label for="item_description">Item Description</label>
      <textarea
        id="item_description"
        name="item_description"
        placeholder="Optional description"
      ></textarea>

      <label for="notes">Reason / Note</label>
      <textarea
        id="notes"
        name="notes"
        placeholder="e.g Brisket unavailable"
      ></textarea>

      <button type="submit">Save Menu Change</button>
    </form>
  </div>

</body>
</html>