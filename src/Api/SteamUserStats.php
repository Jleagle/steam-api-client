<?php
namespace Jleagle\SteamClient\Api;

use Jleagle\SteamClient\Responses\GlobalAchievementResponse;
use Jleagle\SteamClient\Responses\PlayerAchievement;
use Jleagle\SteamClient\Responses\PlayerAchievements;
use Jleagle\SteamClient\Responses\PlayerCountResponse;
use Jleagle\SteamClient\Responses\SchemaAchievementResponse;
use Jleagle\SteamClient\Responses\SchemaResponse;
use Jleagle\SteamClient\Responses\SchemaStatResponse;
use Jleagle\SteamClient\Responses\StatResponse;
use Jleagle\SteamClient\Responses\UserAchievementResponse;
use Jleagle\SteamClient\Responses\UserStatResponse;
use Jleagle\SteamClient\Responses\UserStatsResponse;

class SteamUserStats extends Steam
{
  /**
   * @return string
   */
  protected function _getService()
  {
    return 'ISteamUserStats';
  }

  public function getGlobalAchievementPercentagesForApp($appId)
  {
    $path = 'GetGlobalAchievementPercentagesForApp/v2';
    $query = ['gameid' => $appId];

    $data = $this->_get($path, $query);

    $items = [];
    foreach($data['achievementpercentages']['achievements'] as $item)
    {
      $response = new GlobalAchievementResponse($item);
      if($response->name || $response->percent)
      {
        $items[] = $response;
      }
    }
    return $items;
  }

  public function getGlobalStatsForGame($appId, array $achievements)
  {
    $path = 'GetGlobalStatsForGame/v1';
    $query = [
      'appid' => $appId,
      'count' => count($achievements),
      'name'  => $achievements,
    ];

    $data = $this->_get($path, $query);

    $items = [];
    foreach($data['response']['globalstats'] as $name => $value)
    {
      $items[] = new StatResponse(
        ['name' => $name, 'value' => $value['total']]
      );
    }
    return $items;
  }

  public function getNumberOfCurrentPlayers($appId)
  {
    $path = 'GetNumberOfCurrentPlayers/v1';
    $query = ['appid' => $appId];

    $data = $this->_get($path, $query);

    return new PlayerCountResponse(
      [
        'playerCount' => $data['response']['player_count']
      ]
    );
  }

  public function getPlayerAchievements($steamId, $appId)
  {
    $path = 'GetPlayerAchievements/v1';
    $query = ['steamid' => $steamId, 'appid' => $appId, 'l' => 'english'];

    $data = $this->_get($path, $query);

    $achievements = new PlayerAchievements(
      [
        'steamId'      => $data['playerstats']['steamID'],
        'gameName'     => $data['playerstats']['gameName'],
        'achievements' => $data['playerstats']['achievements'],
      ]
    );

    $items = [];
    foreach($achievements->achievements as $value)
    {
      $items[] = new PlayerAchievement(
        [
          'apiName'     => $value['apiname'],
          'achieved'    => $value['achieved'],
          'name'        => $value['name'],
          'description' => $value['description'],
        ]
      );
    }
    $achievements->achievements = $items;
    return $achievements;
  }

  public function getUserStatsForGame($steamId, $appId)
  {
    $path = 'GetUserStatsForGame/v2';
    $query = [
      'steamid' => $steamId,
      'appid'   => $appId,
      'l'       => 'english',
    ];

    $data = $this->_get($path, $query);

    $stats = new UserStatsResponse(
      [
        'steamId'      => $data['playerstats']['steamID'],
        'gameName'     => $data['playerstats']['gameName'],
        'achievements' => $data['playerstats']['achievements'],
        'stats'        => $data['playerstats']['stats'],
      ]
    );

    $items = [];
    foreach($stats->achievements as $value)
    {
      $items[] = new UserAchievementResponse(
        [
          'name'     => $value['name'],
          'achieved' => $value['achieved'],
        ]
      );
    }
    $stats->achievements = $items;

    $items = [];
    foreach($stats->stats as $value)
    {
      $items[] = new UserStatResponse(
        [
          'name'  => $value['name'],
          'value' => $value['value'],
        ]
      );
    }
    $stats->stats = $items;
    return $stats;
  }

  public function getSchemaForGame($appId)
  {
    $path = 'GetSchemaForGame/v2';
    $query = ['appid' => $appId];

    $data = $this->_get($path, $query);

    $stats = new SchemaResponse(
      [
        'gameName'    => $data['game']['gameName'],
        'gameVersion' => $data['game']['gameVersion'],
      ]
    );

    $achievements = [];
    foreach($data['game']['availableGameStats']['achievements'] as $value)
    {
      $achievements[] = new SchemaAchievementResponse($value);
    }
    $stats->achievements = $achievements;

    $items = [];
    foreach($data['game']['availableGameStats']['stats'] as $value)
    {
      $items[] = new SchemaStatResponse($value);
    }
    $stats->stats = $items;
    return $stats;
  }
}
