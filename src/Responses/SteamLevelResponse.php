<?php
namespace Jleagle\SteamClient\Responses;

class SteamLevelResponse extends AbstractResponse
{
  /**
   * @var int
   */
  public $level;

  public function __toString()
  {
    return (string)$this->level;
  }
}
