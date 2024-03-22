<?php
$servername = "localhost"; // Change this to your database server name if different
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (empty)
$dbname = "cms_db"; // Change this to your database name where the login table is stored

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if title is set in the POST data
    if (isset($_POST['title'])) {
        // Sanitize input data
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        // Add sanitation for other fields if needed

        // Check if an image file is uploaded
        if ($_FILES['image']['name']) {
            // Process the uploaded image
            $targetDir = "../uploads/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Check if the uploaded file is an image
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Upload image to the server
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // Insert new project details into the database
                    $insert_query = "INSERT INTO projects_section (title, image) VALUES ('{$title}', '{$targetFilePath}')";
                    $result = mysqli_query($conn, $insert_query);

                    if ($result) {
                        // Project added successfully
                        header("Location: projects_update.php");
                        exit();
                    } else {
                        echo "Failed to add project.";
                    }
                } else {
                    echo "Failed to upload image.";
                }
            } else {
                echo "Only JPG, JPEG, PNG, GIF files are allowed.";
            }
        } else {
            echo "Please upload an image.";
        }
    } else {
        // Handle case where title is not set
        echo "Title is missing in the POST data.";
    }
}

// Function to update project details and image
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each project
    foreach ($_POST['projects'] as $projectId => $project_data) {
        // Check if the 'title' key exists
        if (isset($project_data['title'])) {
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
                            exit();
                        }
                    } else {
                        showAlert('error', 'Error', 'Failed to upload image.');
                        exit(); 
                    }
                } else {
                    showAlert('error', 'Error', 'Only JPG, JPEG, PNG, GIF files are allowed.');
                    exit();
                }
            } else {
                // No image uploaded, update project details only
                $update_query = "UPDATE projects_section SET title = '{$title}', description = '{$description}', technologies_used = '{$technologies_used}', role = '{$role}' WHERE id = {$projectId}";
                $result = mysqli_query($conn, $update_query);

                if (!$result) {
                    showAlert('error', 'Error', 'Failed to update projects.');
                    exit(); 
                }
            }
        } else {
            showAlert('error', 'Error', 'Title is missing for project with ID ' . $projectId);
            exit();
        }
    }

    showAlert('success', 'Success', 'Projects updated successfully.');
}


if ($_SERVER["REQUEST_METHOD"] != "POST") {

    $query = "SELECT * FROM projects_section";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        
        $projects = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $projects[] = $row;
        }
    } else {
        showAlert('error', 'Error', 'Failed to fetch projects.');
        exit(); 
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
    <link rel="stylesheet" href="admin-css/projects_update.css" />
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
                                            <!-- Add delete button -->
                                            <button class="btn btn-danger delete-project" data-project-id="<?php echo $project['id']; ?>"><i class="fas fa-times"></i></button>
                                            <button class="btn btn-success ml-4 add-project"><i class="fas fa-plus"></i></button>
                                        </div>
                                        <div class="card-body">
                                            <form method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="projects[<?php echo $project['id']; ?>][title]" value="<?php echo $project['title']; ?>">
                                                <div class="form-group" style="position: relative; display: inline-block;">
                                                    <?php if (!empty($project['image'])) : ?>
                                                        <img src="<?php echo $project['image']; ?>" alt="Current Image" class="preview-image" style="max-width: 100%; height: auto;">
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



    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JavaScript -->
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(input).closest('.form-group').find('.preview-image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('.carousel-control-prev').click(function() {
            $('#carouselExampleIndicators').carousel('prev');
        });

        $('.carousel-control-next').click(function() {
            $('#carouselExampleIndicators').carousel('next');
        });
    </script>

<script>
    $(document).ready(function() {
        // Delete project button click event
        $('.delete-project').click(function() {
            var projectId = $(this).data('project-id');
            // Call a function to confirm deletion or directly submit the form for deletion
            if (confirm("Are you sure you want to delete this project?")) {
                // Submit form for deletion
                var form = $('<form method="post" action="cms-content/action/delete_project.php"><input type="hidden" name="project_id" value="' + projectId + '"></form>');
                $('body').append(form);
                form.submit();
            }
        });
    });
</script>

</div>



<script>
    // Function to preview image when a file is selected
function previewNewImage(input) {
    // Check if any file is selected
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            // Display the preview image
            $('#previewNewImage').attr('src', e.target.result);
            $('.preview-container').show(); // Show the preview container
        }

        reader.readAsDataURL(input.files[0]);
    }
}
    $(document).ready(function() {
        // Add project button click event
        $('.add-project').click(function() {
            // Show SweetAlert for adding a new project
            Swal.fire({
                title: 'Add New Project',
                html: `
                    <label for="newTitle">Title</label>
                    <input type="text" id="newTitle" name="newTitle" class="swal-input">
                    
                    <label for="newDescription">Description</label>
                    <textarea id="newDescription" name="newDescription" rows="3" class="swal-input"></textarea>
                    
                    <label for="newTechnologies">Technologies Used</label>
                    <input type="text" id="newTechnologies" name="newTechnologies" class="swal-input">
                    
                    <label for="newRole">Role</label>
                    <input type="text" id="newRole" name="newRole" class="swal-input">
                    
                    <label for="newImage">Image</label>
                    <input type="file" id="newImage" name="newImage" onchange="previewNewImage(this);" class="swal-input">
                    
                    <div class="preview-container" style="display: none;">
                        <img id="previewNewImage" src="#" alt="Preview Image" style="max-width: 100%; height: auto;">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Add',
                preConfirm: () => {
                    // Handle form submission for adding a new project
                    var newTitle = $('#newTitle').val();
                    var newDescription = $('#newDescription').val();
                    var newTechnologies = $('#newTechnologies').val();
                    var newRole = $('#newRole').val();
                    var newImage = $('#newImage')[0].files[0];
                    
                    var formData = new FormData();
                    formData.append('title', newTitle);
                    formData.append('description', newDescription);
                    formData.append('technologies_used', newTechnologies);
                    formData.append('role', newRole);
                    formData.append('image', newImage);
                    
                    $.ajax({
                        url: '/MyPortfolio/admin/add_project.php',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Handle success response
                            // For example, show a success message
                            Swal.fire('Success', 'Project added successfully!', 'success');
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            // For example, show an error message
                            Swal.fire('Error', 'Failed to add project: ' + error, 'error');
                        }
                    });
                }
            });
        });
    });
</script>



</body>

</html>
