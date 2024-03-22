<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Messages</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background: linear-gradient(to right, #007bff, #00bfff);
      color: #fff;
      border-radius: 10px 10px 0 0;
    }
    .card-header h5 {
      margin-bottom: 0;
    }
    .badge {
      background-color: #6c757d;
    }
    .card-body {
      height: 200px; /* Adjust the height as needed */
      overflow-y: auto;
    }
    .card-body::-webkit-scrollbar {
      width: 10px;
    }
    .card-body::-webkit-scrollbar-track {
      background: #f1f1f1;
    }
    .card-body::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 5px;
    }
    .card-body::-webkit-scrollbar-thumb:hover {
      background: #555;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Messages</h2>
    <div class="row">
      <!-- Message Cards -->
      <?php
      // Assuming you have established a database connection
      include '../server/server.php';

      // Query to fetch all messages from the database, displaying the latest messages first
      $query = "SELECT * FROM contact_section ORDER BY id DESC";
      $result = mysqli_query($conn, $query);

      // Check if query was successful and if there are messages
      if ($result && mysqli_num_rows($result) > 0) {
        // Loop through each message and display it
        while ($row = mysqli_fetch_assoc($result)) {
          ?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">
                  <i class="fas fa-envelope mr-2"></i>
                  <?php echo $row['name']; ?>
                </h5>
                <span class="badge badge-pill badge-light">ID: <?php echo $row['id']; ?></span>
              </div>
              <div class="card-body">
                <p class="card-text"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p class="card-text"><strong>Contact Number:</strong> <?php echo $row['contact_number']; ?></p>
                <p class="card-text"><strong>Message:</strong> <?php echo $row['message']; ?></p>
                <p class="card-text"><small class="text-muted">Sent on: <?php echo date("F j, Y, g:i a", strtotime($row['created_at'])); ?></small></p>
              </div>
            </div>
          </div>
          <?php
        }
      } else {
        // Handle case when no messages are available
        echo "<div class='col'><p>No messages found.</p></div>";
      }

      // Close the database connection
      mysqli_close($conn);
      ?>
      <!-- End of Message Cards -->
    </div>
  </div>
</body>
</html>
