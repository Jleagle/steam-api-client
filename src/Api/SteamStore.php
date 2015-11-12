<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Exceptions\SteamException;
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
   * @return AppResponse
   * @throws SteamException
   */
  public function appDetails($appId)
  {
    $data = $this->_get(null, ['appids' => $appId]);

    return new AppResponse($data[$appId]['data']);
  }
}
