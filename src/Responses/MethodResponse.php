<?php
namespace Jleagle\SteamClient\Responses;

class MethodResponse extends AbstractResponse
{
  public $name;
  public $version;
  public $httpmethod;
  /**
   * @var ParameterResponse[]
   */
  public $parameters;
}
