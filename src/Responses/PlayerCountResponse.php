<?php
namespace Jleagle\SteamClient\Responses;

class PlayerCountResponse extends AbstractResponse
{
  public $playerCount;

  public function __toString()
  {
    return (string)$this->playerCount;
  }
}
