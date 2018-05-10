<?php

class App
{
    private $appId;

    /**
     * App constructor.
     * @param $appId
     */
    public function __construct($appId)
    {
        $this->appId = $appId;
    }


    /**
     * @return int $appId
     */
    public function getAppId()
    {
        return $this->appId;
    }


    /**
     * Function that calculates the total percentage of completed achievements.
     * @param $steamId
     * @param $dB
     * @return float $gameCompletionPercent
     */
    public function setAchievements($steamId, $dB)
    {

        $appId = $this->getAppId();

        $achievementURL = 'http://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid=' . $appId . '&key=1DE926993382D94F844F42DD076A24BB&steamid=' . $steamId;
        $achievementData = curl_connect($achievementURL);
        $achievementOut = json_decode($achievementData);

        $achievementCount = 0;
        $hasAchieved = 0;

        foreach ($achievementOut->playerstats as $categories) {
            foreach ($categories as $achievements) {
                $apiname = $achievements->apiname;
                $achieved = $achievements->achieved;
                $achievementCount++;
                if ($achieved == 1) {
                    $boolAchieved = true;
                    $hasAchieved++;
                } else {
                    $boolAchieved = false;
                }
                $achResult = mysqli_query($dB, "INSERT INTO achievement(apiname)
                                  VALUES ('$apiname')");

                $achId = mysqli_query($dB, "SELECT achievement_id FROM achievement 
                                  WHERE apiname LIKE '%$apiname%' LIMIT 1")->fetch_object()->achievement_id;

                $achGame = mysqli_query($dB, "INSERT INTO game_achievement(app_id, achievement_id)
                                  VALUES ('$appId','$achId')");

                $achAppLink = mysqli_query($dB, "INSERT INTO user_achievement(user_id, achievement_id, achieved)
                                  VALUES ('$steamId','$achId','$boolAchieved')");
            }
        }
        $gameCompletionPercent = $hasAchieved / $achievementCount * 100;
        return $gameCompletionPercent;
    }

}