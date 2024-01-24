    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>

<form action="" method="post">
<?php
include 'database.php';
// Function to check if a genre and country combination is already available
function isGenreAvailable($conn, $genre, $country) {
    $sql = "SELECT * FROM genres WHERE genre = '$genre' AND country_of_origin = '$country'";
    $result = $conn->query($sql);

    return $result->num_rows === 0;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $genre = $_POST["genre"];
    $country = $_POST["country"];

    // Check if the genre and country combination is not already available
    if (isGenreAvailable($conn, $genre, $country)) {
        // Insert the new genre and country into the genres table
        $insertSql = "INSERT INTO genres (genre, country_of_origin) VALUES ('$genre', '$country')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Genre inserted successfully.";
        } else {
            echo "Error inserting genre: " . $conn->error;
        }
    } else {
        echo "Genre and country combination already exists.";
    }
}

// Close connection
$conn->close();
?>

    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" required>

    <label for="country">Country of Origin:</label>
    <input type="text" id="country" name="country" required>

    <input type="submit" value="Submit">
</form>
