<?php
namespace Jleagle\SteamClient\Responses;

class GroupResponse extends AbstractResponse
{
  public $gid;

  public function __toString()
  {
    return (string)$this->gid;
  }
}
