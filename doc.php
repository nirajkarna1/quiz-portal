<!DOCTYPE html>
<html>
<head>
    <title>Image ROUND</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* ... your existing styles ... */

        /* Add styles for the image */
        .image-container {
            margin-top: 20px;
        }

        .image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <a href="index.html"><button id="homeButton" style="background-color: rgb(5, 5, 112); color: white;">Home</button></a>
    <a href="audio.html"><button id="indexButton" style="background-color: rgb(5, 5, 112); color: white;">Index</button></a>
</div>

<div class="container">
    <h2>Choose Group for Images:</h2>
    <button id="image1">Image 1</button>
    <button id="image2">Image 2</button>
    <button id="image3">Image 3</button>
    <!-- Add more buttons for other images -->
</div>

<div class="question-container">
    <h2 class="question">Identify the Image</h2>
</div>

<div class="stopwatch-container">
    <h2>Stopwatch</h2>
    <div id="stopwatch">00:00</div>
    <button id="startButton">Start</button>
    <button id="stopResumeButton">Stop</button>
</div>

<div class="image-container">
    <img id="imageDisplay" class="image" src="" alt="Image">
</div>

<audio id="beepAudio">
    <source src="beep.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

<script>
    var stopwatchRunning = false;

    // Add event listeners for image buttons
    document.getElementById("image1").addEventListener("click", function() {
        displayImage("image1.jpg");
        if (!stopwatchRunning) {
            startStopwatch();
        }
    });

    document.getElementById("image2").addEventListener("click", function() {
        displayImage("image2.jpg");
        if (!stopwatchRunning) {
            startStopwatch();
        }
    });

    document.getElementById("image3").addEventListener("click", function() {
        displayImage("image3.jpg");
        if (!stopwatchRunning) {
            startStopwatch();
        }
    });

    // Add more event listeners for other images

    function displayImage(imageURL) {
        var imageDisplay = document.getElementById("imageDisplay");
        imageDisplay.src = imageURL;
    }

    // ... your existing JavaScript code ...

</script>

</body>
</html>
