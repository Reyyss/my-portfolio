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

// Fetch existing data from the database if no form submission
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $query = "SELECT * FROM about_section WHERE id = 1"; // Assuming id 1 for the About Me section
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $introduction_content = $row['introduction_content'];
        $passion_content = $row['passion_content'];
        $portfolio_content = $row['portfolio_content'];
        $tech_trends_content = $row['tech_trends_content'];
        $image = $row['image'];
    }
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $introduction_content = $_POST['introduction_content'];
    $passion_content = $_POST['passion_content'];
    $portfolio_content = $_POST['portfolio_content'];
    $tech_trends_content = $_POST['tech_trends_content'];

    // Check if a file is uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // File upload logic
        // Update the image column in the database
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file)) {
            // Use existing image
            $image = $target_file;
        } else {
            // Check file size
            if ($_FILES["image"]["size"] > 500000) {
                showAlert('error', 'Error', 'Sorry, your file is too large.');
                $uploadOk = 0;
            }
            
            // Allow only certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                showAlert('error', 'Error', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                $uploadOk = 0;
            }
            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                showAlert('error', 'Error', 'Sorry, your file was not uploaded.');
            // If everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Update the image path in the database
                    $image = $target_file;
                } else {
                    showAlert('error', 'Error', 'Sorry, there was an error uploading your file.');
                }
            }
        }
    } else {
        // If no file is uploaded, use the existing image from the database
        $query = "SELECT image FROM about_section WHERE id = 1"; // Assuming id 1 for the About Me section
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image = $row['image'];
        }
    }

    // Update data in the database using prepared statements
    $update_query = "UPDATE about_section SET introduction_content = ?, passion_content = ?, portfolio_content = ?, tech_trends_content = ?, image = ? WHERE id = 1";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssss", $introduction_content, $passion_content, $portfolio_content, $tech_trends_content, $image);

    if ($stmt->execute()) {
        showAlert('success', 'Success', 'Details updated successfully');
    } else {
        showAlert('error', 'Error', 'Error updating details: ' . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Update</title>
    <link rel="stylesheet" href="admin-css/about_update.css" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Internal CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update About Section</div>
                    <div class="card-body">
                        <form id="aboutForm" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <img id="imagePreview" src="<?php echo isset($image) ? $image : 'placeholder.jpg'; ?>" alt="Image" class="img-fluid mb-2">
                                <input type="file" class="form-control-file" id="image" name="image" onchange="previewImage()">
                            </div>
                            <div class="form-group">
                                <label for="introduction_content">Introduction</label>
                                <textarea class="form-control" id="introduction_content" name="introduction_content" rows="3" required><?php echo $introduction_content; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="passion_content">Passion</label>
                                <textarea class="form-control" id="passion_content" name="passion_content" rows="3" required><?php echo $passion_content; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="portfolio_content">Portfolio</label>
                                <textarea class="form-control" id="portfolio_content" name="portfolio_content" rows="3" required><?php echo $portfolio_content; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tech_trends_content">Tech Trends</label>
                                <textarea class="form-control" id="tech_trends_content" name="tech_trends_content" rows="3" required><?php echo $tech_trends_content; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const fileInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    </script>
</body>
</html>
