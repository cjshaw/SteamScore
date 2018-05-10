<?php

require "utilFunctions.php";
require "Player.php";
require_once "connection.php";
require "key.php";

// lets php load at an unlimited time limit
set_time_limit(0);

session_start();

$username = $_GET['username']; //76561197961018668, sample steam ID for quick copy and paste.


//getting steamid from custom URL and reading profile
$json_output = steamidResolve($username, $apiKey);

$personaname = $json_output->response->players[0]->personaname; //username
$avatarURL = $json_output->response->players[0]->avatarfull; //url for steam icon
$profileURL = $json_output->response->players[0]->profileurl; //url for steam profile
$steamId = $json_output->response->players[0]->steamid; //17 digit steamID number

$gamesListURL = 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key='.$apiKey.'&include_appinfo=1&steamid=' . $steamId;
$gamesListData = curl_connect($gamesListURL);
$gamesListOut = json_decode($gamesListData);

$gameCount = $gamesListOut->response->game_count;

//dummy number for object, not implemented.
$earnedAchievements = 60;

$dB = Db::getInstance();

//adds steam id and username to users table
$result = mysqli_query($dB, "INSERT INTO users(user_id, username)
				VALUES('$steamId','$personaname')");

//loop for each app the user owns
foreach ($gamesListOut->response as $keys => $games) {
    foreach ($games as $k => $gameID) {
        $appId = $gameID->appid;
        $appTitle = $gameID->name;
        $logo = $gameID->img_logo_url;
        $appTitle = $dB->real_escape_string($appTitle);

        $appResult = mysqli_query($dB, "INSERT INTO games(app_id, app_title, logo)
                                  VALUES ('$appId','$appTitle','$logo')");
        $linkingResult = mysqli_query($dB, "INSERT INTO user_game(user_id, app_id)
                                  VALUES ('$steamId','$appId')");
        if (!empty($logo)) {
            $gridItem .= "<button class=\"menu_links\" onclick=\"displayData(11,1,0,'A')\" onmouseover=\"grayScale(this)\" onmouseout=\"unGrayScale(this)\"  id= \"appid\" name=\"appid\" type=\"image\" value=\"$appId\">
                            <img id='buttonImg' src=\"http://media.steampowered.com/steamcommunity/public/images/apps/$appId/$logo.jpg\"></button>";
        }
        $gameScore += steamScore($steamId, $appId, $apiKey);  // helper function call that adds up Steam Achievement Score
    }
}

$scoreSum = $gameScore;

$dB->close();

$currentPlayer = new Player($steamId, $appId, $scoreSum, $earnedAchievements, $personaname, $avatarURL, $profileURL);

$_SESSION['player'] = $currentPlayer;

include 'templates/profileTemplate.php';
?>


