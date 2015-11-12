<?php
namespace Jleagle\SteamClient\Responses;

class BadgesResponse extends AbstractResponse
{
  public $playerXp;
  public $playerLevel;
  public $playerXpNeededToLevelUp;
  public $playerXpNeededCurrentLevel;
  /**
   * @var BadgeResponse[]
   */
  public $badges = [];
}
