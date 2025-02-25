<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Created ID Cards</title>
    <link rel="stylesheet" href="/CardGenerator/assets/css/style.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        h1 {
            margin-top: 20px;
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        img {
            width: 100px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }
            img {
                width: 80px;
            }
        }
    </style>
</head>
<body>
<?php include '../components/header.php'; ?>
    <h1>Student Cards</h1>
    <table>
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Roll Number</th>
                <th>Faculty</th>
                <th>ID Card Image</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Samir Shrestha</td>
                <td>24</td>
                <td>BCA</td>
                <td><img src="/CardGenerator/assets/img/placeholder-cards/samir.png" alt="John's ID Card"></td>
            </tr>
            <tr>
                <td>Ram Kumar</td>
                <td>20</td>
                <td>BCA</td>
                <td><img src="/CardGenerator/assets/img/placeholder-cards/ram.png" alt="Jane's ID Card"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
