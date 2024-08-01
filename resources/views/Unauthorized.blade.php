<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Page Image</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        .full-page-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures the image covers the entire area without distortion */
        }
    </style>
</head>
<body>
    <img src="https://cdn.dribbble.com/users/761395/screenshots/6287961/error_401.jpg?resize=400x0" alt="Full Page Image" class="full-page-image">
</body>
</html>
