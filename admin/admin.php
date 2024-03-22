

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>REY'S CMS</title>
  <link rel="stylesheet" href="admin-css/admin-style.css" />
  <!-- Link your CSS file here -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <!-- Font Awesome -->
  <!-- Include SweetAlert library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
// Include your database connection file
include '../server/server.php';

// Check if the notification icon is clicked
if (isset($_GET['mark_read'])) {
    // Update the status of unread messages to "read" in the database
    $update_query = "UPDATE contact_section SET status = 'read' WHERE status = 'unread'";
    $update_result = mysqli_query($conn, $update_query);

    // Check if the update was successful
    if (!$update_result) {
        echo "Failed to update messages status.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
<nav class="navbar">
    <div class="logo">
        <img src="../images/LOGO.png" alt="Logo" />
    </div>
    <div class="admin-profile">
        <?php
        // Include your database connection file
        include '../server/server.php';

        // Query to fetch the count of unread messages
        $query = "SELECT COUNT(*) AS unread_count FROM contact_section WHERE status = 'unread'";
        $result = mysqli_query($conn, $query);

        // Check if query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $unread_count = $row['unread_count'];
        } else {
            $unread_count = 0;
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
        <i class="fa fa-bell notification-icon">
            <?php if ($unread_count > 0): ?>
                <span class="notification-counter"><?php echo $unread_count; ?></span>
            <?php endif; ?>
        </i>
        <img src="../images/profile.png" alt="Admin Profile" />
        <!-- Dropdown form -->
        <div class="dropdown-content">
            <!-- Fetch and display latest messages sent within the last 24 hours -->
            <?php
            include '../server/server.php';

            $twentyFourHoursAgo = date('Y-m-d H:i:s', strtotime('-24 hours'));
            $query = "SELECT * FROM contact_section WHERE created_at > '$twentyFourHoursAgo' ORDER BY id DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='message'>";
                    echo "<i class='fas fa-envelope'></i>"; // Icon for message
                    echo "<div>";
                    echo "<strong>Name:</strong> " . $row['name'] . "<br>";
                    echo "<strong>Email:</strong> " . $row['email'] . "<br>";
                    echo "<strong>Message:</strong> " . $row['message'] . "<br>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='message'>No messages sent within the last 24 hours</div>";
            }

            mysqli_close($conn);
            ?>
        </div>
    </div>
</nav>

<script>
    // Add an event listener to the notification icon
    document.querySelector('.notification-icon').addEventListener('click', function(event) {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Define the request
        xhr.open('GET', window.location.pathname + '?mark_read=true', true);

        // Set up the onload function to handle the response
        xhr.onload = function() {
            // Check if the request was successful
            if (xhr.status >= 200 && xhr.status < 400) {
                // Toggle visibility of dropdown content
                document.querySelector('.dropdown-content').classList.toggle('show');
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        };

        // Set up the onerror function to handle errors
        xhr.onerror = function() {
            console.error('Request failed');
        };

        // Send the request
        xhr.send();

        // Prevent the default behavior of the icon click (redirecting)
        event.preventDefault();
    });

    // Close the dropdown when clicking outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.notification-icon')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                    // Reload the page after the dropdown is closed
                    window.location.reload();
                }
            }
        }
    }
</script>


  <div class="wrapper">
    <input type="checkbox" id="btn" hidden />
    <label for="btn" class="menu-btn">
      <i class="fas fa-bars"></i>
      <i class="fas fa-times"></i>
    </label>
    <nav id="sidebar">
      <div class="title">CMS Menu</div>
      <ul class="list-items">
        <!-- Add CMS options here -->
        <li <?php if ($page == 'dashboard') echo 'class="active"'; ?>>
          <a href="dashboard.php"><i class="fas fa-chart-line"></i>Dashboard</a>
        </li>
        <li <?php if ($page == 'profile') echo 'class="active"'; ?>>
          <a href="profile.php"><i class="fas fa-user"></i>Profile</a>
        </li>
        <li <?php if ($page == 'about') echo 'class="active"'; ?>>
          <a href="about.php"><i class="fas fa-info-circle"></i>About</a>
        </li>
        <li <?php if ($page == 'skills') echo 'class="active"'; ?>>
          <a href="skills.php"><i class="fas fa-cogs"></i>Skills</a>
        </li>
        <li <?php if ($page == 'projects') echo 'class="active"'; ?>>
          <a href="projects.php"><i class="fas fa-project-diagram"></i>Projects</a>
        </li>
        <li <?php if ($page == 'messages') echo 'class="active"'; ?>>
          <a href="messages.php"><i class="fas fa-envelope"></i>Messages</a>
        </li>
        <li>
          <a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </li>
      </ul>
    </nav>
  </div>
  <div class="content">
    <div class="content-container">
      <div class="cms-content">
        <!-- Add CMS content here -->
        <?php include_once $content_file; ?>
      </div>
    </div>
  </div>

  <script src="../js/logout.js"></script>
</body>
</html>
