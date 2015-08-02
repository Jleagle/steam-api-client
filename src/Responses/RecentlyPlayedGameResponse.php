<?php
namespace Jleagle\SteamClient\Responses;

class RecentlyPlayedGameResponse extends AbstractResponse
{
  public $appId;
  public $name;
  public $playtimeTwoWeeks;
  public $playtimeForever;
  public $imgIconUrl;
  public $imgLogoUrl;
}
