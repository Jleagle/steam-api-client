<?php
namespace Jleagle\SteamClient\Responses;

class PlayerBanResponse extends AbstractResponse
{
  public $SteamId;
  public $CommunityBanned;
  public $VACBanned;
  public $NumberOfVACBans;
  public $DaysSinceLastBan;
  public $NumberOfGameBans;
  public $EconomyBan;
}
