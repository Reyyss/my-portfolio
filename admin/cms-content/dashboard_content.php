<?php
// Include your database connection file
include '../server/server.php';

// Query to fetch the count of messages received each day for the past 7 days
$messagesData = array();
$labels = array();
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $query = "SELECT COUNT(*) AS messages_count FROM contact_section WHERE DATE(created_at) = '$date'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $messagesData[] = $row['messages_count'];
    $labels[] = date('D', strtotime($date));
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Custom CSS -->
  <style>
    .card-title {
      color: #18c9e3; /* Title color */
    }
    #messagesChart, #visitorsChart {
      max-height: 200px; /* Adjust the height as needed */
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row mt-5">
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fas fa-briefcase"></i> Portfolio Projects</h5>
            <!-- Placeholder content for portfolio projects -->
            <p class="card-text">Total Projects: 10</p>
            <p class="card-text">Completed Projects: 8</p>
            <p class="card-text">Ongoing Projects: 2</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fas fa-tasks"></i> Tasks</h5>
            <!-- Placeholder content for tasks -->
            <p class="card-text">Total Tasks: 20</p>
            <p class="card-text">Completed Tasks: 15</p>
            <p class="card-text">Pending Tasks: 5</p>
          </div>
        </div>
      </div>

      <?php
        // Include your database connection file
        include '../server/server.php';

        // Query to fetch the count of messages sent today, this week, and this month
        $today = date('Y-m-d');
        $thisWeek = date('Y-m-d', strtotime('-7 days'));
        $thisMonth = date('Y-m-01');
        $query = "SELECT COUNT(*) AS sent_today FROM contact_section WHERE created_at >= '$today'";
        $result = mysqli_query($conn, $query);
        $sent_today = mysqli_fetch_assoc($result)['sent_today'];

        $query = "SELECT COUNT(*) AS sent_this_week FROM contact_section WHERE created_at >= '$thisWeek'";
        $result = mysqli_query($conn, $query);
        $sent_this_week = mysqli_fetch_assoc($result)['sent_this_week'];

        $query = "SELECT COUNT(*) AS sent_this_month FROM contact_section WHERE created_at >= '$thisMonth'";
        $result = mysqli_query($conn, $query);
        $sent_this_month = mysqli_fetch_assoc($result)['sent_this_month'];

        // Close the database connection
        mysqli_close($conn);
        ?>

        <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title"><i class="fas fa-envelope"></i> Messages</h5>
            <!-- Display fetched data -->
            <p class="card-text">Received Today: <?php echo $sent_today; ?></p>
            <p class="card-text">Received This Week: <?php echo $sent_this_week; ?></p>
            <p class="card-text">Received This Month: <?php echo $sent_this_month; ?></p>
            </div>
        </div>
        </div>

    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><i class="fas fa-chart-line"></i> Graphs</h5>
            <div class="row">
              <div class="col-lg-6">
                <!-- Placeholder content for graph -->
                <canvas id="messagesChart" width="200" height="100"></canvas>
              </div>
              <div class="col-lg-6">
                <!-- Placeholder content for graph -->
                <canvas id="visitorsChart" width="200" height="100"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and Chart.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>


  <?php
// Include your database connection file
include '../server/server.php';

// Get the current week's start and end date
$today = date('Y-m-d');
$startOfWeek = date('Y-m-d', strtotime('last Sunday', strtotime($today)));
$endOfWeek = date('Y-m-d', strtotime('next Saturday', strtotime($today)));

// Initialize an array to store the count of messages for each day of the week
$messagesCount = array_fill(0, 7, 0);

// Query to fetch the count of messages for each day of the current week
$query = "SELECT DATE(created_at) AS date, COUNT(*) AS count FROM contact_section WHERE created_at BETWEEN '$startOfWeek' AND '$endOfWeek' GROUP BY DATE(created_at)";
$result = mysqli_query($conn, $query);

// Store the fetched data into the $messagesCount array
while ($row = mysqli_fetch_assoc($result)) {
    // Calculate the index of the day (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
    $dayOfWeek = date('w', strtotime($row['date']));
    $messagesCount[$dayOfWeek] = $row['count'];
}

// Close the database connection
mysqli_close($conn);
?>


  <!-- JavaScript code to initialize the charts -->
  <script>

// Sample data for the messages chart
const messagesLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']; // Days of the week
const messagesData = {
  labels: messagesLabels,
  datasets: [{
    label: 'Messages Received',
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgba(255, 99, 132, 1)',
    borderWidth: 1,
    data: <?php echo json_encode(array_merge(array_slice($messagesCount, 1), array_slice($messagesCount, 0, 1))); ?>, // Shift the data to start with Monday
  }]
};

// Configuration options for the messages chart
const messagesConfig = {
  type: 'line',
  data: messagesData,
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1 // Display only whole numbers
        }
      }
    }
  }
};

// Initialize the messages chart
var messagesChart = new Chart(
  document.getElementById('messagesChart'),
  messagesConfig
);


    // Sample data for the visitors chart
    const visitorsLabels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
    const visitorsData = {
      labels: visitorsLabels,
      datasets: [{
        label: 'Website Visitors',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        data: [50, 150, 200, 100, 350, 150, 350], // Sample data for website visitors
      }]
    };
    
    // Configuration options for the visitors chart
    const visitorsConfig = {
      type: 'line',
      data: visitorsData,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };

    // Initialize the visitors chart
    var visitorsChart = new Chart(
      document.getElementById('visitorsChart'),
      visitorsConfig
    );
  </script>
</body>
</html>
