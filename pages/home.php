
<br><br>
<div class="container">
  <h2 class="mt-4 mb-4">Metro Martin Music Play</h2>

  <div class="row">
  <div class="music-container">
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

$sql = "SELECT * FROM sounds order by rand() limit 6";
$result = $conn->query($sql);

$songs = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $cutTitle = cutLongWords($row['title'], 5);
        echo'
    <div class="music-card">
      <!-- Your music card content goes here -->
     <a href="?p=song&id='.$row['id'].'&title='.$row['title'].'"> <img src="'.$row['cover_image'].'" alt=""></a>
      <h4>'.$row['artist'].'</h4>
      <p>'.$cutTitle.'</p>
    </div>';
    }}else{
        echo'no song available';
    }
    ?>
</div>
<br>
<hr>
    <center style="margin:10px; width:90%;"><h4>Top Chart</h4></center>
    <hr>
<ol class="music-list">
<?php

$sql = "SELECT * FROM sounds ORDER BY downloads desc limit 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cutTitle = cutLongWords($row['title'], 5);
        echo '<li class="music-item">
                <span class="rank">' . $i++ . '</span>
                <img src="' . $row['cover_image'] . '" alt="Album Cover">
                <div class="music-details">
                    <h3>' . $cutTitle . '</h3>
                    <p>' . $row['artist'] . '</p>
                </div>
              </li>';
    }
} else {
    echo 'No songs available';
}

?>

    <!-- Add more music items as needed -->

</ol>


