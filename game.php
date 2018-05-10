<?php
require "Player.php";
require "utilFunctions.php";
require "App.php";
require_once "connection.php";
require "key.php";
session_start();

$currentPlayer = $_SESSION['player'];

$steamId = $currentPlayer->getSteamId();
$currentGamerScore = $currentPlayer->getGamerScore();
$personaname = $currentPlayer->getPlayerHandle();
$profileURL = $currentPlayer->getProfileURL();
$avatarURL = $currentPlayer->getAvatarURL();

$appId = $_GET['appid'];

$currentApp = new App($appId);

$url = 'http://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key='. $apiKey .'=' . $appId;
$achievementData = curl_connect($url);
$json_achievement = json_decode($achievementData);

$dB = Db::getInstance();

//calculates the game's completion percentage if the game has achievements.
$gameCompletePercent = $currentApp->setAchievements($steamId, $dB);
if ($gameCompletePercent > 0) {
    $gameCompletePercent = 'Completion Status: ' . number_format($gameCompletePercent, 2) . '%';
} elseif ($gameCompletePercent == 0) {
    $gameCompletePercent = 'Completion Status: 0.00%';
} else {
    $gameCompletePercent = 'There are no achievements for this game';
}

$myTable = '';

//creates grid for uncompleted and completed achievements.
foreach ($json_achievement->game->availableGameStats->achievements as $gameKey => $gameOpt) {
    $displayName = $gameOpt->displayName;
    $apiName = $gameOpt->name;
    $achievedIcon = $gameOpt->icon;
    $notAchievedIcon = $gameOpt->icongray;
    $desc = $gameOpt->description;
    if (hasAchieved($dB, $apiName, $steamId)) {
        $achievedGridItem .= "<div class=\"tooltip\"><img src='$achievedIcon'><span class=\"tooltiptext\">$displayName<br>$desc</span></div>";
    } else {
        $notAchievedGridItem .= "<div class=\"tooltip\"><img src='$notAchievedIcon'><span class=\"tooltiptext\">$displayName<br>$desc</span></div>";
    }
}

$dB->close();

include "templates/gameTemplate.php";