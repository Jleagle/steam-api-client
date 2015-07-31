<?php
namespace Jleagle\SteamClient\Responses;

class VersionCheckResponse extends AbstractResponse
{
  public $success;
  public $up_to_date;
  public $version_is_listable;
  public $required_version;
  public $message;
}
