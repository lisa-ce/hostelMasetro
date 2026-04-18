<?php
session_start();
include 'db.php';

// If already logged in, go straight to admin
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check user in database
    $sql = "SELECT * FROM admin_users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // For now we use plain text password (simple version)
        if ($password === $user['password']) {

            // Create session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];

            // Redirect to admin page
            header("Location: admin.php");
            exit();
        } else {
            $error = "Incorrect password";
        }

    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Login</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: white;
      padding: 30px;
      border-radius: 12px;
      width: 320px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    button {
      width: 100%;
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

    .error {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Staff Login</h2>

  <?php if ($error): ?>
    <p class="error"><?php echo $error; ?></p>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>