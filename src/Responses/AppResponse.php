<?php
namespace Jleagle\SteamClient\Responses;

class AppResponse extends AbstractResponse
{
  public $type;
  public $name;
  public $steam_appid;
  public $required_age;
  public $is_free;
  public $detailed_description;
  public $about_the_game;
  public $supported_languages;
  public $header_image;
  public $website;
  public $pc_requirements;
  public $mac_requirements;
  public $linux_requirements;
  public $developers;
  public $publishers;
  public $price_overview;
  public $packages;
  public $package_groups;
  public $platforms;
  public $metacritic;
  public $categories;
  public $genres;
  public $screenshots;
  public $recommendations;
  public $achievements;
  public $release_date;
  public $support_info;
  public $background;
}
