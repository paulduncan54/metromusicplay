<?php
if(isset($_GET['download_song'])){
    include 'database.php';
    $songid=$_GET['download_song'];

    // Check if the user has downloaded this file in the last 24 hours
    $downloadKey = 'downloaded_' . $songid;

    if (!isset($_COOKIE[$downloadKey]) || $_COOKIE[$downloadKey] + 24 * 3600 < time()) {
        // The user is allowed to download the file

        // Replace "your_table_name" with the actual name of your database table containing audio file information
        $sql = "SELECT * FROM sounds WHERE id = $songid";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // File path on the server (replace with your actual file path)
            $filePath = $row['audio_source'];

            // Set headers for file download
            ob_end_clean();
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
            header("Content-Length: " . filesize($filePath));

            // Read the file and output it to the browser
            readfile($filePath);

            // Get the user's IP address
            $userIp = $_SERVER['REMOTE_ADDR'];

            // Check if the user has already downloaded this song
            $selectSql = "SELECT * FROM downloaders WHERE ip_address = '$userIp' AND song_id = $songid";
            $result = $conn->query($selectSql);

            if ($result->num_rows > 0) {
                setcookie($downloadKey, time(), time() + 24 * 3600, '/');
            } else {
                // Insert the user's IP address and song ID into the downloaders table
                $insertSql = "INSERT INTO downloaders (ip_address, song_id) VALUES ('$userIp', $songid)";
                $conn->query($insertSql);

                // Update the download count in the sounds table
                $updateSql = "UPDATE sounds SET downloads = downloads + 1 WHERE id = $songid";
                $conn->query($updateSql);

                // Set the cookie to mark that the user has downloaded this file
                setcookie($downloadKey, time(), time() + 24 * 3600, '/');
            }

            exit;
        } else {
            // File not found in the database, redirect to 404 page
            header('HTTP/1.0 404 Not Found');
            include('404.php');
            exit;
        }
    } else {
        // The user has already downloaded this file within the last 24 hours
        echo "You have already downloaded this file within the last 24 hours.";
    }
}
?>
