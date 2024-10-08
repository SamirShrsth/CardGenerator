<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Card Template</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css">
    <link rel="stylesheet" href="/CardGenerator/assets/css/templates.css">
    <style>
        .image-preview {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .image-preview img {
            width: 150px;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include '../components/header.php'; ?>

    <section class="add-template-section">
        <h2>Add New Card Template</h2>
        <p>Select the orientation of the card and upload images for the front and back.</p>

        <form action="../../controllers/UploadTemplateController.php" method="POST" enctype="multipart/form-data" class="template-form">
            <div class="form-group">
                <label for="orientation">Select Orientation:</label>
                <select name="orientation" id="orientation" required>
                    <option value="portrait">Portrait (306x486)</option>
                    <option value="landscape">Landscape (486x306)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="front_image">Upload Front Image:</label>
                <input type="file" id="front_image" name="front_image" accept="image/*" required onchange="previewImage(event, 'frontPreview')">
                <div class="image-preview">
                    <img id="frontPreview" src="" alt="Front Image Preview" style="display: none;">
                </div>
            </div>

            <div class="form-group">
                <label for="back_image">Upload Back Image:</label>
                <input type="file" id="back_image" name="back_image" accept="image/*" required onchange="previewImage(event, 'backPreview')">
                <div class="image-preview">
                    <img id="backPreview" src="" alt="Back Image Preview" style="display: none;">
                </div>
            </div>

            <button type="submit" class="submit-btn">Add Template</button>
        </form>
    </section>

    <script>
        function previewImage(event, previewId) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
