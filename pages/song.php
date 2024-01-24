
<?php
// FetchData.php

// Get the ID from the URL
$songid = isset($_GET['id']) ? $_GET['id'] : null;

// Validate the ID (you may need to adjust the validation logic based on your requirements)
if (!is_numeric($songid) || $songid <= 0) {
    // Invalid or missing ID, redirect to 404 page
    header('HTTP/1.0 404 Not Found');
    include('404.php');
    exit;
}

?>
<style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }
    
        body {
          font-family: Arial, sans-serif;
          background-color: #f0f0f0;
        }
    
        .container {
          max-width: 800px;
          margin: 0 auto;
          padding: 20px;
        }
    
        .song-display {
          display: flex;
          flex-direction: column;
          align-items: center;
          background-color: #fff;
          border-radius: 10px;
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
          padding: 20px;
        }
    
        .song-display h1 {
          font-size: 24px;
          font-weight: bold;
          margin-bottom: 10px;
        }
    
        .song-display p {
          font-size: 18px;
          color: #666;
          margin-bottom: 20px;
        }
    
        .song-display img {
          width: 300px;
          height: 300px;
          object-fit: cover;
          border-radius: 10px;
          margin-bottom: 20px;
        }
    
        .song-display .options {
          display: flex;
          justify-content: space-between;
          width: 100%;
          margin-bottom: 20px;
        }
    
        .song-display .options button {
          width: 40px;
          height: 40px;
          border: none;
          border-radius: 50%;
          background-color: #eee;
          cursor: pointer;
        }
    
        .song-display .options button:hover {
          background-color: #ddd;
        }
    
        .song-display .progress {
          display: flex;
          align-items: center;
          width: 100%;
          margin-bottom: 20px;
        }
    
        .song-display .progress span {
          font-size: 16px;
          color: #666;
        }
    
        .song-display .progress input {
          flex: 1;
          margin: 0 10px;
          -webkit-appearance: none;
          height: 5px;
          border-radius: 5px;
          background-color: #ddd;
          outline: none;
        }
    
        .song-display .progress input::-webkit-slider-thumb {
          -webkit-appearance: none;
          width: 15px;
          height: 15px;
          border-radius: 50%;
          background-color: #666;
        }
    
        .song-display .controls {
          display: flex;
          justify-content: center;
          align-items: center;
          width: 100%;
        }
    
        .song-display .controls button {
          width: 60px;
          height: 60px;
          border: none;
          border-radius: 50%;
          background-color: #eee;
          margin: 0 10px;
          cursor: pointer;
        }
    
        .song-display .controls button:hover {
          background-color: #ddd;
        }
    
        .song-display .controls button.play {
          width: 80px;
          height: 80px;
          background-color: #666;
          color: #fff;
        }
    
        .song-display .controls button.play:hover {
          background-color: #555;
        }
    
        .song-display .info {
          display: flex;
          align-items: center;
          width: 100%;
          margin-top: 20px;
        }
    
        .song-display .info img {
          width: 60px;
          height: 60px;
          object-fit: cover;
          border-radius: 10px;
          margin-right: 10px;
        }
    
        .song-display .info .details {
          flex: 1;
        }
    
        .song-display .info .details h2 {
          font-size: 18px;
          font-weight: bold;
          margin-bottom: 5px;
        }
    
        .song-display .info .details p {
          font-size: 16px;
          color: #666;
        }
    
        .song-display .info .details span {
          font-size: 14px;
          color: #999;
        }
    
        .song-display .info button {
          width: 100px;
          height: 40px;
          border: none;
          border-radius: 20px;
          background-color: #666;
          color: #fff;
          font-size: 16px;
          font-weight: bold;
          cursor: pointer;
        }
    
        .song-display .info button:hover {
          background-color: #555;
        }
    
        @media (max-width: 600px) {
          .song-display img {
            width: 200px;
            height: 200px;
          }
    
          .song-display .options button {
            width: 30px;
            height: 30px;
          }
    
          .song-display .controls button {
            width: 40px;
            height: 40px;
          }
    
          .song-display .controls button.play {
            width: 60px;
            height: 60px;
          }
    
          .song-display .info img {
            width: 40px;
            height: 40px;
          }
    
          .song-display .info button {
            width: 80px;
            height: 30px;
            font-size: 14px;
          }
        }
      </style>
        <?php
