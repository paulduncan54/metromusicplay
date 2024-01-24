<?php

// Get the page ID from the AJAX request
$pageId = isset($_POST['pageId']) ? $_POST['pageId'] : null;

// Update the download count in the database
if ($pageId !== null) {
    $sql = "UPDATE pages SET download_count = download_count + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pageId);
    $stmt->execute();
    $stmt->close();
}

// Close the database connection
$conn->close();

// Return a response if needed
echo json_encode(['success' => true]);
?>
