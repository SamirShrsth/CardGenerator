<?php
session_start();
require_once '../../controllers/AuthController.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $authController = new AuthController();

    if ($role == 'user') {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $profile_image = $_FILES['profile_image'];

        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            $error_message = "All fields are required for user registration.";
        } else {
            $registrationResult = $authController->registerUser ($first_name, $last_name, $email, $password, $profile_image);
            if ($registrationResult === true) {
                header("Location: http://localhost/CardGenerator/");
                exit;
            } else {
                $error_message = $registrationResult; // Capture error message from registration
            }
        }
    } else if ($role == 'org') {
        $org_name = $_POST['org_name'];
        $org_email = $_POST['org_email'];
        $address = $_POST['org_address'];
        $phone = $_POST['org_phone'];
        $logo = $_FILES['org_logo'];
        $password = $_POST['org_password'];

        if (empty($org_name) || empty($org_email) || empty($address) || empty($phone) || empty($password)) {
            $error_message = "All fields are required for organization registration.";
        } else {
            $registrationResult = $authController->registerOrganization($org_name, $org_email, $address, $phone, $logo, $password);
            if ($registrationResult === true) {
                header("Location: http://localhost/CardGenerator/");
                exit;
            } else {
                $error_message = $registrationResult; // Capture error message from registration
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/login.css">
    <title>Register</title>
    <style>
        .container {
            margin-top: 100px;
        }
        .error-message {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <?php include '../components/header.php' ?>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data" id="registerForm">
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role">
                    <option value="user">User</option>
                    <option value="org">Organization</option>
                </select>
            </div>
            <!-- User Fields -->
            <div id="userFields">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name">
                    <span class="error-message" id="firstNameError"></span>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name">
                    <span class="error-message" id="lastNameError"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email">
                    <span class="error-message" id="emailError"></span>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                    <span class="error-message" id="passwordError"></span>
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/png, image/jpeg">
                    <span class="error-message" id="profileImageError"></span>
                </div>
            </div>

            <!-- Organization Fields -->
            <div id="orgFields" style="display: none;">
                <div class="form-group">
                    <label for="org_name">Organization Name:</label>
                    <input type="text" name="org_name" id="org_name">
                    <span class="error-message" id="orgNameError"></span>
                </div>
                <div class="form-group">
                    <label for="org_email">Email:</label>
                    <input type="email" name="org_email" id="org_email">
                    <span class="error-message" id="orgEmailError"></span>
                </div>
                <div class="form-group">
                    <label for="org_address">Address:</label>
                    <input type="text" name="org_address" id="org_address">
                    <span class="error-message" id="orgAddressError"></span>
                </div>
                <div class="form-group">
                    <label for="org_phone">Phone:</label>
                    <input type="tel" name="org_phone" id="org_phone">
                    <span class="error-message" id="orgPhoneError"></span>
                </div>
                <div class="form-group">
                    <label for="org_logo">Organization Logo:</label>
                    <input type="file" name="org_logo" id="org_logo" accept="image/png, image/jpeg">
                    <span class="error-message" id="orgLogoError"></span>
                </div>
                <div class="form-group">
                    <label for="org_password">Password:</label>
                    <input type="password" name="org_password" id="org_password">
                    <span class="error-message" id="orgPasswordError"></span>
                </div>
            </div>

            <button type="submit">Register</button>
        </form>

        <script>
            document.getElementById('role').addEventListener('change', function() {
                const userFields = document.getElementById('userFields');
                const orgFields = document.getElementById('orgFields');
                if (this.value === 'org') {
                    userFields.style.display = 'none';
                    orgFields.style.display = 'block';
                } else {
                    userFields.style.display = 'block';
                    orgFields.style.display = 'none';
                }
            });

            document.getElementById('registerForm').addEventListener('submit', function(event) {
                let valid = true;

                // Reset error messages
                document.querySelectorAll('.error-message').forEach(function(span) {
                    span.textContent = '';
                });

                // Validate user fields
                if (document.getElementById('role').value === 'user') {
                    const firstName = document.getElementById('first_name').value;
                    const lastName = document.getElementById('last_name').value;
                    const email = document.getElementById('email').value;
                    const password = document.getElementById('password').value;
                    const profileImage = document.getElementById('profile_image').files[0];

                    const nameRegex = /^[A-Za-z ]+$/;
                    if (!nameRegex.test(firstName.trim())) {
                        document.getElementById('firstNameError').textContent = "Please enter a valid first name (letters and spaces only).";
                        valid = false;
                    }
                    if (!nameRegex.test(lastName.trim())) {
                        document.getElementById('lastNameError').textContent = "Please enter a valid last name (letters and spaces only).";
                        valid = false;
                    }
                    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    if (!emailRegex.test(email)) {
                        document.getElementById('emailError').textContent = "Please enter a valid email address.";
                        valid = false;
                    }
                    if (password.length < 6) {
                        document.getElementById('passwordError').textContent = "Password must be at least 6 characters long.";
                        valid = false;
                    }
                    if (profileImage && !['image/png', 'image/jpeg'].includes(profileImage.type)) {
                        document.getElementById('profileImageError').textContent = "Profile image must be a PNG or JPG file.";
                        valid = false;
                    }
                }

                // Validate organization fields
                if (document.getElementById('role').value === 'org') {
                    const orgName = document.getElementById('org_name').value;
                    const orgEmail = document.getElementById('org_email').value;
                    const orgAddress = document.getElementById('org_address').value;
                    const orgPhone = document.getElementById('org_phone').value;
                    const orgPassword = document.getElementById('org_password').value;
                    const orgLogo = document.getElementById('org_logo').files[0];

                    const nameRegex = /^[A-Za-z ]+$/;
                    if (!nameRegex.test(orgName.trim())) {
                        document.getElementById('orgNameError').textContent = "Please enter a valid organization name (letters and spaces only).";
                        valid = false;
                    }
                    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    if (!emailRegex.test(orgEmail)) {
                        document.getElementById('orgEmailError').textContent = "Please enter a valid email address.";
                        valid = false;
                    }
                    if (orgAddress.trim() === '') {
                        document.getElementById('orgAddressError').textContent = "Address is required.";
                        valid = false;
                    }
                    if (orgPhone.trim() === '') {
                        document.getElementById('orgPhoneError').textContent = "Phone number is required.";
                        valid = false;
                    }
                    if (orgPassword.length < 6) {
                        document.getElementById('orgPasswordError').textContent = "Password must be at least 6 characters long.";
                        valid = false;
                    }
                    if (orgLogo && !['image/png', 'image/jpeg'].includes(orgLogo.type)) {
                        document.getElementById('orgLogoError').textContent = "Organization logo must be a PNG or JPG file.";
                        valid = false;
                    }
                }

                if (!valid) {
                    event.preventDefault(); // Prevent form submission
                }
            });

            // Clear error messages on input
            document.querySelectorAll('input, textarea').forEach(function(input) {
                input.addEventListener('input', function() {
                    this.nextElementSibling.textContent = '';
                });
            });
        </script>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>