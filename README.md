SNotifications
====================================================================================================

Inspired by Apple's NSNotificationCenter library, this class is a very simple version of it.
Consumers can set observers for specific notification event names. Every time a notification
is posted through this class, observers for the given event name will be sent a 
SNotification class instance containing any passed data.

SNotifications is meant to be a simple solution for decoupling code. This can help reduce
hard dependencies between code modules.

If you're using Yii Framework, an application component class `SNotificationsComponent` 
is also available in this package.

This requires PHP 5.3+


Usage
----------------------------------------------------------------------------------------------------

1. Create an instance of `SNotifications` that can be accessed by all your classes. PHP best 
practices recommend this to be inside a class.

        require('SNotifications.php');

        class MyGlobals 
        {
          public static $notifications = new SNotifications();
        }

2. Add observers for your event names.

        MyGlobals::$notifications->addObserver('new-user-created', 
          array('UserDataStorage', 'onNewUserCreatedNotification'));

3. Observers must be able to receive a SNotification class.

        class UserDataStorage
        {
          public static onNewUserCreatedNotification($notification)
          {
            // Notification senders can pass additional data. In here, we're expecting 
            // senders of the `new-user-created` event to pass in the userId
            $userId = $notification->getDataItem('userId', null);
            // do something with userId
          }
        }

4. Somewhere in your code, post notifications.

        // post a `new-user-created` event with a `userId` data item 
        MyGlobals::$notifications->post('new-user-created', array('userId' => '<a-user-id>'));
    

Usage (Yii Framework)
----------------------------------------------------------------------------------------------------

There is a Yii Framework application component class named `SNotificationsComponent` included 
in the package. The class allows setting of observers in the configuration file. It also provides
a static instance of `SNotifications` for convenience.

To set it up, just declare the component in the Yii configuration file under `components`:

    'components' => array(
      ...
 
      'notifications' => array(
        'class' => 'ext.snotifications.SNotificationsComponent',
        'observers' => array(
          'new-user-created' => array(
            array('UserDataStorage', 'onNewUserCreatedNotification')
          ),
          // other events here
        ),
      )      

      ...
    )

To post notifications, use the `getDefault` method for getting the SNotifications instance:

    Yii::app()->notifications->getDefault()->post('new-user-created', 
      array('userId' => '<a-user-id>'));