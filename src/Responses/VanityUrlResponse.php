<?php
namespace Jleagle\SteamClient\Responses;

class VanityUrlResponse extends AbstractResponse
{
  public $steamId;

  public function __toString()
  {
    return (string)$this->steamId;
  }
}
