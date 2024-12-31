<?php
session_start();
include '../../config/Database.php';

// Fetch profile image for the logged-in user

$profile_image = 'default_profile.png';
$first_name = '';
$last_name = '';

if (isset($_SESSION['user_id'])) {
    $database = new Database();
    $conn = $database->getConnection();

    $user_id = $_SESSION['user_id'];
    $query = "SELECT profile_image, first_name, last_name FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $profile_image = $user['profile_image'] ?? 'default_profile.png';
        $first_name = $user['first_name'] ?? '';
        $last_name = $user['last_name'] ?? '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create ID Card</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/templates.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/create_card.css">
    <style>
         .flip-card {
            position: relative;
            width: 486px;
            height: 306px;
            perspective: 1000px;
            margin: 20px auto;
            cursor: pointer; /* Add pointer cursor to indicate it's clickable */
        }

        .flip-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
        }

        .flip-card-front,
        .flip-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background-size: cover;
        }

        .flip-card-back {
            transform: rotateY(180deg);
            background-color: #f8f8f8;
        }
        .barcode {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .barcode img {
            width: 100px;
            height: 40px;
        }
    </style>
</head>
<body data-profile-image="<?php echo htmlspecialchars($profile_image, ENT_QUOTES, 'UTF-8'); ?>">
    <?php include '../components/header.php'; ?>

    <div class="container">
        <section class="create-card-section">   
            <h2>Request ID Card</h2>
            <form id="createCardForm">
                <div class="form-group">
                    <label for="template">Select Template:</label>
                    <select name="template" id="template" required>
                        <option value="">--Select a Template--</option>
                        <?php
                        // Fetch templates and organization names from the database
                        $query = "SELECT ct.template_id, ct.front_image, ct.back_image, ct.orientation, o.org_name, o.logo, o.address, o.phone 
                                FROM card_templates ct 
                                JOIN organizations o ON ct.creator_id = o.org_id 
                                WHERE ct.creator_type = 'organization'";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['template_id']) . '" 
                                data-front-image="' . htmlspecialchars($row['front_image']) . '"
                                data-back-image="' . htmlspecialchars($row['back_image']) . '"
                                data-orientation="' . htmlspecialchars($row['orientation']) . '"
                                data-logo="' . htmlspecialchars($row['logo']) . '" 
                                data-address="' . htmlspecialchars($row['address']) . '" 
                                data-phone="' . htmlspecialchars($row['phone']) . '"
                                data-org-id="' . htmlspecialchars($row['org_id']) . '">' 
                                . htmlspecialchars($row['org_name']) . '</option>';                            
                            }
                        } else {
                            echo '<option value="">No templates available</option>';
                        }
                        ?>
                    </select>

                </div>

                <img id="templatePreview" src="" alt="Template Preview" style="display:none;">

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required value="<?php echo htmlspecialchars($first_name . ' ' . $last_name, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="idNumber">Registration Number:</label>
                    <input type="text" id="idNumber" name="idNumber" placeholder="Enter your registration number" required>
                </div>

                <div class="form-group">
                    <label for="department">Department:</label>
                    <input type="text" id="department" name="department" placeholder="Enter your department" required>
                </div>

                <button type="button" id="generateCardBtn" class="submit-btn">Generate Card</button>
            </form>

            <div id="cardDisplay" class="card-display" style="display:none;">
                <h3>Your ID Card</h3>
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div id="cardFront" class="flip-card-front"></div>
                        <div id="cardBack" class="flip-card-back"></div>
                    </div>
                </div>
                <button id="requestCardBtn" class="submit-btn" style="display:none;">Request Card</button>
            </div>


        </section>
    </div>

    <script>
        document.getElementById('template').addEventListener('change', function() {
            const selectedTemplate = this.value;
            console.log('Selected Template ID:', selectedTemplate);
        });

        document.getElementById('template').addEventListener('change', function() {
            const selectedOption = this.selectedOptions[0];
            const selectedTemplate = selectedOption.value;
            const orgLogo = selectedOption.getAttribute('data-logo');
            const orientation = selectedOption.getAttribute('data-orientation');
            const templatePreview = document.getElementById('templatePreview');

            if (selectedTemplate) {
                const frontImage = selectedOption.getAttribute('data-front-image');
                templatePreview.src = `/CardGenerator/controllers/${frontImage}`;
                templatePreview.style.display = 'block';
            } else {
                templatePreview.style.display = 'none';
            }


            // Update card preview styles based on orientation
            const cardPreview = document.getElementById('templatePreview');
            cardPreview.classList.remove('portrait', 'landscape');
            cardPreview.classList.add(orientation); // Add the orientation class
        });

        // Generate Card Logic
        //Hide generateCardBtn on click
        document.getElementById('generateCardBtn').addEventListener('click', function () {
            const template = document.getElementById('template').value;
            const frontTemplate = document.getElementById('template').selectedOptions[0].getAttribute('data-front-image');
            const backTemplate = document.getElementById('template').selectedOptions[0].getAttribute('data-back-image');
            const name = document.getElementById('name').value;
            const idNumber = document.getElementById('idNumber').value;
            const department = document.getElementById('department').value;

            const selectedOption = document.getElementById('template').selectedOptions[0];
            const orgName = selectedOption.text;
            const orgLogo = selectedOption.getAttribute('data-logo');
            const orgAddress = selectedOption.getAttribute('data-address');
            const orgPhone = selectedOption.getAttribute('data-phone');
            const orientation = selectedOption.getAttribute('data-orientation');

            const cardFront = document.getElementById('cardFront');
            const cardBack = document.getElementById('cardBack');
            const profileImage = '/CardGenerator/assets/img/profile_images/' + document.body.getAttribute('data-profile-image');

            // Populate the front side
            cardFront.style.backgroundImage = `url('/CardGenerator/controllers/${frontTemplate}')`;
            cardFront.innerHTML = `
                <div class="card ${orientation}">
                    <div class="user-info">
                        <img src="${profileImage}" alt="User Image" class="user-image">
                        <h4>${name}</h4>
                        <p>Registration Number: ${idNumber}</p>
                        <p>Department: ${department}</p>
                    </div>
                </div>
            `;

            // Populate the back side
            cardBack.style.backgroundImage = `url('/CardGenerator/controllers/${backTemplate}')`;
            cardBack.innerHTML = `
                <div class="org-info">
                    <img src="/CardGenerator/assets/img/organization_logos/${orgLogo}" alt="${orgName} Logo" class="org-logo">
                    <h4>${orgName}</h4>
                    <p>Address: ${orgAddress}</p>
                    <p>Phone: ${orgPhone}</p>
                </div>
                <div class="barcode">
                    <img src="/CardGenerator/controllers/barcode_generator.php?code=${idNumber}" alt="Barcode">
                </div>
            `;

            // Show the card display and the "Request Card" button
            document.getElementById('cardDisplay').style.display = 'block';
            document.getElementById('requestCardBtn').style.display = 'block';
        });


        document.getElementById('requestCardBtn').addEventListener('click', function () {
                const template = document.getElementById('template').value;
                const idNumber = document.getElementById('idNumber').value;
                const department = document.getElementById('department').value;

                const selectedOption = document.getElementById('template').selectedOptions[0];
                const orgName = selectedOption.text;
                const orgLogo = selectedOption.getAttribute('data-logo');
                const orgAddress = selectedOption.getAttribute('data-address');
                const orgPhone = selectedOption.getAttribute('data-phone');
                const orgId = selectedOption.getAttribute('data-org-id'); // Ensure you add this attribute

                fetch('/CardGenerator/controllers/CreateCardController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        template: template,
                        idNumber: idNumber,
                        department: department,
                        org_id: orgId, // Include org_id in the POST data
                        orgName: orgName,
                        orgLogo: orgLogo,
                        orgAddress: orgAddress,
                        orgPhone: orgPhone
                    })
                })
                .then(response => response.text())
                .then(data => {
                    const requestButton = document.getElementById('requestCardBtn');
                    const message = document.createElement('p');
                    requestButton.style.display = 'none';

                    if (data.includes("Card request submitted successfully.")) {
                        message.textContent = "Your ID card request has been submitted. You can download your ID card once the organization accepts the request.";
                    } else if (data.includes("You have already requested an ID card from this organization.")) {
                        message.textContent = "You have already requested an ID card from this organization. Please wait for approval.";
                    } else {
                        requestButton.style.display = 'block'; // Re-show the button in case of an error
                    }

                    requestButton.parentNode.appendChild(message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while submitting your request.');
                });
            });

	    const flipCard = document.querySelector('.flip-card-inner');
        document.querySelector('.flip-card').addEventListener('click', function() {
            flipCard.style.transform = flipCard.style.transform === 'rotateY(180deg)' ? '' : 'rotateY(180deg)';
        });
    </script>
    
</body>
</html>
