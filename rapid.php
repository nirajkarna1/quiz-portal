<!DOCTYPE html>
<html>
<head>
    <title>Questionnaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .header {
            text-align: center;
            padding: 10px;
        }

        .questions-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .stopwatch-container {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .question-box {
            font-size: 24px;
            font-weight: bold;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
            margin-bottom: 20px;
        }

        button[type="button"] {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #61100f;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .preeti-font {
        font-family: 'Preeti', Arial, sans-serif; /* Preeti font */
    } 
    </style>
</head>
<body>
    <div class="header">
        <h1>Questionnaire</h1>
    </div>

    <div class="questions-container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $setName = $_POST["set_name"];
            $csvFile = "{$setName}.csv"; // Using user input as the CSV filename

            if (file_exists($csvFile)) {
                $questions = array_map('str_getcsv', file($csvFile));
                $questionCount = count($questions);

                if ($questionCount > 0) {
                    $currentQuestionIndex = isset($_POST["current_question"]) ? $_POST["current_question"] : 0;

                    if ($currentQuestionIndex < $questionCount) {
                        $currentQuestionData = $questions[$currentQuestionIndex];

                        if ($currentQuestionData[0] !== "thank you") {
                            $currentQuestion = $currentQuestionData[0];

                            echo "<div class='question-box'>$currentQuestion</div>";

                            echo "<form id='question-form' method='post'>";
                            echo "<input type='hidden' name='set_name' value='$setName'>";
                            echo "<input type='hidden' name='current_question' id='current-question' value='$currentQuestionIndex'>";
                            echo "<button type='button' id='next-button'>Next</button>";
                            echo "</form>";
                        } else {
                            echo "<p>Thank you for completing the questionnaire.</p>";
                            echo "<script>stopStopwatch();</script>"; // Stop the stopwatch
                        }
                    }
                } else {
                    echo "<p>No questions found for the selected set.</p>";
                }
            } else {
                echo "<p>CSV file not found for the selected set.</p>";
            }
        } else {
        ?>
            <form method="post">
                <label for="set_name">Enter Set Name:</label>
                <input type="text" name="set_name" required>
                <button type="submit">Start</button>
            </form>
        <?php
        }
        ?>
    </div>

    <div class="stopwatch-container">
        <p>Stopwatch: <span id="stopwatch" class="stopwatch-time">00:00:00</span></p>
    </div>

    <div class="header">
        <div class="buttons-container">
            <button id="home-button" type="button" onclick="window.location.href='index.html'">Home</button>
            <button id="index-button" type="button" onclick="window.location.href='rapid.php'">Index</button>
        </div>
    </div>
    <audio id="beepAudio">
        <source src="beep.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <script>
    let currentQuestionIndex = <?php echo isset($_POST["current_question"]) ? $_POST["current_question"] : 0; ?>;
    let questions = <?php echo json_encode($questions); ?>;
    let stopwatchInterval;
    let stopwatchStartTime = new Date().getTime();


    function startStopwatch() {
        stopwatchInterval = setInterval(function() {
            const currentTime = new Date().getTime();
            const elapsedTime = currentTime - stopwatchStartTime;

            const hours = Math.floor(elapsedTime / 3600000);
            const minutes = Math.floor((elapsedTime % 3600000) / 60000);
            const seconds = Math.floor((elapsedTime % 60000) / 1000);

            const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById("stopwatch").textContent = formattedTime;
        }, 1000);
    }

    function stopStopwatch() {
        clearInterval(stopwatchInterval);
    }

    function stopStopwatch() {
            clearInterval(stopwatchInterval);
            playBeepSound();
        }

        function playBeepSound() {
            const beepAudio = document.getElementById("beepAudio");
            beepAudio.play();
        }

       
    startStopwatch();

    const nextButton = document.getElementById("next-button");
    nextButton.addEventListener("click", function() {
        currentQuestionIndex++;
        if (currentQuestionIndex < questions.length) {
            document.getElementById("current-question").value = currentQuestionIndex;
            const currentQuestionData = questions[currentQuestionIndex];

            if (currentQuestionData[0] !== "thank you") {
                const currentQuestion = currentQuestionData[0];
                const fontType = currentQuestionData[1]; // Assuming font type is in the second column

                // Set the appropriate font class based on the font type
                const questionBox = document.querySelector(".question-box");
                questionBox.textContent = currentQuestion;
                questionBox.classList.toggle("preeti-font", fontType === "Preeti");
            } else {
                document.querySelector(".questions-container").innerHTML = "<p>Thank you for completing the questionnaire.</p>";
                stopStopwatch();
            }
        } else {
            document.querySelector(".questions-container").innerHTML = "<p>Thank you for completing the questionnaire.</p>";
            stopStopwatch();
        }
    });
</script>
</body>
</html>