$songid=$_GET['id'];
$sql = "SELECT * FROM sounds where id='$songid'";
$result = $conn->query($sql);

$songs = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo'
      <div class="container">
        <div class="song-display">
          <h1>'.$row['title'].'</h1>
          <p>'.$row['artist'].'</p>
          <img src="'.$row['cover_image'].'" alt="Cover image">
          <div class="options">
          <button class="like-btn" data-songid="'.$songid.'">❤'.$row['likes'].'</button>
          <button class="add-to-playlist-btn" data-songid="'.$songid.'">✚</button>
          <button class="copy-url-btn">🔗</button>
          <button class="share-btn">Share URL</button>
          <form action="pages/download.php" method="get">
          <button name="download_song" type="submit" value="'.$songid.'" class="download-btn">📥'.$row['downloads'].'</button>
          </form>
          </div>
          <div class="progress">
            <span class="current-time">0:00</span>
            <input type="range" value="0" min="0" max="100" class="progress-bar">
            <span class="total-time">0:00</span>
          </div>
          <div class="controls">
            <button class="previousButton">⏪</button>
            <button class="play-pause">⏸</button>
            <button class="nextButton">⏩</button>
          </div>
          <div class="info">
            <img src="'.$row['studio_image'].'" alt="Studio image">
            <div class="details">
              <h2>'.$row['studio_name'].'</h2>
              <p>'.$row['followers'].' Followers</p>
              
              <span>'.$row['genre'].'</span>
            </div>
            <button>FOLLOW</button>
          </div>
          <div class="description">
              <p>'.$row['description'].' Followers</p>
            </div>
        </div>
      </div>
      
      <audio id="audioPlayer" controls style="display: none;">
        <source src="'.$row['audio_source'].'" type="audio/mp3">
        Your browser does not support the audio element.
      </audio>';
    }}else{
        echo'no song available';
    }
    ?>
      <div class="music-container">
        <h5>More Music</h5>
  <?php

$sql = "SELECT * FROM sounds order by rand()";
$result = $conn->query($sql);

$songs = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $cutTitle = cutLongWords($row['title'], 5);
        echo'
        <div class="music-cardscroll">
        <a href="?p=song&id='.$row['id'].'&title='.$row['title'].'">  <img src="'.$row['cover_image'].'" alt="Album Cover"></a>
            <div class="music-details">
                <h3>'.$cutTitle.'</h3>
                <p>'.$row['artist'].'</p>
            </div>
        </div>';
    }}else{
        echo'no song available';
    }
    ?>

    <!-- Add more music cards as needed -->

</div>
   <?php
if(isset($_POST['download_song'])){
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

    exit;
} else {
    // File not found in the database, redirect to 404 page
    header('HTTP/1.0 404 Not Found');
    include('404.php');
    exit;
}
}
?>
<script>
// your-script.js

$(document).ready(function () {
  
    $('.like-btn').click(function () {
        var songId = $(this).data('songid');

        $.ajax({
            type: 'POST',
            url: 'pages/like.php',
            data: { like_song: songId },
            dataType: 'json', // Expect JSON response
            success: function (response) {
                // Handle the success response
                console.log('AJAX request successful:', response);

                // Update the UI with the new likes count or display a message
                alert(response.message); // Display the message from the response
            },
            error: function (xhr, status, error) {
                // Handle the error response
                console.error('AJAX request failed:', status, error);

                alert('Error liking the song.');
            }
        });
    });
    
});

</script>
<script>
  $(document).ready(function () {
    $('.add-to-playlist-btn').click(function () {
        var songId = $(this).data('songid');

        $.ajax({
            type: 'POST',
            url: 'pages/add_to_playlist.php', // Replace with your actual PHP file
            data: { add_to_playlist_song: songId },
            dataType: 'json',
            success: function (response) {
                console.log('AJAX request successful:', response);
                alert(response.message);
            },
            error: function (xhr, status, error) {
                console.error('AJAX request failed:', status, error);
                alert('Error adding to playlist.');
            }
        });
    });
});

</script>