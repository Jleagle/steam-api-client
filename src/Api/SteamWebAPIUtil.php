<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Responses\InterfaceResponse;
use Jleagle\SteamClient\Responses\MethodResponse;
use Jleagle\SteamClient\Responses\ParameterResponse;

class SteamWebAPIUtil extends Steam
{
  /**
   * @return string
   */
  protected function _getService()
  {
    return 'ISteamWebAPIUtil';
  }

  /**
   * @return InterfaceResponse[]
   */
  public function getSupportedApiList()
  {
    $path = 'GetSupportedAPIList/v1';

    $data = $this->_get($path, [], false);

    $interfaces = [];
    foreach($data['apilist']['interfaces'] as $key => $interface)
    {
      $methods = [];
      foreach($interface['methods'] as $key2 => $method)
      {
        $params = [];
        foreach($method['parameters'] as $param)
        {
          $params[] = new ParameterResponse($param);
        }
        $method['parameters'] = $params;
        $methods[] = new MethodResponse($method);
      }
      $interface['methods'] = $methods;
      $interfaces[] = new InterfaceResponse($interface);
    }

    return $interfaces;
  }
}
