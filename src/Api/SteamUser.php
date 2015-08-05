<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Enums\FriendRelationshipEnum;
use Jleagle\SteamClient\Exceptions\SteamException;
use Jleagle\SteamClient\Responses\FriendResponse;
use Jleagle\SteamClient\Responses\GroupResponse;
use Jleagle\SteamClient\Responses\PlayerBanResponse;
use Jleagle\SteamClient\Responses\PlayerSummaryResponse;
use Jleagle\SteamClient\Responses\VanityUrlResponse;

class SteamUser extends Steam
{
  /**
   * @return string
   */
  protected function _getService()
  {
    return 'ISteamUser';
  }

  /**
   * @param int    $steamId
   * @param string $relationship
   *
   * @return FriendResponse[]
   *
   * @throws SteamException
   */
  public function getFriendList(
    $steamId, $relationship = FriendRelationshipEnum::ALL
  )
  {
    $path = 'GetFriendList/v1';
    $query = ['steamid' => $steamId, 'relationship' => $relationship];

    $data = $this->_get($path, $query);

    $items = [];
    foreach($data['friendslist']['friends'] as $friend)
    {
      $items[] = new FriendResponse($friend);
    }

    return $items;
  }

  /**
   * @param int $steamId
   *
   * @return PlayerBanResponse[]
   *
   * @throws SteamException
   */
  public function getPlayerBans($steamId)
  {
    $path = 'GetPlayerBans/v1';
    $query = ['steamids' => $steamId];

    $data = $this->_get($path, $query);

    $bans = [];
    foreach($data['players'] as $ban)
    {
      $bans[] = new PlayerBanResponse($ban);
    }

    return $bans;
  }

  /**
   * @param int $steamId
   *
   * @return PlayerSummaryResponse
   *
   * @throws SteamException
   */
  public function getPlayerSummary($steamId)
  {
    $path = 'GetPlayerSummaries/v2';
    $query = ['steamids' => $steamId];

    $data = $this->_get($path, $query);

    return new PlayerSummaryResponse($data['response']['players'][0]);
  }

  /**
   * @param int $steamId
   *
   * @return GroupResponse[]
   *
   * @throws SteamException
   */
  public function getUserGroupList($steamId)
  {
    $path = 'GetUserGroupList/v1';
    $query = ['steamid' => $steamId];

    $data = $this->_get($path, $query);

    $groups = [];
    foreach($data['response']['groups'] as $group)
    {
      $groups[] = new GroupResponse($group);
    }

    return $groups;
  }

  /**
   * @param string $vanityUrl
   *
   * @return VanityUrlResponse
   *
   * @throws SteamException
   */
  public function resolveVanityUrl($vanityUrl)
  {
    $path = 'ResolveVanityURL/v1';
    $query = ['vanityurl' => $vanityUrl];

    $data = $this->_get($path, $query);

    return new VanityUrlResponse(
      [
        'steamId' => $data['response']['steamid']
      ]
    );
  }
}
