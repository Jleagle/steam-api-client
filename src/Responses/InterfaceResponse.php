<?php
namespace Jleagle\SteamClient\Responses;

class InterfaceResponse extends AbstractResponse
{
  public $name;
  /**
   * @var MethodResponse[]
   */
  public $methods;
}
