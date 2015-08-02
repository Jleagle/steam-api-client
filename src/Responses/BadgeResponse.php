<?php
namespace Jleagle\SteamClient\Responses;

class BadgeResponse extends AbstractResponse
{
  public $id;
  public $level;
  public $completion_time;
  public $xp;
  public $scarcity;
}
