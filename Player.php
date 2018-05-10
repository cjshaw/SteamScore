<?php


class Player
{
    private $steamId;
    private $appId;
    private $gamerScore;
    private $earnedAchievements;
    private $playerHandle;
    private $avatarURL;
    private $profileURL;

    /**
     * Player constructor.
     * @param $steamId
     * @param $appId
     * @param $gamerScore
     * @param $earnedAchievements
     * @param $playerHandle
     * @param $avatarURL
     * @param $profileURL
     */
    public function __construct($steamId, $appId, $gamerScore, $earnedAchievements, $playerHandle, $avatarURL, $profileURL)
    {
        $this->steamId = $steamId;
        $this->appId = $appId;
        $this->gamerScore = $gamerScore;
        $this->earnedAchievements = $earnedAchievements;
        $this->playerHandle = $playerHandle;
        $this->profileURL = $profileURL;
        $this->avatarURL = $avatarURL;

    }

    /**
     * @return mixed
     */
    public function getSteamId()
    {
        return $this->steamId;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $gamerScore
     */
    public function setGamerScore($gamerScore)
    {
        $this->gamerScore = $gamerScore;
    }

    /**
     * @return mixed
     */
    public function getGamerScore()
    {
        return $this->gamerScore;
    }

    /**
     * @return mixed
     */
    public function getEarnedAchievements()
    {
        return $this->earnedAchievements;
    }

    /**
     * @return mixed
     */
    public function getPlayerHandle()
    {
        return $this->playerHandle;
    }

    /**
     * @return mixed
     */
    public function getAvatarURL()
    {
        return $this->avatarURL;
    }

    /**
     * @return mixed
     */
    public function getProfileURL()
    {
        return $this->profileURL;
    }


}