<?php
namespace Jleagle\SteamClient\Responses;

class UserStatsResponse extends AbstractResponse
{
  public $steamId;
  public $gameName;
  /**
   * @var UserAchievementResponse[]
   */
  public $achievements = [];
  /**
   * @var UserStatResponse[]
   */
  public $stats = [];
}
