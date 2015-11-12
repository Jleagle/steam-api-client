<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Exceptions\SteamException;
use Jleagle\SteamClient\Responses\BadgeResponse;
use Jleagle\SteamClient\Responses\BadgesResponse;
use Jleagle\SteamClient\Responses\CommunityBadge;
use Jleagle\SteamClient\Responses\OwnedGameResponse;
use Jleagle\SteamClient\Responses\PlayingSharedGameResponse;
use Jleagle\SteamClient\Responses\RecentlyPlayedGameResponse;
use Jleagle\SteamClient\Responses\SteamLevelResponse;
use Packaged\Helpers\Arrays;

class SteamPlayerService extends AbstractSteam
{
  /**
   * @return string
   */
  protected function _getService()
  {
    return 'IPlayerService';
  }

  /**
   * @param int   $steamId
   * @param bool  $includeAppInfo
   * @param bool  $includeFreeGames
   * @param int[] $appIdsFilter
   *
   * @return OwnedGameResponse[]
   *
   * @throws SteamException
   */
  public function getOwnedGames(
    $steamId, $includeAppInfo = true, $includeFreeGames = true,
    $appIdsFilter = []
  )
  {
    $path = 'GetOwnedGames/v1';
    $query = [
      'steamId'                   => $steamId,
      'include_appinfo'           => $includeAppInfo,
      'include_played_free_games' => $includeFreeGames,
      'appids_filter'             => $appIdsFilter,
    ];

    $data = $this->_get($path, $query);

    if(!isset($data['response']['games']))
    {
      return [];
    }

    $games = [];
    foreach($data['response']['games'] as $game)
    {
      $games[] = new OwnedGameResponse(
        [
          'appId'                    => $game['appid'],
          'playtimeForever'          => $game['playtime_forever'],
          'name'                     => Arrays::value($game, 'name'),
          'imgIconUrl'               => Arrays::value($game, 'img_icon_url'),
          'imgLogoUrl'               => Arrays::value($game, 'img_logo_url'),
          'hasCommunityVisibleStats' => Arrays::value(
            $game,
            'has_community_visible_stats',
            0
          ),
        ]
      );
    }

    return $games;
  }

  /**
   * @param int $steamId
   *
   * @return RecentlyPlayedGameResponse[]
   *
   * @throws SteamException
   */
  public function getRecentlyPlayedGames($steamId)
  {
    $path = 'GetRecentlyPlayedGames/v1';
    $query = [
      'steamid' => $steamId,
      'count'   => null,
    ];

    $data = $this->_get($path, $query);

    if(!isset($data['response']['games']))
    {
      return [];
    }

    $games = [];
    foreach($data['response']['games'] as $game)
    {
      $games[] = new RecentlyPlayedGameResponse(
        [
          'appId'            => $game['appid'],
          'name'             => $game['name'],
          'playtimeTwoWeeks' => $game['playtime_2weeks'],
          'playtimeForever'  => $game['playtime_forever'],
          'imgIconUrl'       => $game['img_icon_url'],
          'imgLogoUrl'       => $game['img_logo_url'],
        ]
      );
    }

    return $games;
  }

  /**
   * @param int $steamId
   *
   * @return SteamLevelResponse
   *
   * @throws SteamException
   */
  public function getSteamLevel($steamId)
  {
    $path = 'GetSteamLevel/v1';
    $query = ['steamId' => $steamId];

    $data = $this->_get($path, $query);

    return new SteamLevelResponse(
      [
        'level' => $data['response']['player_level']
      ]
    );
  }

  /**
   * @param int $steamId
   *
   * @return BadgesResponse
   *
   * @throws SteamException
   */
  public function getBadges($steamId)
  {
    $path = 'GetBadges/v1';
    $query = ['steamId' => $steamId];

    $data = $this->_get($path, $query)['response'];

    if(!$data)
    {
      return new BadgesResponse();
    }

    $badges = new BadgesResponse(
      [
        'playerXp'                   => $data['player_xp'],
        'playerLevel'                => $data['player_level'],
        'playerXpNeededToLevelUp'    => $data['player_xp_needed_to_level_up'],
        'playerXpNeededCurrentLevel' => $data['player_xp_needed_current_level'],
        'badges'                     => Arrays::value($data, 'badges', []),
      ]
    );

    $items = [];
    foreach($badges->badges as $badge)
    {
      $items[] = new BadgeResponse(
        [
          'id'              => $badge['badgeid'],
          'level'           => $badge['level'],
          'completion_time' => $badge['completion_time'],
          'xp'              => $badge['xp'],
          'scarcity'        => $badge['scarcity'],
        ]
      );
    }
    $badges->badges = $items;

    return $badges;
  }

  /**
   * @param int $steamId
   *
   * @return CommunityBadge[]
   *
   * @throws SteamException
   */
  public function getCommunityBadgeProgress($steamId)
  {
    $path = 'GetCommunityBadgeProgress/v1';
    $query = ['steamId' => $steamId];

    $data = $this->_get($path, $query);

    $items = [];
    foreach($data['response']['quests'] as $item)
    {
      $items[] = new CommunityBadge(
        [
          'questId'   => $item['questid'],
          'completed' => $item['completed'],
        ]
      );
    }

    return $items;
  }

  /**
   * @param int $steamId
   * @param int $appId
   *
   * @return PlayingSharedGameResponse
   *
   * @throws SteamException
   */
  public function isPlayingSharedGame($steamId, $appId)
  {
    $path = 'IsPlayingSharedGame/v1';
    $query = ['steamId' => $steamId, 'appid_playing' => $appId];

    $data = $this->_get($path, $query);

    return new PlayingSharedGameResponse(
      [
        'lenderSteamId' => $data['response']['lender_steamid']
      ]
    );
  }
}
