<?php

/**
 * The object type sent to notification observers. A SNotification can contain additional
 * data through the $data property. It is recommended that this is used as an associative 
 * array using the helper methods `setDataItem` and `getDataItem`. Consumers are free to 
 * set this to another type though.
 *
 * @package SNotifications
 * @author Shiki
 */
class SNotification
{

  /**
   * Notification name
   * @var string
   */
  public $name;

  /**
   *
   * @var array
   */
  public $data;

  /**
   *
   * @var object
   */
  public $sender;

  /**
   *
   * @param string $name
   * @param mixed $data
   * @param object $sender 
   */
  public function __construct($name = null, $data = null, $sender = null)
  {
    $this->name = $name;
    $this->data = $data;
    $this->sender = $sender;
  }

  /**
   *
   * @param string $key
   * @param mixed $value 
   * @return SNotification
   */
  public function setDataItem($key, $value)
  {
    if (!is_array($this->data))
      $this->data = array();
    $this->data[$key] = $value;
    return $this;
  }

  /**
   *
   * @param array $data 
   * @return SNotification
   */
  public function setData($data)
  {
    $this->data = $data;
    return $this;
  }

  /**
   * Returns null if key is not available
   * @param string $key 
   * @return mixed
   */
  public function getDataItem($key, $defaultValue = null)
  {
    return is_array($this->data) && array_key_exists($key, $this->data) ? $this->data[$key] : $defaultValue;
  }

}
