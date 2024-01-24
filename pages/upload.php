<div class="container">
    <form id="musicUploadFor" action="pages/upload_process.php" method="post" enctype="multipart/form-data">
      <h1>International Music Upload</h1>

      <label for="title">Title:</label>
      <input type="text" id="title" name="title" required>

      <label for="artist">Artist:</label>
      <input type="text" id="artist" name="artist" required>

      <label for="genre">Genre:</label>
      <select name="genre" id="genre" required>
        <option value="">select sound genre</option>
        <?php
        // Retrieve all genres with their country of origin
$sql = "SELECT * FROM genres";
$result = $conn->query($sql);
// Display the results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo'<option value="'.$row['genre'].'">'.$row['genre'].'</option>';
    }
} else {
    echo "No genres found.";
}
?>      
      </select>
      <label for="coverImage">Cover Image:</label>
      <input type="file" id="coverImage" name="coverImage" accept="image/*" required>

      <label for="audioFile">Audio File:</label>
      <input type="file" id="audioFile" name="audioFile" accept="audio/*" required>
      <label for="Description">Song Description:</label>
      <textarea name="description" id="description" cols="10" rows="5"></textarea>

      <button type="submit">Upload</button>
    </form>
  </div>
  
  <style>
    body {

  display: flex;
  justify-content: center;
  align-items: center;
margin-top: 100px;
  background-color: #f0f0f0;
}

.container {
  max-width: 700px;
  width: 100%;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form {
  display: flex;
  flex-direction: column;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

label {
  margin-top: 10px;
}

input,select,textarea {
  padding: 10px;
  margin-top: 5px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  background-color: #4caf50;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

  </style>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
  const musicUploadForm = document.getElementById('musicUploadForm');

  musicUploadForm.addEventListener('submit', function (event) {
    event.preventDefault();

    // Add your form submission logic here
    // For example, you can use Fetch API to send the form data to the server
    const formData = new FormData(musicUploadForm);

    fetch('pages/upload_process.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      // Handle the response from the server
      console.log(data);
    })
    .catch(error => {
      console.error('Error uploading music:', error);
    });
  });
});

  </script>