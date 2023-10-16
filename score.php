

User
<!DOCTYPE html>
<html>
<head>
    <title>School Scores</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #61100f;
            color: #fff;
            padding: 5px;
            text-align: center;
        }

        .container {
            margin: 20px;
        }

        /* Style for navigation links */
        .nav-link {
            display: inline-block;
            margin-right: 15px;
            padding: 8px 15px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .nav-link:hover {
            background-color: #004488;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 3px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #61100f;
            color: white;
        }

        .winner-container {
            margin-top: 4px;
            padding: 4px;
            border: 1px solid #ddd;
            font-weight: bold;
            font-size: 18px;
            text-align: center;
        }

        .school-name {
            font-weight: bold;
        }

        .school-score {
            font-weight: bold;
            color: black;
            font-size: 30px;
        }

        .smaller-score {
            font-size: 14px;
            width: 50px;
        }

        /* Adjust styles for form elements to be in the same line */
        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group label {
            margin-right: 10px;
        }
    </style>
</head>
<body>
<header>
    <a class="nav-link" href="/oop/index.html">Home</a>
    <a class="nav-link" href="score.php">Index</a>
    </header>

<div class="container">
    <form method="post" action="">
        <div class="input-group">
            <label for="group_name">Select Group:</label>
            <select name="group_name" id="group_name">
                <option value="A"> ROUND 1 A</option>
                <option value="B"> ROUND 1 B</option>
                <option value="C"> ROUND 1 C</option>
                <option value="D"> ROUND 1 D</option>
                <option value="E"> ROUND 1 E</option>
                <option value="F"> ROUND 1 A</option>
                <option value="G"> ROUND 1 A</option>
                <option value="H">final ROUND </option>
            </select>
            <input type="submit" name="submit" value="Show Schools" id="showSchoolsButton">
        </div>
    </form>
    
    <?php
if(isset($_POST['submit'])) {
    $group_name = $_POST['group_name'];
    
    $csvFile = 'schools.csv';
    $schools = [];
    
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if ($data[0] == $group_name) {
                $schools[] = array('school_name' => $data[1], 'score' => intval($data[2]));
            }
        }
        fclose($handle);
    }
    
    if (!empty($schools)) {
        // Sort the schools array in descending order based on score
        usort($schools, function($a, $b) {
            return $b['score'] - $a['score'];
        });
        
        echo '<h2>Schools and Scores for Group: ' . $group_name . '</h2>';
        echo '<table>';
        echo '<tr><th>List of school</th><th>Score obtained</th></tr>';
        
        foreach ($schools as $school) {
            echo '<tr>';
            echo '<td><div class="school-name">' . $school['school_name'] . '</div></td>';
            echo '<td><div class="school-score smaller-score">' . $school['score'] . '</div></td>';
            echo '</tr>';
        }
        
        echo '</table>';
        
        // Display the top two schools for the next round
        if (count($schools) >= 2) {
            echo '<div class="winner-container">';
            echo '<p>Top two schools for the next round:</p>';
            echo '<div class="school-name">' . $schools[0]['school_name'] . '</div>';
            echo '<div class="school-name">' . $schools[1]['school_name'] . '</div>';
            echo '</div>';
        } else {
            echo '<p>Not enough schools for the next round.</p>';
        }
    } else {
        echo '<p>No schools found for the given group.</p>';
    }
}
?>

</div>

<script>
    document.getElementById("showSchoolsButton").addEventListener("click", function() {
        var audio = document.getElementById("clapSound");
        audio.play();
    });
</script>
</body>
</html>