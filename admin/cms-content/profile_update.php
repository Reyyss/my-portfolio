<?php
include '../server/server.php';

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get other form data
    $name = $_POST['name'];
    $cv_link = $_POST['cv_link'];
    $description = $_POST['description'];

    // Check if a file is uploaded
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $target_dir = "../uploads/"; // Specify the target directory where the file will be moved
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // If everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["profile_picture"]["name"])). " has been uploaded.";
                // Update the profile picture path in the database
                $profile_pic = $target_file;
                $update_query = "UPDATE home_section SET profile_pic = '$profile_pic'";
                if ($conn->query($update_query) === TRUE) {
                    echo "Profile picture updated successfully";
                } else {
                    echo "Error updating profile picture: " . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update other details in the database
    $update_query = "UPDATE home_section SET name = '$name', cv_link = '$cv_link', description = '$description'";
    if ($conn->query($update_query) === TRUE) {
        echo "Details updated successfully";
    } else {
        echo "Error updating details: " . $conn->error;
    }
}

// Query to fetch data from the home_section table
$query = "SELECT * FROM home_section";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $description = $row['description'];
    $cv_link = $row['cv_link'];
    // Retrieve the image path from the database
    $profile_pic = $row['profile_pic'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="admin-css/profile_update.css" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Internal CSS -->
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update Profile</div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group text-center mb-4">
                                <!-- Display the profile picture -->
                                <img id="preview" src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="profile-img">
                                <!-- Input to allow updating the profile picture -->
                                <label for="profile_picture" class="mt-2"></label>
                                <input type="file" class="custom-file-input mt-2" id="profile_picture" name="profile_picture" onchange="previewImage(this)">
                                <label class="btn btn-primary" for="profile_picture"><i class="fas fa-upload"></i> Choose File</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $name; ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="cv_link" name="cv_link" placeholder="CV Link" value="<?php echo $cv_link; ?>" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Description" required><?php echo $description; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
