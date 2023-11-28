<?php
$servername = "88.198.49.38";
$username = "rustic";
$password = "#V2DXsNasYf879mQMEiE&j9Yefh3!A";
$dbname = "Game2048";
$conn = new mysqli($servername, $username, $password, $dbname);
function isInTable($userid): bool
{
    global $conn, $dbname;
    $userid = mysqli_real_escape_string($conn, $userid);
    $result = mysqli_query($conn, "SELECT * FROM $dbname WHERE username = '$userid'");
    if($result && mysqli_num_rows($result) > 0) {
            return true;
        }else {
        return false;
    }
}
function isBetter($userid, $score): bool
{
    global $conn, $dbname;
    $userid = mysqli_real_escape_string($conn, $userid);
    $result = mysqli_query($conn, "SELECT score FROM $dbname WHERE username = '$userid'");
    $result = mysqli_fetch_assoc($result);
    if($score > $result['score']) {
        return true;
    }else return false;
}
if (isset($_POST['submitprompt'])) {
    if (!isset($_POST["username"])) {
        echo "<p id='alert-error'>Empty Username</p>";
        return;
    }
    if (!isset($_POST["score"])) {
        return;
    }
    if ($_POST["score"] === 0) {
        echo "<p id='alert-error'>Score cannot be 0</p>";
        return;
    }
    $user = $_POST["username"];
    $score = $_POST["score"];
    // Create connection

// Check connection
    if ($conn->connect_error) {
        echo "<p id='alert-error'>Connection failed: " . $conn->connect_error . "</p";
        return;
    }
    if (isInTable($user)) {
        if(!isBetter($user, $score)) {
            echo "<p id='alert-error'>Dein Score ist nicht besser als dein eingetragener!</p>";
        }else if ($conn->query("UPDATE Game2048 SET score = '$score' WHERE username = '$user'") === FALSE) {
            echo "<p id='alert-error'>Error on update: <br>" . $conn->error . "</p";
        }
    }else {
        if ($conn->query("INSERT INTO Game2048 (username, score) VALUES ('$user', '$score')") === FALSE) {
            echo "<p id='alert-error'>Error on create: <br>" . $conn->error . "</p";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>2048</title>

    <link href="style/main.css" rel="stylesheet" type="text/css">
    <link href="style/rangliste.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="meta/apple-touch-icon.png">
    <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x1096.png"
          media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)">
    <!-- iPhone 5+ -->
    <link rel="apple-touch-startup-image" href="meta/apple-touch-startup-image-640x920.png"
          media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)">
    <!-- iPhone, retina -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport"
          content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
<div id="overlay prompt">
    <div>
        <form name="formsubmitrang" method="post" action="index.php" style="width: 19em;">
            <p><strong>Dein Ergebnis beim Game 2048:</strong></p>
            Punkte: <span id="end-score">0</span>
            <br>
            <label>Nickname eingeben für Rangliste:</label>
            <input class="username" name="username" type="text" maxlength="15" style="width: 10em"/><br>
            <input name="score" id="score-value" type="hidden" value="0">
            <input class="form-button" name="submitprompt" type="submit" value="JA" style="width: 62px"/>
            <input class="form-button" name="Button2" type="button" value="NEIN" onclick=promptclose() style="width: 62px"/>
        </form>
    </div>
</div>
<div class="bestenliste">
    <table>
        <tr>
            <th>Username</th>
            <th>Score</th>
        </tr>
        <tr>
            <th>Username1</th>
            <th>Score1</th>
        </tr>
    </table>
</div>
<div class="container">
    <div class="heading">
        <h1 class="title">2048</h1>
        <div class="scores-container">
            <div class="score-container">0</div>
            <div class="best-container">0</div>
        </div>
    </div>

    <div class="above-game">
        <p class="game-intro">Join the numbers and get to the <strong>2048 tile!</strong></p>
        <a class="restart-button">New Game</a>
    </div>

    <div class="game-container">
        <div class="game-message">
            <p></p>
            <div class="lower">
                <a class="keep-playing-button">Keep going</a>
                <a class="retry-button">Try again</a>
            </div>
        </div>

        <div class="grid-container">
            <div class="grid-row">
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
            </div>
            <div class="grid-row">
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
            </div>
            <div class="grid-row">
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
            </div>
            <div class="grid-row">
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
                <div class="grid-cell"></div>
            </div>
        </div>

        <div class="tile-container">

        </div>
    </div>

    <p class="game-explanation">
        <strong class="important">How to play:</strong> Use your <strong>arrow keys</strong> to move the tiles. When two
        tiles with the same number touch, they <strong>merge into one!</strong>
    </p>
    <hr>
    <p>
        <strong class="important">Note:</strong> This site is the official version of 2048. You can play it on your
        phone via <a href="http://git.io/2048">http://git.io/2048.</a> All other apps or sites are derivatives or fakes,
        and should be used with caution.
    </p>
    <hr>
    <p>
        Created by <a href="https://gabrielecirulli.com" target="_blank">Gabriele Cirulli.</a> Based on <a
                href="https://itunes.apple.com/us/app/1024!/id823499224" target="_blank">1024 by Veewo Studio</a> and
        conceptually similar to <a href="http://asherv.com/threes/" target="_blank">Threes by Asher Vollmer.</a>
    </p>
</div>

<script src="js/bind_polyfill.js"></script>
<script src="js/classlist_polyfill.js"></script>
<script src="js/animframe_polyfill.js"></script>
<script src="js/keyboard_input_manager.js"></script>
<script src="js/html_actuator.js"></script>
<script src="js/grid.js"></script>
<script src="js/tile.js"></script>
<script src="js/local_storage_manager.js"></script>
<script src="js/game_manager.js"></script>
<script src="js/application.js"></script>
<script src="js/rangliste.js"></script>
</body>
</html>
