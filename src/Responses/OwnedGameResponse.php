<?php
namespace Jleagle\SteamClient\Responses;

class OwnedGameResponse extends AbstractResponse
{
  public $appId;
  public $name;
  public $playtimeForever;
  public $imgIconUrl;
  public $imgLogoUrl;
  public $hasCommunityVisibleStats;
}
