<?php
include '../server/server.php';

// Function to show SweetAlert
function showAlert($icon, $title, $text) {
    echo "<script>
            Swal.fire({
                icon: '{$icon}',
                title: '{$title}',
                text: '{$text}'
            });
        </script>";
}

// Function to update project details and image
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each project
    foreach ($_POST['projects'] as $projectId => $project_data) {
        // Sanitize input data
        $title = mysqli_real_escape_string($conn, $project_data['title']);
        $description = mysqli_real_escape_string($conn, $project_data['description']);
        $technologies_used = mysqli_real_escape_string($conn, $project_data['technologies_used']);
        $role = mysqli_real_escape_string($conn, $project_data['role']);

        // Check if an image file is uploaded
        if ($_FILES['image']['name'][$projectId]) {
            // Process the uploaded image
            $targetDir = "../uploads/";
            $fileName = basename($_FILES["image"]["name"][$projectId]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Check if the uploaded file is an image
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload image to the server
                if (move_uploaded_file($_FILES["image"]["tmp_name"][$projectId], $targetFilePath)) {
                    // Update project details and image in the database
                    $update_query = "UPDATE projects_section SET title = '{$title}', description = '{$description}', technologies_used = '{$technologies_used}', role = '{$role}', image = '{$targetFilePath}' WHERE id = {$projectId}";
                    $result = mysqli_query($conn, $update_query);

                    if (!$result) {
                        showAlert('error', 'Error', 'Failed to update projects.');
                        exit(); // Exit the script if an error occurs
                    }
                } else {
                    showAlert('error', 'Error', 'Failed to upload image.');
                    exit(); // Exit the script if image upload fails
                }
            } else {
                showAlert('error', 'Error', 'Only JPG, JPEG, PNG, GIF files are allowed.');
                exit(); // Exit the script if invalid file type
            }
        } else {
            // Update project details without updating image in the database
            $update_query = "UPDATE projects_section SET title = '{$title}', description = '{$description}', technologies_used = '{$technologies_used}', role = '{$role}' WHERE id = {$projectId}";
            $result = mysqli_query($conn, $update_query);

            if (!$result) {
                showAlert('error', 'Error', 'Failed to update projects.');
                exit(); // Exit the script if an error occurs
            }
        }
    }

    showAlert('success', 'Success', 'Projects updated successfully.');
}

// Fetch existing data from the database if no form submission
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Fetch existing projects from the database
    $query = "SELECT * FROM projects_section";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Initialize array to store projects
        $projects = array();

        // Fetch projects and store them in the array
        while ($row = mysqli_fetch_assoc($result)) {
            $projects[] = $row;
        }
    } else {
        showAlert('error', 'Error', 'Failed to fetch projects.');
        exit(); // Exit the script if an error occurs
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects Update</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <style>
body {
    background-color: grey;
    color: #fff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Updated font */
}

.card {
    background: linear-gradient(to right, #39424f, #1f2833); /* Updated gradient colors */
    color: #fff;
    border: none;
    border-radius: 20px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    margin-top: 40px;
    max-height: 80vh; /* Set maximum height to 80% of viewport height */
    overflow-y: auto; /* Enable scrolling if content exceeds card height */
}

.card-header {
    background-color: transparent;
    border-bottom: none;
    color: #fff;
    padding-bottom: 0;
}

.card-header input {
    text-align: center;
    color: #fff;
    font-size: 1.5rem;
    font-weight: bold; /* Make the input text bold */
    border: none; /* Remove input border */
    background: none; /* Remove input background */
    outline: none; /* Remove input outline */
}

.btn-primary {
    background-color: #18c9e3;
    border: none;
    margin-top: 10px;
    margin-bottom: 10px;
    transition: background-color 0.3s; /* Smooth transition on hover */
}

.btn-primary:hover {
    background-color: #00acee;
}

.carousel-control-prev,
.carousel-control-next {
    background-color: black;
    border-radius: 50%;
    border: none;
    width: 50px;
    height: 50px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    color: #3498db;
    font-size: 2em;
}

.carousel-item {
    transition: transform 0.6s ease;
}

.carousel-control-prev,
.carousel-control-next {
    cursor: pointer;
    top: 0%;
    transform: translateY(-50%);
}

.carousel-control-prev {
    left: 5%;
}

.carousel-control-next {
    right: 5%;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: rgba(255, 255, 255, 0.5);
}

.card-body {
    padding-top: 10px;
    padding-bottom: 10px;
    max-height: calc(100% - 20px);
    overflow-y: auto;
}

.form-group {
    margin-bottom: 10px;
}

.form-control {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 25px; /* Add border-radius to form controls */
    background-color: rgba(255, 255, 255, 0.1); /* Update background color */
    border: 1px solid #fff; /* Add border */
    color: #fff;
}

.form-control:focus {
    border-color: #18c9e3; /* Change border color on focus */
}

.form-group label {
    color: white;
}

.preview-image {
    max-width: 150px;
    max-height: 150px;
    margin-top: 5px;
    border-radius: 10px; /* Add border-radius to the preview image */
}

/* Adjust positioning of the file input icon */
.fa-upload {
    background-color: #39424f;
    width: 100%;
    color: #18c9e3;
    cursor: pointer; 
    transition: color 0.3s ease;
    position: absolute;
    bottom: -16px;
    left: 0;
}

/* Adjust icon size and padding */
.fa-upload {
    font-size: 18px;
    padding: 7px; 
}

.fa-upload:hover {
    color: #00acee;
}




    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <?php if (!empty($projects)) : ?>
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="false">
                        <ol class="carousel-indicators">
                            <?php foreach ($projects as $index => $project) : ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $index; ?>" <?php if ($index === 0) echo 'class="active"'; ?>></li>
                            <?php endforeach; ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($projects as $index => $project) : ?>
                                <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <input type="text" class="form-control border-0 bg-transparent" value="<?php echo $project['title']; ?>">
                                        </div>
                                        <div class="card-body">
                                            <form method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="projects[<?php echo $project['id']; ?>][title]" value="<?php echo $project['title']; ?>">
                                                <div class="form-group" style="position: relative; display: inline-block;">
                                                    <?php if (!empty($project['image'])) : ?>
                                                        <img src="<?php echo $project['image']; ?>" alt="Current Image" class="preview-image">
                                                    <?php else : ?>
                                                        <p>No image uploaded</p>
                                                    <?php endif; ?>
                                                    <label for="image" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;">
                                                        <input type="file" class="form-control-file" id="image" name="image[<?php echo $project['id']; ?>]" onchange="previewImage(this);" style="opacity: 0; width: 100%; height: 100%;">
                                                        <i class="fas fa-upload"></i>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="projects[<?php echo $project['id']; ?>][description]" rows="3"><?php echo $project['description']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="technologies_used">Technologies Used</label>
                                                    <input type="text" class="form-control" id="technologies_used" name="projects[<?php echo $project['id']; ?>][technologies_used]" value="<?php echo $project['technologies_used']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="role">Role</label>
                                                    <input type="text" class="form-control" id="role" name="projects[<?php echo $project['id']; ?>][role]" value="<?php echo $project['role']; ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update Project</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        $('.carousel-control-prev').click(function() {
            $('#carouselExampleIndicators').carousel('prev');
        });

        $('.carousel-control-next').click(function() {
            $('#carouselExampleIndicators').carousel('next');
        });
    </script>
</body>

</html>