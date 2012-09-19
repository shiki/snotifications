<?php

require(dirname(__FILE__) . '/SNotifications.php');

/**
 * SNotifications as a Yii Framework application component. This contains a single instance
 * of SNotifications that can be accessed through `getDefault()`
 *
 * @package SNotifications
 * @author Shiki
 */
class SNotificationsComponent extends CApplicationComponent
{
  /**
   * Must be in this format:
   *
   * array(
   *   '<event-name>' => array(
   *     array('<class-name>', '<method-name>'),
   *     array('<class-name>', '<method-name>'),
   *     '<function-name>',
   *   )
   *   '<another-event-name>' => array(
   *     array('<class-name>', '<method-name>'),
   *     array('<class-name>', '<method-name>')
   *   )
   * )
   *
   * Observer methods must have the signature `methodName(SNotification $notification)`
   *
   * @var array
   */
  public $observers;

  /**
   *
   * @var SNotifications
   */
  protected $_default;

  /**
   * @return SNotifications
   */
  public function getDefault()
  {
    if (!$this->_default) {
      $this->_default = new SNotifications();
      if (is_array($this->observers)) {
        foreach ($this->observers as $key => $value) {
          $this->_default->addObservers($key, $value);
        }
      }
    }

    return $this->_default;
  }
}
