<?php
include 'database.php';
$sql = "SELECT * FROM sounds";
$result = $conn->query($sql);

$songs = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $songs[] = array(
            "title" => $row["title"],
            "artist" => $row["artist"],
            "coverImage" => $row["cover_image"],
            "audioSource" => $row["audio_source"],
            "studioImage" => $row["studio_image"],
            "studioName" => $row["studio_name"],
            "followers" => $row["followers"],
            "genre" => $row["genre"],
            "id" => $row["id"],
            "description" => $row["description"]
        );
    }
}

$conn->close();

echo json_encode($songs);
?>
