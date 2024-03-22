<?php
include 'server/server.php';

// Query to fetch data from the home_section table
$query = "SELECT * FROM home_section";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $description = $row['description'];
    $cv_link = $row['cv_link'];
    // Get the filename from the database
    $filename = basename($row['profile_pic']);
    // Construct the path to the image file in the uploads folder
    $profile_pic = "uploads/" . $filename;
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Rey's - Portfolio</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/about-section.css?" />
    <link rel="stylesheet" href="css/contact-section.css" />
    <link rel="stylesheet" href="css/projects-section.css" />
    <link rel="stylesheet" href="css/skills-section.css" />
    <link rel="stylesheet" href="css/reponsiveness.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    />
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="admin/login/login.php"
        ><img src="images/LOGO.png" alt="Logo" style="height: 30px"
      /></a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#skills">Skills</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#projects">Projects</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
    </nav>

    <main>
      <!-- Home Section -->
      <section id="home">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <div class="text-center text-lg-left">
                <h2 class="display-4 mb-4">
                    Hello, it's me <br /><span id="name"><?php echo $name; ?></span>
                </h2>
                <h2 class="display-4 mb-4" id="work">
                  <span id="typing-text"></span><span id="cursor">_</span>
                </h2>

                <p class="lead">
                            <?php echo $description; ?>
                        </p>
                <a href="#contact" class="btn btn-outline-dark">
                  <i class="fas fa-envelope mr-1"></i> Message Me
                </a>
                <a href="<?php echo $cv_link; ?>" download class="btn btn-outline-dark">
                            <i class="fas fa-download mr-1"></i> Download CV
                        </a>
              </div>
            </div>
            <div class="col-lg-6 position-relative">
              <div class="profile-container">
              <img src="<?php echo $profile_pic; ?>" alt="profile" class="img-fluid rounded-circle mx-auto d-block" />
                <i class="fas fa-power-off power-icon"></i>
                <div class="social-icons">
                  <div class="social-icon facebook">
                    <i class="fab fa-facebook"></i>
                  </div>
                  <div class="social-icon github">
                    <i class="fab fa-github"></i>
                  </div>
                  <div class="social-icon telegram">
                    <i class="fab fa-telegram"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      <!-- About Section -->
      <section id="about">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6">
              <?php
              // Fetch image URL from the database
      $sql_image = "SELECT image FROM about_section WHERE id = 1"; // Assuming id 1 for the About Me section
      $result_image = $conn->query($sql_image);

      if ($result_image->num_rows > 0) {
          $row_image = $result_image->fetch_assoc();
          $image = $row_image["image"];
          // Replace spaces with %20 in the image URL
          $image = str_replace(" ", "%20", $image);
          echo '<img src="uploads/' . $image . '" alt="About Me" class="img-fluid rounded" id="about-me-profile">';
      } else {
          echo "Image not found";
      }
              ?>
            </div>
            <div class="col-lg-6">
              <div class="about-content">
                <h2 class="display-4 mb-4">About Me</h2>
                <?php
                // Fetch content from the database
                $sql_content = "SELECT introduction_content, passion_content, portfolio_content, tech_trends_content FROM about_section WHERE id = 1"; // Assuming id 1 for the About Me section
                $result_content = $conn->query($sql_content);

                if ($result_content->num_rows > 0) {
                    // Output data of each row
                    while($row_content = $result_content->fetch_assoc()) {
                        ?>
                        <div class="card lead">
                          <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user"></i> Introduction</h5>
                            <p class="card-text"><?php echo $row_content["introduction_content"]; ?></p>
                          </div>
                        </div>
                        <div class="card lead">
                          <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-heart"></i> Passion</h5>
                            <p class="card-text"><?php echo $row_content["passion_content"]; ?></p>
                          </div>
                        </div>
                        <div class="card lead">
                          <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-laptop-code"></i> Portfolio</h5>
                            <p class="card-text"><?php echo $row_content["portfolio_content"]; ?></p>
                          </div>
                        </div>
                        <div class="card lead">
                          <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-lightbulb"></i> Tech Trends</h5>
                            <p class="card-text"><?php echo $row_content["tech_trends_content"]; ?></p>
                          </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "0 results";
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>




<!-- Skills Section -->
<section id="skills" class="py-5">
    <div class="container">
        <h2 class="display-4 text-center">Skills</h2>

        <div class="row">
            <?php
            // Assuming you have established a database connection

            // Query to fetch data from the database
            $query = "SELECT category, skill, proficiency, icon FROM skills_section";
            $result = mysqli_query($conn, $query);

            // Check if query was successful
            if ($result && mysqli_num_rows($result) > 0) {
                // Initialize an array to store skills grouped by category
                $grouped_skills = array();

                // Loop through each row in the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    // Check if category already exists in the grouped_skills array
                    if (!isset($grouped_skills[$row['category']])) {
                        // If category doesn't exist, create it
                        $grouped_skills[$row['category']] = array();
                    }

                    // Add skill to the corresponding category
                    $grouped_skills[$row['category']][] = array(
                        'skill' => $row['skill'],
                        'proficiency' => $row['proficiency'],
                        'icon' => $row['icon']
                    );
                }

                // Counter for column iteration
                $column_counter = 0;

                // Loop through grouped skills and output HTML
                foreach ($grouped_skills as $category => $skills) {
                    // Output category in a 2x2 grid layout
                    if ($column_counter % 2 == 0) {
                        echo '<div class="col-md-6">';
                    }
                    ?>
                    <div class="text-center mb-4">
                        <h3><?php echo $category; ?></h3>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($skills as $skill) { ?>
                                <li class="list-group-item">
                                    <i class="<?php echo $skill['icon']; ?> mr-2"></i> <span><?php echo $skill['skill']; ?></span>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bg-<?php echo $category_colors[$category]; ?>" role="progressbar"
                                             style="width: <?php echo $skill['proficiency']; ?>%" aria-valuenow="<?php echo $skill['proficiency']; ?>"
                                             aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $skill['proficiency']; ?>%
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php
                    // Close column div for every two categories
                    if ($column_counter % 2 == 1 || $column_counter == count($grouped_skills) - 1) {
                        echo '</div>';
                    }
                    $column_counter++;
                }
            } else {
                // Handle case when no data is available
                echo "<p>No skills found.</p>";
            }

            // Close the database connection
            mysqli_close($conn);
            ?>
        </div>
    </div>
</section>


    <!-- Projects Section -->
    <section id="projects" class="py-5">
        <div class="container">
            <h2 class="display-4 text-center">Projects</h2>
            <div class="row mt-5">
                <?php
                include 'server/server.php';
                // Assuming you have established a database connection

                // Base URL for images
                $base_url = "./uploads/";

                // Query to fetch data from the database
                $query = "SELECT title, description, technologies_used, role, image FROM projects_section";
                $result = mysqli_query($conn, $query);

                // Check if query was successful
                if ($result && mysqli_num_rows($result) > 0) {
                    // Loop through each row in the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <!-- Project Card -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="flip-card">
                                    <div class="flip-card-inner">
                                        <!-- Front face of the card -->
                                        <div class="flip-card-front">
                                            <div class="position-relative">
                                                <img
                                                    src="<?php echo $base_url . $row['image']; ?>"
                                                    class="card-img-top"
                                                    alt="<?php echo $row['title']; ?>"
                                                />
                                                <div class="card-title-inside"><?php echo $row['title']; ?></div>
                                            </div>
                                        </div>
                                        <!-- Back face of the card -->
                                        <div class="flip-card-back">
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <?php echo $row['description']; ?>
                                                </p>
                                                <p class="card-text">
                                                    Technologies Used: <?php echo $row['technologies_used']; ?>
                                                    <br />
                                                    Role: <?php echo $row['role']; ?>
                                                </p>
                                                <a
                                                    href="#"
                                                    class="btn btn-outline-dark"
                                                    id="see-project"
                                                >
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Project Card -->
                        <?php
                    }
                } else {
                    // Handle case when no data is available
                    echo "<p>No projects found.</p>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>



<!-- Contact Section -->
<section id="contact" class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto text-center">
        <h2 class="display-4 mb-4">Contact Me</h2>
        <p class="lead mb-4">
          I'm excited to hear from you. Feel free to reach out!
        </p>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6 mx-auto">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                placeholder="Enter your name"
              />
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              </div>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                placeholder="Enter your email"
              />
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
              </div>
              <input
                type="text"
                class="form-control"
                id="contact_number"
                name="contact_number"
                placeholder="Enter your contact number"
              />
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-comment"></i></span>
              </div>
              <textarea
                class="form-control"
                id="message"
                name="message"
                rows="4"
                placeholder="Enter your message"
              ></textarea>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="submit_contact">
            <i class="fas fa-paper-plane mr-2"></i> Send Message
          </button>
        </form>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-8 mx-auto text-center">
        <p class="lead mb-4">Connect with me on social media:</p>
        <i class="fab fa-facebook mx-3" id="social"></i>
        <i class="fab fa-telegram mx-3" id="social"></i>
        <i class="fab fa-github mx-3" id="social"></i>
      </div>
    </div>
  </div>
</section>


      <!-- SweetAlert CDN -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

      <?php
// Check if the form is submitted
if (isset($_POST['submit_contact'])) {
    // Establish database connection (replace these values with your actual database credentials)
    include 'server/server.php';

    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO contact_section (name, email, contact_number, message) VALUES (?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $contact_number, $message);

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $message = $_POST['message'];

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Close statement and database connection
        $stmt->close();
        $conn->close();

        // Trigger SweetAlert success message
        echo "<script>
                swal('Success!', 'Message sent successfully!', 'success');
              </script>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>



      <!-- Footer Section -->
      <footer class="py-3 text-white text-center">
        <div class="container">
          <p>&copy; 2024 Reynido S. Hamog</p>
        </div>
      </footer>
    </main>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="js/text-animation.js"></script>
    <script src="js/icon-display.js"></script>
    <script src="js/active-nav.js"></script>
  </body>
</html>
