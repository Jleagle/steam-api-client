<?php
namespace Jleagle\SteamClient\Responses;

class PlayerAchievements extends AbstractResponse
{
  public $steamId;
  public $gameName;
  /**
   * @var PlayerAchievement[]
   */
  public $achievements = [];
}
