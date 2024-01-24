<?php
session_start();
include 'pages/database.php';
$userIp = $_SERVER['REMOTE_ADDR'];
function cutLongWords($inputString, $maxWordLength = 10) {
  $words = explode(' ', $inputString);

  foreach ($words as &$word) {
      // Check if the word length exceeds the maximum length
      if (mb_strlen($word) > $maxWordLength) {
          // Truncate the word
          $word = mb_substr($word, 0, $maxWordLength) . '...';
      }
  }

  // Join the words back into a string
  $outputString = implode(' ', $words);

  return $outputString;
}
$i=1;

?>
<!DOCTYPE html>
<!-- Designined by Done Deal Music | www.youtube.com/Done Deal Musicyt -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Premium Music Download and listen with Done Deal Online Business</title>
    <link rel="stylesheet" href="style.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php
     include 'pages/style.html';
     ?>
   </head>
<body>
  <nav>
    <div class="navbar">
      <i class='bx bx-menu'></i>
      <div class="logo"><a href="./">Done Deal Music</a></div>
      <div class="nav-links">
        <div class="sidebar-logo">
          <span class="logo-name">Done Deal Music</span>
          <i class='bx bx-x' ></i>
        </div>
        <ul class="links">
          <li><a href="#">SIGNIN</a></li>
          <li>
            <a href="#">FEED</a>
            <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
            <ul class="htmlCss-sub-menu sub-menu">
              <li><a href="#">Genres</a></li>
              <li><a href="#">Artists</a></li>
              <li><a href="#">Popular</a></li>
              <li class="more">
                <span><a href="#">Chart</a>
                <i class='bx bxs-chevron-right arrow more-arrow'></i>
              </span>
                <ul class="more-sub-menu sub-menu">
                  <li><a href="?p=chart&top=10">Top 10</a></li>
                  <li><a href="?p=chart&top=100">Top 100</a></li>
                  <li><a href="?p=chart&bottom=100">Bottom 100</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">Library</a>
            <i class='bx bxs-chevron-down js-arrow arrow '></i>
            <ul class="js-sub-menu sub-menu">
              <li><a href="#">Likes</a></li>
              <li><a href="#">Playlists</a></li>
              <li><a href="#">Albums</a></li>
              <li><a href="#">Following</a></li>
            </ul>
          </li>
          <li><a href="#">ABOUT US</a></li>
          <li><a href="#">Upload</a></li>
        </ul>
      </div>
      <div class="search-box">
        <i class='bx bx-search'></i>
        <div class="input-box">
          <input type="text" placeholder="Search...">
        </div>
      </div>
    </div>
  </nav>
<br><br><br>
<div id="content-container">
  <!-- Content will be dynamically loaded here -->
</div>

<?php
// Check if the "page" parameter is set in the URL
if (isset($_GET['p'])) {
    $page = $_GET['p'];
    
// Define the directory path
$pagesDirectory = 'pages';

// Get all files in the directory
$files = scandir($pagesDirectory);

// Filter out non-PHP files
$phpFiles = array_filter($files, function ($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'php';
});

// Extract page names without file extension
$allowedPages = array_map(function ($phpFile) {
    return pathinfo($phpFile, PATHINFO_FILENAME);
}, $phpFiles);

    
    if (in_array($page, $allowedPages)) {
        include 'pages/'.$page . '.php';
    } else {
      include 'pages/404.php';
    }
} else {
  include 'pages/home.php';
}
?>
  
     
     

  <script src="script.js"></script>
<script>
    // Your existing JavaScript code here...

    // Function to navigate back
    function goBack() {
        window.history.back();
    }
</script>


