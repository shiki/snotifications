<?php

require(dirname(__FILE__) . '/SNotification.php');

/**
 * Inspired by Apple's NSNotificationCenter library, this class is a very simple version of it.
 * Consumers can set observers for specific notification event names. Every time a notification
 * is posted through this class, observers for the given event name will be sent a 
 * SNotification object containing any given data.
 * 
 * SNotifications is meant to be a simple solution for decoupling code. This can help reduce
 * hard dependencies between code modules.
 *
 * @package SNotifications
 * @author Shiki
 */
class SNotifications
{
  /**
   * Array having this format:
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
  protected $_observers = array();
  
  /**
   * Add an observer for an event name.
   * @param string $eventName
   * @param mixed $observer array('<class-name>', '<method-name>') and/or 'function-name'
   */
  public function addObserver($eventName, $observer)
  {
    if (!isset($this->_observers[$eventName]))
      $this->_observers[$eventName] = array($observer);
    else
      $this->_observers[$eventName][] = $observer;
  }
  
  /**
   * Add an array of observers for an event name.
   * @param string $eventName
   * @param array $observers Array of array('<class-name>', '<method-name>') and/or 'function-name'
   */
  public function addObservers($eventName, $observers)
  {
    is_array($observers) || $observers = array($observers);
    
    if (!isset($this->_observers[$eventName]))
      $this->_observers[$eventName] = $observers;
    else
      $this->_observers[$eventName] = array_merge($this->_observers, $observers);
  }
  
  /**
   * Post a notification using `$name` as the event name.
   * @param string $eventName
   * @param mixed $data 
   */
  public function post($eventName, $data = null, $sender = null) 
  {
    $notification = new SNotification($eventName, $data, $sender);
    $this->postNotification($notification);
  }
  
  /**
   * Post a SNotification to observers
   * @param SNotification $notification
   */
  public function postNotification(SNotification $notification)
  {
    if (!array_key_exists($notification->name, $this->_observers))
      return;
    
    foreach ($this->_observers[$notification->name] as $observer) {
      call_user_func($observer, $notification);
    }
  }
}
