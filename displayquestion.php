<!DOCTYPE html>
<html>
<head>
  <title>Question Display</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Your additional CSS styling here */
    @font-face {
      font-family: 'Preeti Normal', sans-serif;
      src: url('font/Preeti Normal.ttf') format('truetype'); /* Font file is in the "font" folder */
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1px;
      background-color: #61100f;
      color: white;
    }

    .home-button {
      background-color: #1167b1;
      color: white;
      padding: 8px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .question {
      font-size: 40px; /* Adjust font size as needed */
      font-weight: bold;
      margin-bottom: 10px;
    }

    .question-topic-number {
      font-size: 18px; /* Adjust font size as needed */
      font-weight: bold;
      margin-bottom: 10px;
    }

    .home-button:hover {
      background-color: #1167b1;
    }

    .question-container {
      margin-top: 20px;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      border-radius: 5px;
      text-align: center;
    }

    .stopwatch-container {
      margin-top: 10px;
      padding: 10px;
      background-color: #f0f0f0;
      border: 1px solid #ccc;
      border-radius: 5px;
      text-align: center;
    }

    .stopwatch-buttons button {
      background-color: #61100f;
      color: white;
      padding: 8px 20px;
      border: none;
      border-radius: 5px;
      margin: 0 5px;
      cursor: pointer;
    }

    .stopwatch-buttons button:hover {
      background-color: #1167b1;
    }
  </style>
</head>
<body>
  <div class="top-bar">
    <button class="home-button" onclick="goHome()">Home</button>
    <h1>Question Display</h1>
    <div></div>
  </div>
  
  <div class="question-topic-number">
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $questionNumber = $_POST["questionNumber"];
      $questionTopic = $_POST["questionTopic"];
      echo "(NUMBER : $questionNumber) TOPIC: $questionTopic";
    }
    ?>
  </div>

  <div class="question-container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $questionNumber = $_POST["questionNumber"];
      $questionTopic = $_POST["questionTopic"];
      $group = $_POST["group"];
      $foundQuestion = false; // To check if a matching question has been found
      $file = fopen("questions.csv", "r");
      $header = fgetcsv($file); // Read and skip the header row

      while (($data = fgetcsv($file)) !== false) {
        $csvQuestionNumber = $data[0];
        $csvQuestionTopic = $data[1];
        $csvGroup = $data[2];
        $question = $data[3];

        if ($questionNumber == $csvQuestionNumber && $questionTopic == $csvQuestionTopic && $group == $csvGroup) {
          $foundQuestion = true;
          echo "<div class='question'>";
          echo "<p>$question</p>";
          echo "</div>"; // End of question div
          break;
        }
      }

      fclose($file);

      if (!$foundQuestion) {
        echo "<p>No matching question found for the specified input.</p>";
      }
    } else {
      echo "<p>No question number, topic, and group provided.</p>";
    }
    ?>
  </div>

  <div class="stopwatch-container">
    <h2>Stopwatch</h2>
    <div class="stopwatch">
      <span id="display">00:00:00</span>
    </div>
    <div class="stopwatch-buttons">
      <button id="startStop" onclick="startStop()">Start</button>
      <button onclick="reset()">Reset</button>
    </div>
  </div>

  <!--<div class="stopwatch-buttons">
    <button id="startStop" onclick="startStop()">Start</button>
    <button onclick="reset()">Reset</button>
  </div>-->

  <audio id="beepAudio">
    <source src="beep.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
  </audio>

  <script>
    var timer;
    var isRunning = false;
    var time = 0;

    // Automatically start the stopwatch
    startStop();

    function startStop() {
      if (isRunning) {
        clearInterval(timer);
        isRunning = false;
      } else {
        timer = setInterval(updateStopwatch, 1000);
        isRunning = true;
      }
    }

    function updateStopwatch() {
      time++;
      var hours = Math.floor(time / 3600);
      var minutes = Math.floor((time % 3600) / 60);
      var seconds = time % 60;
      document.getElementById("display").textContent = formatTime(hours) + ":" + formatTime(minutes) + ":" + formatTime(seconds);
    }

    function reset() {
      clearInterval(timer);
      time = 0;
      isRunning = false;
      document.getElementById("display").textContent = "00:00:00";

      // Play the audio when reset is clicked
      var beepAudio = document.getElementById("beepAudio");
      beepAudio.play();
    }

    function formatTime(value) {
      return value < 10 ? "0" + value : value;
    }

    function goHome() {
      window.location.href = "index.html"; // Replace with the actual home page URL
    }
  </script>
</body>
</html>