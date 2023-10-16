<!DOCTYPE html>
<html>
<head>
    <title>File Display</title>
</head>
<body>
    <h2>File Display</h2>
    <form method="post" action="display.php">
        <label for="questionNumber">Enter Question Number:</label>
        <input type="number" name="questionNumber" required><br>
        
        <label for="fileType">Choose File Type:</label>
        <select name="fileType" required>
            <option value="image">Image</option>
            <option value="audio">Audio</option>
        </select><br>
        
        <input type="submit" name="submit" value="Display File">
    </form>
</body>
</html>
