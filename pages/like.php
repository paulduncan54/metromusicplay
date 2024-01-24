<?php
// like.php
include 'database.php';

if (isset($_POST['like_song'])) {
    $songId = $_POST['like_song'];
    $userIp = $_SERVER['REMOTE_ADDR'];

    // Check if the user has already liked this song
    $checkLikeQuery = "SELECT * FROM likes WHERE user_id = '$user_id' AND song_id = $songId";
    $checkLikeResult = $conn->query($checkLikeQuery);

    if ($checkLikeResult->num_rows === 0) {
        // The user hasn't liked this song yet

        // Insert like into the database
        $insertLikeQuery = "INSERT INTO likes (user_ip, song_id,user_id) VALUES ('$userIp', '$songId','$user_id')";
        $conn->query($insertLikeQuery);

        // Update the likes count in the main table (adjust the table and column names as needed)
        $updateLikesQuery = "UPDATE sounds SET likes = likes + 1 WHERE id = $songId";
        $conn->query($updateLikesQuery);

        // Return the updated likes count (or any other response you want)
        $getLikesQuery = "SELECT likes FROM sounds WHERE id = $songId";
        $result = $conn->query($getLikesQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response = array('status' => 'success', 'likes' => $row['likes']);
        } else {
            $response = array('status' => 'error', 'message' => 'Error retrieving likes count.');
        }

        echo json_encode($response);
    } else {
        // The user has already liked this song
        $response = array('status' => 'error', 'message' => 'You have already liked this song.');
        echo json_encode($response);
    }
} else {
    // Invalid request
    $response = array('status' => 'error', 'message' => 'Invalid request.');
    echo json_encode($response);
}

$conn->close();
?>
