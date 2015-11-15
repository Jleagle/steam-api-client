<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Exceptions\SteamAppNotFoundException;
use Jleagle\SteamClient\Responses\AppResponse;

class SteamStore extends AbstractSteam
{
  /**
   * @return string
   */
  protected function _getService()
  {
    return 'Store';
  }

  /**
   * @param int $appId
   *
   * @return AppResponse
   *
   * @throws SteamAppNotFoundException
   */
  public function appDetails($appId)
  {
    $data = $this->_get(null, ['appids' => $appId]);

    if(isset($data[$appId]['data']))
    {
      return new AppResponse($data[$appId]['data']);
    }
    else
    {
      throw new SteamAppNotFoundException();
    }
  }
}
