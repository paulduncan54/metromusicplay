<?php

include 'database.php';

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get form data
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];

    // Validate files
    $coverImage = $_FILES['coverImage'];
    $audioFile = $_FILES['audioFile'];

    // Check for upload errors
    if ($coverImage['error'] != 0) {
        die("Error uploading cover image file");
    }

    if ($audioFile['error'] != 0) {
        die("Error uploading audio file");
    }

    $uploadsDate = date('y-m-d');
    // Create the folder structure
    $folder = "uploads/" . $uploadsDate . "/" . $artist . "/" . $title . "";
    
    // Check if the base directory exists
    if (!is_dir("uploads/")) {
        // Attempt to create the base directory
        if (!mkdir("uploads/")) {
            die("Error creating base folder 'uploads/'");
        }
    }
    
    // Check if the parent directory (based on date) exists
    if (!is_dir("uploads/" . $uploadsDate . "/")) {
        // Attempt to create the parent directory
        if (!mkdir("uploads/" . $uploadsDate . "/", 0777, true)) {
            die("Error creating parent folder 'uploads/" . $uploadsDate . "/'");
        }
    }
    
    // Check if the artist directory exists
    if (!is_dir("uploads/" . $uploadsDate . "/" . $artist . "/")) {
        // Attempt to create the artist directory
        if (!mkdir("uploads/" . $uploadsDate . "/" . $artist . "/", 0777, true)) {
            die("Error creating artist folder 'uploads/" . $uploadsDate . "/" . $artist . "/'");
        }
    }
    
    // Check if the title directory exists
    if (!is_dir("uploads/" . $uploadsDate . "/" . $artist . "/" . $title . "/")) {
        // Attempt to create the title directory
        if (!mkdir("uploads/" . $uploadsDate . "/" . $artist . "/" . $title . "/", 0777, true)) {
            die("Error creating title folder 'uploads/" . $uploadsDate . "/" . $artist . "/" . $title . "/'");
        }
    } 

    // Check cover image dimensions
    list($width, $height) = getimagesize($coverImage['tmp_name']);
    $expectedSize = $width;
    $expectedSizehei = $height; // Adjust as needed
    if ($width != $expectedSize || $height != $expectedSize) {
        die("Error: Cover image must be square with dimensions to maintain its width to height to be $expectedSize x $expectedSize pixels or maintain its height to width to be $expectedSizehei x $expectedSizehei pixels");
    }

    // Check cover image format
    $allowedImageFormats = ['jpeg', 'jpg', 'png']; // Add more formats as needed
    $imageFormat = strtolower(pathinfo($coverImage['name'], PATHINFO_EXTENSION));
    if (!in_array($imageFormat, $allowedImageFormats)) {
        die("Error: Unsupported cover image format. Allowed formats: " . implode(', ', $allowedImageFormats));
    }

    // Check audio file format
    $allowedAudioFormats = ['mp3', 'wav']; // Add more formats as needed
    $audioFormat = strtolower(pathinfo($audioFile['name'], PATHINFO_EXTENSION));
    if (!in_array($audioFormat, $allowedAudioFormats)) {
        die("Error: Unsupported audio format. Allowed formats: " . implode(', ', $allowedAudioFormats));
    }

    $coverImagePath = $folder . "/" . $title . "." . $imageFormat;
    $coverImagePath2 = "pages/".$folder . "/" . $title . "." . $imageFormat;

    if (!move_uploaded_file($coverImage['tmp_name'], $coverImagePath)) {
        die("Error moving cover image file");
    }

    $audioFilePath = $folder . "/" . $title . "." . $audioFormat;
    $audioFilePath2 = "pages/".$folder . "/" . $title . "." . $audioFormat;

    if (!move_uploaded_file($audioFile['tmp_name'], $audioFilePath)) {
        die("Error moving audio file");
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO sounds (title, artist, genre, cover_image, audio_source,description) VALUES (?,?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $title, $artist, $genre, $coverImagePath2, $audioFilePath2,$description);

    if (!$stmt->execute()) {
        die("Database insertion error: " . $stmt->error);
    }

    // Redirect on success
    echo "file uploaded";
}
?>
