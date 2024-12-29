<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create ID Card</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/templates.css">
</head>
<body>
    <?php include '../components/header.php'; ?>

    <section class="create-card-section">
        <h2>Create Your ID Card</h2>
        <form id="createCardForm">
            <div class="form-group">
                <label for="template">Select Template:</label>
                <select name="template" id="template" required>
                    <option value="">--Select a Template--</option>
                    <?php
                    // Fetch templates from the database
                    include '../../config/Database.php';
                    $database = new Database();
                    $conn = $database->getConnection();
                    $query = "SELECT front_image, back_image FROM card_templates";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['front_image']) . '">' . htmlspecialchars($row['front_image']) . '</option>';
                        }
                    } else {
                        echo '<option value="">No templates available</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="idNumber">ID Number:</label>
                <input type="text" id="idNumber" name="idNumber" placeholder="Enter your ID number" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" placeholder="Enter your department" required>
            </div>

            <button type="submit" class="submit-btn">Generate Card</button>
        </form>

        <div id="cardDisplay" class="card-display" style="display:none;">
            <h3>Your ID Card</h3>
            <div id="cardPreview"></div>
        </div>
    </section>

    <script>
        document.getElementById('createCardForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const template = document.getElementById('template').value;
            const name = document.getElementById('name').value;
            const idNumber = document.getElementById('idNumber').value;
            const department = document.getElementById('department').value;

            const cardPreview = document.getElementById('cardPreview');
            cardPreview.innerHTML = `
                <div class="card" style="background-image: url('../../controllers/${template}');">
                    <h2>${name}</h2>
                    <p>ID Number: ${idNumber}</p>
                    <p>Department: ${department}</p>
                </div>
            `;
            document.getElementById('cardDisplay').style.display = 'block';
        });
    </script>

    <style>
        .card {
            width: 300px;
            height: 200px;
            background-size: cover;
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</body>
</html>