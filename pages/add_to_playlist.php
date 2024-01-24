<?php
include 'database.php';

if (isset($_POST['add_to_playlist_song'])) {
    $songId = $_POST['add_to_playlist_song'];
    $userIp = $_SERVER['REMOTE_ADDR'];

    // Check if the song is already in the playlist
    $checkPlaylistQuery = "SELECT * FROM playlist WHERE user_ip = '$userIp' or user_id='$user_id' AND song_id = $songId";
    $checkPlaylistResult = $conn->query($checkPlaylistQuery);

    if ($checkPlaylistResult->num_rows === 0) {
        // The song is not in the playlist

        // Insert into the playlist table
        $insertPlaylistQuery = "INSERT INTO playlist (user_ip, song_id,user_id) VALUES ('$userIp', '$songId','$user_id')";
        $conn->query($insertPlaylistQuery);

        // Return a success response (or any other response you want)
        $response = array('status' => 'success', 'message' => 'Added to Playlist');
        echo json_encode($response);
    } else {
        // The song is already in the playlist
        $response = array('status' => 'error', 'message' => 'Song is already in the playlist.');
        echo json_encode($response);
    }
} else {
    // Invalid request
    $response = array('status' => 'error', 'message' => 'Invalid request.');
    echo json_encode($response);
}

$conn->close();
?>
