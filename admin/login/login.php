<?php
    // Connect to the database
    include '../../server/server.php';
    
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form values
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, email, password FROM login WHERE email = ?");
    $stmt->bind_param("s", $username);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the query was successful and if there is a user with the given username
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if ($password === $row['password']) {
            // Login successful
            $_SESSION['email'] = $username;
            // Redirect the user to the appropriate page based on their role
            header('Location: ../dashboard.php');
            exit();
        } else {
            // Invalid password
            $error = 'Invalid password';
        }
    } else {
        // No user found with the provided username
        $error = 'User not found';
    }

    // Close the statement
    $stmt->close();
    // Close the database connection
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Page</title>
    <link rel="stylesheet" href="../admin-css/login.css"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

</head>
<body>

<div class="container">
    
<video autoplay muted loop id="background-video">
    <source src="../../images/back1.mp4" type="video/mp4">
  </video>
    <div class="login-form">
        <i class="fas fa-times exit-icon" onclick="history.go(-1)"></i>
        <div class="login-form-header">
            <h2>Login</h2>
        </div>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <div class="input-group">
            <input
                type="email"
                class="form-control"
                placeholder="Email"
                name="email" 
                required
            />
            <div class="input-group-append">
                <span class="input-group-text"
                ><i class="fas fa-user"></i
                    ></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <input
                type="password"
                class="form-control"
                placeholder="Password"
                name="password"
                required
            />
            <div class="input-group-append">
                <span class="input-group-text"
                ><i class="fas fa-lock"></i
                    ></span>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Login</button>
</form>
        <?php
        // Check if error is set and display error message if it is
        if (isset($error)) {
          echo "<div class='alert alert-danger mt-3' role='alert'>$error</div>";
        }
        ?>
    </div>
</div>
</body>
</html>