<script>
// script.js
document.addEventListener('DOMContentLoaded', function () {
  const audio = document.getElementById('audioPlayer');
  const titleElement = document.querySelector('.song-display h1');
  const artistElement = document.querySelector('.song-display p');
  const coverImageElement = document.querySelector('.song-display img');
  const studioImageElement = document.querySelector('.info img');
  const studioNameElement = document.querySelector('.details h2');
  const followersElement = document.querySelector('.details p');
  const genreElement = document.querySelector('.details span');
  const descriptionElement = document.querySelector('.description p');

  // Retrieve the last played song index from local storage
  let currentSongIndex = parseInt(localStorage.getItem('currentSongIndex')) || 0;

  function loadSong(index) {
    const song = songs[index];
    audio.src = song.audioSource;
    titleElement.textContent = song.title;
    artistElement.textContent = song.artist;
    coverImageElement.src = song.coverImage;
    studioImageElement.src = song.studioImage;
    studioNameElement.textContent = song.studioName;
    followersElement.textContent = song.followers;
    genreElement.textContent = song.genre;
    descriptionElement.textContent = song.description;

    // Reset progress bar and time display
    audio.currentTime = 0;
    progressBar.value = 0;
    currentTimeDisplay.textContent = "0:00";
    totalTimeDisplay.textContent = "0:00";

    // Update the last played song index in local storage
    localStorage.setItem('currentSongIndex', index);
  }
  // Function to update the URL with the current song's ID
  function updateURL() {
    const currentSong = songs[currentSongIndex];
    const newURL = `?p=song&id=${currentSong.id}&title/${encodeURIComponent(currentSong.title)}`;
    history.pushState({ path: newURL }, '', newURL);
  }
  function playPause() {
    if (audio.paused) {
      audio.play();
      playPauseButton.textContent = '⏸';
    } else {
      audio.pause();
      playPauseButton.textContent = '▶';
    }
  }

  function nextSong() {
    currentSongIndex = (currentSongIndex + 1) % songs.length;
    loadSong(currentSongIndex);
    playPause();
    updateURL();
  }

  function previousSong() {
    currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
    loadSong(currentSongIndex);
    playPause();
    updateURL();
  }

  const playPauseButton = document.querySelector('.play-pause');
  const progressBar = document.querySelector('.progress-bar');
  const currentTimeDisplay = document.querySelector('.current-time');
  const totalTimeDisplay = document.querySelector('.total-time');
  const nextButton = document.querySelector('.controls .nextButton');
  const previousButton = document.querySelector('.controls .previousButton');

  playPauseButton.addEventListener('click', playPause);
  nextButton.addEventListener('click', nextSong);
  previousButton.addEventListener('click', previousSong);

  audio.addEventListener('timeupdate', () => {
    const progressPercentage = (audio.currentTime / audio.duration) * 100;
    progressBar.value = progressPercentage;

    const currentTimeMinutes = Math.floor(audio.currentTime / 60);
    const currentTimeSeconds = Math.floor(audio.currentTime % 60);
    currentTimeDisplay.textContent = `${currentTimeMinutes}:${currentTimeSeconds}`;

    const totalTimeMinutes = Math.floor(audio.duration / 60);
    const totalTimeSeconds = Math.floor(audio.duration % 60);
    totalTimeDisplay.textContent = `${totalTimeMinutes}:${totalTimeSeconds}`;
  });

  audio.addEventListener('ended', () => {
    // Play the next song when the current song has ended
    nextSong();
  });

  progressBar.addEventListener('input', () => {
    const seekTime = (progressBar.value / 100) * audio.duration;
    audio.currentTime = seekTime;
  });

  // Fetch songs from PHP script
  fetch('pages/fetch_songs.php')
    .then(response => response.json())
    .then(data => {
      songs = data;
      loadSong(currentSongIndex);
    })
    .catch(error => console.error('Error fetching songs:', error));
});



</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Get the buttons by class
    const copyUrlBtn = document.querySelector('.copy-url-btn');


    copyUrlBtn.addEventListener('click', function () {
        // Your copy URL functionality here
        const urlToCopy = window.location.href;
        copyTextToClipboard(urlToCopy);
        alert('URL copied to clipboard!');
    });

    // Function to copy text to clipboard
    function copyTextToClipboard(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
    }


});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const shareBtn = document.querySelector('.share-btn');

    shareBtn.addEventListener('click', function () {
        if (navigator.share) {
            // Use the Web Share API if available
            navigator.share({
                title: document.title,
                text: 'Check out this!',
                url: window.location.href
            })
            .then(() => console.log('Shared successfully'))
            .catch((error) => console.error('Error sharing:', error));
        } else {
            // Fallback for browsers that do not support the Web Share API
            alert('Web Share API not supported on this browser. You can manually copy the URL.');
        }
    });
});
</script>
</body>
</html>
