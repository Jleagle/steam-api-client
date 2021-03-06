<?php
namespace Jleagle\SteamClient\Responses;

class AbstractResponse
{
  public function __construct(array $data = null)
  {
    if($data && is_array($data))
    {
      foreach($data as $field => $value)
      {
        $this->$field = $value;
      }
    }
  }

  public function toArray()
  {
    return get_object_vars($this);
  }
}
