<?php
require_once("connection.php");

/**
 * Recursive function that returns the players Steam ID, even if the custom URL is provided.
 * @param $username
 * @return mixed
 */
function steamidResolve($username, $apiKey)
{
    if (is_numeric($username)) {
        $url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$apiKey.'&steamids=' . $username;
        $data = curl_connect($url);
        return json_decode($data);
    } else {
        $url = 'http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key='.$apiKey.'&vanityurl=' . $username;
        $data = curl_connect($url);
        $json_output = json_decode($data);
        $username = $json_output->response->steamid;
        return steamidResolve($username);
    }
}

/**
 * Helper function for curl connect.
 * @param $url
 * @return mixed
 */
function curl_connect($url)
{
    $ch = curl_init();

//Set the URL that you want to GET by using the CURLOPT_URL option.
    curl_setopt($ch, CURLOPT_URL, $url);

// Disable SSL verification
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//Set method to GET
    curl_setopt($ch, CURLOPT_HTTPGET, true);

//Execute the request.
    $data = curl_exec($ch);

//Close the cURL handle.
    curl_close($ch);

    return $data;
}

/**
 * Calculates the players steam score based on values given to each achievement based on global completion percentages.
 * @param $steamId
 * @param $appId
 * @return int $steamScore
 */
function steamScore($steamId, $appId, $apiKey)
{
    $url = 'http://api.steampowered.com/ISteamUserStats/GetGlobalAchievementPercentagesForApp/v0002/?gameid=' . $appId;
    $json_percent = curl_connect($url);
    $percent_out = json_decode($json_percent);

    $url2 = 'http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?key='.$apiKey.'&steamid=' . $steamId . '&appid=' . $appId;
    $json_achieved = curl_connect($url2);
    $achieved_out = json_decode($json_achieved);

    $steamScore = 0;

    //if(!empty($percent_out->game->availablegamestats)) {
        //$steamScore = 5;
        foreach ($percent_out->achievementpercentages->achievements as $percent) {
            // comaparing name of achievement to name of completed achievement
            $apiName = $percent->name;
            //$achResult = hasAchieved($dB, $apiName);
            foreach ($achieved_out->playerstats->achievements as $names) {
                $achNames = $names->name;
                if ($achNames == $apiName) {
                    if ($percent->percent >= 50) {
                        $steamScore += 5;
                    } elseif ($percent->percent < 50 && $percent->percent >= 25) {
                        $steamScore += 10;
                    } elseif ($percent->percent < 25 && $percent->percent >= 10) {
                        $steamScore += 15;
                    } elseif ($percent->percent < 10 && $percent->percent >= 2) {
                        $steamScore += 20;
                    } else {
                        $steamScore += 25;
                    }
                }
            }
        //}
    }
    return $steamScore;
}

/**
 * Currently an unused function that puts all achievements completed into an array.
 * @param $steamId
 * @param $appId
 * @return array
 */
function hasAchievedToo($steamId, $appId, $apiKey)
{
    $url = 'http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?key='.$apiKey.'&steamid=' . $steamId . '&appid=' . $appId;
    $json_achieved = curl_connect($url);
    $achieved_out = json_decode($json_achieved);
    $achieved = array();
    foreach ($achieved_out->playerstats->achievements as $vals) {
        array_push($achieved, $vals->name);
    }
    return $achieved;
}

/**
 * Finds if user has achieved an achievement or not.
 * @param $dB
 * @param $apiName
 * @param $steamId
 * @return bool
 */
function hasAchieved($dB, $apiName, $steamId)
{
    $achId = mysqli_query($dB, "SELECT achieved FROM user_achievement
            JOIN users ON user_achievement.user_id = users.user_id
            JOIN achievement ON user_achievement.achievement_id = achievement.achievement_id
            WHERE achievement.apiname LIKE '$apiName' AND user_achievement.user_id LIKE '$steamId';")->fetch_object()->achieved;

    if ($achId == 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * Currently an unused function that adds up each individual Steam Score from each row in the game_score column of the
 * database.
 * @param $dB
 * @param $steamId
 * @return mixed
 */
function scoreSum($dB, $steamId)
{
    $result = mysqli_query($dB, "SELECT SUM(game_score) AS score_sum FROM user_game WHERE user_game.user_id LIKE $steamId");
    $row = mysqli_fetch_assoc($result);
    $scoreSum = $row['score_sum'];

    return $scoreSum;
}