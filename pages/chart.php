<?php
if (isset($_GET['top']) || isset($_GET['bottom'])) {
    $top = $_GET['top'] ?? '';
    $bottom = $_GET['bottom'] ?? '';
?>
    <br>
    <hr>
    <center style="margin:10px; width:90%;"><h4>Top <?php echo "$top";?> Chart</h4></center>
    <hr>

    <?php
    if ($top) {
        $limit = $top;
        $sql = "SELECT * FROM sounds ORDER BY downloads DESC LIMIT $limit";
    } elseif ($bottom) {
        $limit = $bottom;
        $sql = "SELECT * FROM sounds ORDER BY downloads ASC LIMIT $limit";
    } else {
        $limit = 50;
        $sql = "SELECT * FROM sounds ORDER BY downloads DESC LIMIT $limit";
    }
} else {
    $limit = 50;
    $sql = "SELECT * FROM sounds ORDER BY downloads DESC LIMIT $limit";
}
?>

<ol class="music-list">
<?php

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cutTitle = cutLongWords($row['title'], 5);
        echo '<li class="music-item">
                <span class="rank">' . $i++ . '</span>
                <div class="image-container">
                <img src="' . $row['cover_image'] . '" alt="Album Cover">
                <div class="progress-controls">
    <div class="controls">
        <i id="i" class="play-pause">⏸</i>
    </div>
</div></div>
                <div class="music-details">
                  <a href="?p=song&id='.$row['id'].'&title='.$row['title'].'">  <h3>' . $cutTitle . '</h3></a>
                  <a href="?p=artist&id='.$row['poster_id'].'&name='.$row['studio_name'].'">  <p>' . $row['artist'] . '</p></a>
                    
                </div>
                <p class="actions">
    <form action="pages/download.php" method="get">
        <button name="download_song" type="submit" id="button" value="'.$row['id'].'" class="download-btn">📥'.$row['downloads'].'</button>
    </form>
    <button class="like-btn" id="button" data-songid="'.$row['id'].'">❤'.$row['likes'].'</button>
</p>
<audio id="audioPlayer" controls style="display: none;">
    <source src="'.$row['audio_source'].'" type="audio/mp3">
    Your browser does not support the audio element.
</audio>

              </li>';
    }
} else {
    echo 'No songs available';
}

?>

    <!-- Add more music items as needed -->

</ol>
