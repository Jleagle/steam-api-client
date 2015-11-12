<?php
namespace Jleagle\SteamClient\Responses;

class PlayingSharedGameResponse extends AbstractResponse
{
  public $lenderSteamId;

  public function __toString()
  {
    return (string)$this->lenderSteamId;
  }
}
