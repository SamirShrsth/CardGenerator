<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css"> 
    <link rel="stylesheet" href="/CardGenerator/assets/css/contact.css"> 
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group select {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5H7z" fill="%23333"/></svg>') no-repeat right 10px center;
            background-color: #fff;
            background-size: 12px;
        }
        .form-group select:focus {
            border-color: #4CAF50;
        }
        .error-message {
            color: red;
            font-size: 12px;
        }
        .contact-submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .contact-submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php include '../components/header.php'; ?>

    <section class="contact-section">
        <h2>Contact Us</h2>
        <p>If you have any questions, feel free to reach out to us by filling out the form below.</p>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Your message has been sent successfully!</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error-message">There was an error sending your message. Please try again.</p>
        <?php endif; ?>

        <div class="contact-form-container">
            <div class="form-right">
                <form class="contact-form" method="POST" action="../../controllers/ContactController.php">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name">
                        <span id="name-error" class="error-message" style="color: red;"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Your Email</label>
                        <input type="text" id="email" name="email" placeholder="Enter your email">
                        <span id="email-error" class="error-message" style="color: red;"></span>
                    </div>

                    <div class="form-group">
                        <label for="organization">Organization</label>
                        <select id="organization" name="organization">
                            <option value="">Select an organization</option>
                            <?php
                            // Fetch organizations from the database
                            require_once '../../config/Database.php';
                            $database = new Database();
                            $conn = $database->getConnection();
                            $query = "SELECT org_id, org_name FROM organizations";
                            $result = $conn->query($query);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($row['org_id']) . '">' . htmlspecialchars($row['org_name']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <span id="organization-error" class="error-message" style="color: red;"></span>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" rows="4" placeholder="Write your message"></textarea>
                        <span id="message-error" class="error-message" style="color: red;"></span>
                    </div>

                    <button type="submit" class="contact-submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>
    <script>
        document.querySelector('.contact-form').addEventListener('submit', function(event) {
            let isValid = true;
            
            // Name validation (only letters and spaces allowed)
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('name-error');
            const nameRegex = /^[A-Za-z ]+$/;
            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Name is required.';
                isValid = false;
            } else if (!nameRegex.test(nameInput.value.trim())) {
                nameError.textContent = 'Please enter a valid name (letters and spaces only).';
                isValid = false;
            } else {
                nameError.textContent = '';
            }
            
            // Email validation
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() === '') {
                emailError.textContent = 'Email is required.';
                isValid = false;
            } else if (!emailRegex.test(emailInput.value.trim())) {
                emailError.textContent = 'Please enter a valid email address.';
                isValid = false;
            } else {
                emailError.textContent = '';
            }

            // Organization validation
            const organizationInput = document.getElementById('organization');
            const organizationError = document.getElementById('organization-error');
            if (organizationInput.value.trim() === '') {
                organizationError.textContent = 'Organization is required.';
                isValid = false;
            } else {
                organizationError.textContent = '';
            }

            // Message validation
            const messageInput = document.getElementById('message');
            const messageError = document.getElementById('message-error');
            if (messageInput.value.trim() === '') {
                messageError.textContent = 'Message is required.';
                isValid = false;
            } else {
                messageError.textContent = '';
            }
            
            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>