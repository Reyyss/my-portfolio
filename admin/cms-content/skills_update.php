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

// Function to generate icon HTML based on the icon class input
function generateIconHTML($iconClass) {
    // Check if the icon class starts with 'fa ' indicating Font Awesome icon
    if (strpos($iconClass, 'fab ') === 0) {
        // If it's a Font Awesome icon, return the icon HTML
        return "<i class='{$iconClass} skill-icon'></i>";
    } else {
        // If it's not a Font Awesome icon, return the input class as is
        return "<span class='icon-text'>{$iconClass}</span>";
    }
}

// Fetch existing data from the database if no form submission
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Fetch existing skills from the database
    $query = "SELECT * FROM skills_section";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Initialize arrays to store skills
        $skills = array();

        // Fetch skills and store them in the array
        while ($row = mysqli_fetch_assoc($result)) {
            $skills[] = $row;
        }
    }
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update skill, proficiency, and icon
    // Loop through POST data to update each skill
    foreach ($_POST['skills'] as $id => $skill_data) {
        $skill = mysqli_real_escape_string($conn, $skill_data['skill']);
        $proficiency = (int)$skill_data['proficiency'];
        $icon = mysqli_real_escape_string($conn, $skill_data['icon']);

        // Update the skill in the database
        $update_query = "UPDATE skills_section SET skill = '{$skill}', proficiency = {$proficiency}, icon = '{$icon}' WHERE id = {$id}";
        $result = mysqli_query($conn, $update_query);

        if (!$result) {
            showAlert('error', 'Error', 'Failed to update skills.');
            exit(); // Exit the script if an error occurs
        }
    }

    showAlert('success', 'Success', 'Skills updated successfully.');
}

// If the form is submitted to add a new skill
if (isset($_POST['add_new_skill'])) {
    addSkill();
}

// If the form is submitted to delete a skill
if (isset($_POST['delete_skill_id'])) {
    deleteSkill($_POST['delete_skill_id']);
}

// Function to add a new skill
function addSkill() {
    global $conn;

    // Retrieve form data
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $newSkill = mysqli_real_escape_string($conn, $_POST['newSkill']);
    $newProficiency = (int)$_POST['newProficiency'];
    $newIcon = mysqli_real_escape_string($conn, $_POST['newIcon']);

    // Insert a new row into the database
    $insert_query = "INSERT INTO skills_section (category, skill, proficiency, icon) VALUES ('{$category}', '{$newSkill}', {$newProficiency}, '{$newIcon}')";
    $result = mysqli_query($conn, $insert_query);

    if ($result) {
        showAlert('success', 'Success', 'New skill added successfully.');
    } else {
        showAlert('error', 'Error', 'Failed to add new skill.');
    }
}

// Function to delete a skill
function deleteSkill($id) {
    global $conn;

    // Delete the skill from the database
    $delete_query = "DELETE FROM skills_section WHERE id = {$id}";
    $result = mysqli_query($conn, $delete_query);

    if ($result) {
        showAlert('success', 'Success', 'Skill deleted successfully.');
    } else {
        showAlert('error', 'Error', 'Failed to delete skill.');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills Update</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Internal CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .skill-icon {
            font-size: 16px;
            margin-right: 5px;
        }

        .icon-text {
            font-size: 14px;
            margin-right: 5px;
        }
        .btn {
            font-size: 14px;
        }
        .btn-danger .fas.fa-trash {
        font-size: 18px;
        color: white;
        }
        .btn i.fa {
            margin-right: 5px; /* Adjust spacing between icon and text */
        }

        /* Styling the "Add New Skill" button */
        .btn-add-skill {
            background-color: #28a745;
            color: white;
            border-color: #28a745; 
        }

        .btn-add-skill:hover {
            background-color: #218838;
            border-color: #1e7e34; 
        }

        /* Styling the "Update Skills" button */
        .btn-update-skills {
            background-color: #007bff;
            color: white; 
            border-color: #007bff;
        }

        .btn-update-skills:hover {
            background-color: #0056b3; 
            border-color: #0056b3; 
        }

    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <?php if (isset($skills) && !empty($skills)) : ?>
                <?php $categories = array_unique(array_column($skills, 'category')); ?>
                <?php foreach ($categories as $category) : ?>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0"><?php echo $category; ?></h5>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <?php foreach ($skills as $skill) : ?>
                                        <?php if ($skill['category'] === $category) : ?>
                                            <div class="form-group row align-items-center">
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <?php echo generateIconHTML($skill['icon']); ?>
                                                            </span>
                                                        </div>
                                                        <input type="text" class="form-control" name="skills[<?php echo $skill['id']; ?>][skill]" value="<?php echo $skill['skill']; ?>" placeholder="Skill">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="number" class="form-control" name="skills[<?php echo $skill['id']; ?>][proficiency]" value="<?php echo $skill['proficiency']; ?>" placeholder="Proficiency">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="skills[<?php echo $skill['id']; ?>][icon]" value="<?php echo $skill['icon']; ?>" placeholder="Icon">
                                                </div>
                                                <div class="col-sm-2">
                                                <button type="button" class="btn btn-danger" onclick="deleteSkill(<?php echo $skill['id']; ?>)"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                        <button type="button" class="btn btn-add-skill" onclick="addSkill('<?php echo $category; ?>')">
                                            <i class="fas fa-plus-circle"></i> Add New Skill
                                        </button>

                                        <button type="submit" class="btn btn-update-skills">
                                            <i class="fas fa-save"></i> Save Update
                                        </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Function to delete a skill
        function deleteSkill(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX request to delete the skill
                    $.ajax({
                        url: window.location.href,
                        type: 'POST',
                        data: {
                            delete_skill_id: id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Skill deleted successfully.',
                                onClose: () => {
                                    // Reload the page after closing the SweetAlert
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Show error message
                            showAlert('error', 'Error', 'Failed to delete skill.');
                        }
                    });
                }
            });
        }

        // Function to add a new skill
        function addSkill(category) {
            // Trigger the SweetAlert modal with the form to add a new skill
            Swal.fire({
                title: 'Add New Skill',
                html: `<form id="addSkillForm">
                        <input type="hidden" name="category" value="${category}">
                        <div class="form-group">
                            <label for="newSkill">Skill</label>
                            <input type="text" class="form-control" id="newSkill" name="newSkill" placeholder="Enter skill">
                        </div>
                        <div class="form-group">
                            <label for="newProficiency">Proficiency</label>
                            <input type="number" class="form-control" id="newProficiency" name="newProficiency" placeholder="Enter proficiency">
                        </div>
                        <div class="form-group">
                            <label for="newIcon">Icon</label>
                            <input type="text" class="form-control" id="newIcon" name="newIcon" placeholder="Enter icon">
                        </div>
                    </form>`,
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Add',
                cancelButtonText: 'Cancel',
                preConfirm: () => {
                    const formData = $('#addSkillForm').serialize();
                    const category = document.querySelector('input[name="category"]').value;
                    // Submit the form to add a new skill using AJAX
                    return $.ajax({
                        url: window.location.href,
                        type: 'POST',
                        data: formData + '&add_new_skill=true&category=' + category,
                        success: function(response) {
                            // Display the SweetAlert with the success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'New skill added successfully.',
                                onClose: () => {
                                    // Reload the page after closing the SweetAlert
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Display the SweetAlert with the error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to add new skill.'
                            });
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>
