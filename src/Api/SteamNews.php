<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Responses\NewsResponse;

class AbstractSteamNews extends AbstractSteam
{
  /**
   * @return string
   */
  protected function _getService()
  {
    return 'ISteamNews';
  }

  /**
   * @param int $appId
   * @param int $count
   * @param int $maxLength
   *
   * @return NewsResponse[]
   */
  public function getNewsforApp($appId, $count = null, $maxLength = null)
  {
    $path = 'GetNewsForApp/v2';
    $query = ['appid' => $appId, 'count' => $count, 'maxlength' => $maxLength];

    $data = $this->_get($path, $query);

    $items = [];
    foreach($data['appnews']['newsitems'] as $item)
    {
      $items[] = new NewsResponse($item);
    }
    return $items;
  }
}
