<div align="center">
  <a href="https://novu.co" target="_blank">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://user-images.githubusercontent.com/2233092/213641039-220ac15f-f367-4d13-9eaf-56e79433b8c1.png">
    <img src="https://user-images.githubusercontent.com/2233092/213641043-3bbb3f21-3c53-4e67-afe5-755aeb222159.png" width="280" alt="Logo"/>
  </picture>
  </a>
</div>

# Novu for Laravel

A package to easily integrate your Laravel application with Novu.

## Contents

* [Installation](#installation)
* [Usage](#usage)
    * [In-App Notifications](#in-app-notification-center)
    * [Events](#events)
    * [Subscribers](#subscribers)
    * [Topics](#topics)
    * [Activity](#activity)
    * [Integrations](#integrations)
    * [Notifications](#notifications)
    * [Notification Templates](#notification-templates)
    * [Notification Groups](#notification-groups)
    * [Changes](#changes)
    * [Environments](#environments)
    * [Feeds](#feeds)
    * [Messages](#messages)
    * [Execution Details](#execution-details)
    * [Validate the MX Record setup for Inbound Parse functionality](#validate-the-mx-record-setup-for-inbound-parse-functionality)
* [Configuration](#configuration)
* [License](#license)
* [Novu API Reference](https://docs.novu.co/api/overview/)

## Installation

[PHP](https://php.net) 7.3+ and [Composer](https://getcomposer.org) are required. Supports **_Laravel 7, 8, 9 and 10_** out of the box.

To get the latest version of Novu Laravel, simply require it:

```bash
composer require novu/novu-laravel
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Novu\Laravel\NovuServiceProvider" --tag="novu-laravel-config"
```

A configuration file named `novu.php` with some sensible defaults will be placed in your `config` directory:

```php
<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Novu API Key
    |--------------------------------------------------------------------------
    |
    | The Novu API key give you access to Novu's API. The "api_key" is
    | typically used to make a request to the API.
    |
    */
    'api_key' => env('NOVU_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | The Novu API Base URL.
    |--------------------------------------------------------------------------
    |
    | The Novu API Base URL can be a self-hosted novu api or Novu's web cloud API
    | typically used to make a request to Novu's service.
    |
    */
    'api_url' => env('NOVU_BASE_API_URL', 'https://api.novu.co/v1/'),
];
```

### API Keys
Open your `.env` file and add your API Key.

```php
NOVU_API_KEY=xxxxxxxxxxxxx
```

***Note:** You need to get these credentials from your [Novu Dashboard](https://web.novu.co/settings)*

## Usage

### In-App Notification Center

Novu relies on its own JavaScript library to initiate and display the In-App Notification Center. You can load the JavaScript library by placing the @novuJS directive right before your application layout's closing </head> tag:

```html
<head>
    ...
    @novuJS
</head>
```

**Note:** If you're using this package for a Laravel API Backend, you don't need to use this! Use the In-App Notification Center JavaScript library available for [Vue](https://docs.novu.co/notification-center/vue-component), [React](https://docs.novu.co/notification-center/react/react-components), [Angular](https://docs.novu.co/notification-center/angular-component) and [Vanilla JS](https://docs.novu.co/notification-center/web-component).

### EVENTS

**Trigger** an event - send notification to subscribers:

```php
use Novu\Laravel\Facades\Novu;

$response = Novu::triggerEvent([
    'name' => '<REPLACE_WITH_TEMPLATE_NAME_FROM_ADMIN_PANEL>',
    'payload' => ['customVariables' => 'Hello'],
    'to' => [
        'subscriberId' => '<SUBSCRIBER_IDENTIFIER_FROM_ADMIN_PANEL>',
        'phone' => '07983882186'
    ]
])->toArray();
```

**Bulk Trigger** events:

```php
use Novu\Laravel\Facades\Novu;

$response = Novu::bulkTriggerEvent([
    [
        'name' => '<REPLACE_WITH_TEMPLATE_NAME_FROM_ADMIN_PANEL>', 
        'to' => '<SUBSCRIBER_IDENTIFIER_FROM_ADMIN_PANEL>', 
        'payload' => ['customVariables' => 'Hello']
    ],
    [
        'name' => '<REPLACE_WITH_TEMPLATE_NAME_FROM_ADMIN_PANEL>', 
        'to' => '<SUBSCRIBER_IDENTIFIER_FROM_ADMIN_PANEL>', 
        'payload' => ['customVariables' => 'World']
    ],
    [
        'name' => '<REPLACE_WITH_TEMPLATE_NAME_FROM_ADMIN_PANEL>', 
        'to' => '<SUBSCRIBER_IDENTIFIER_FROM_ADMIN_PANEL>', 
        'payload' => ['customVariables' => 'Again']
    ]
])->toArray();
```

**Trigger** an event - [send notification to topics](https://docs.novu.co/platform/topics#sending-a-notification-to-a-topic)

```php
use Novu\Laravel\Facades\Novu;

$response = Novu::triggerEvent([
    'name' => '<event_name>',
    'payload' => ['customVariables' => 'Hello'],
    'to' => [
        [
            'type' => 'Topic',
            'topicKey' => $topicKey
        ],
        [
            'type' => 'Topic',
            'topicKey' => $topicSecondKey
        ]
    ]
])->toArray();

```

**Broadcast** event to all existing subscribers:

```php
use Novu\Laravel\Facades\Novu;

$response = Novu::broadcastEvent([
    'name' => '<REPLACE_WITH_EVENT_NAME_FROM_ADMIN_PANEL>',
    'payload' => ['customVariables' => 'Hello'],
    'transactionId' => '<REPLACE_WITH_TRANSACTION_ID>'
])->toArray();
```

**Cancel** triggered event. Using a previously generated transactionId during the event trigger, this action will cancel any active or pending workflows:

```php
use Novu\Laravel\Facades\Novu;

$response = Novu::cancelEvent($transactionId);
```

### SUBSCRIBERS

```php
use Novu\Laravel\Facades\Novu;

// Get list of subscribers
$subscribers  = Novu::getSubscriberList();

// Create subscriber & get the details of the recently created subscriber returned.
$subscriber = Novu::createSubscriber([
    'subscriberId' => 'YOUR_SYSTEM_USER_ID>',
    'email' => '<insert-email>', // optional
    'firstName' => '<insert-firstname>', // optional
    'lastName' => '<insert-lastname>', // optional
    'phone' => '<insert-phone>', //optional
    'avatar' => '<insert-avatar>', // optional
])->toArray();

// Get subscriber
$subscriber = Novu::getSubscriber($subscriberId)->toArray();

// Update subscriber
$subscriber = Novu::updateSubscriber($subscriberId, [
    'email' => '<insert-email>', // optional
    'firstName' => '<insert-firstname>', // optional
    'lastName' => '<insert-lastname>', // optional
    'phone' => '<insert-phone>', //optional
    'avatar' => '<insert-avatar>', // optional
])->toArray();

// Delete subscriber
Novu::deleteSubscriber($subscriberId);

// Update subscriber credentials
$response = Novu::updateSubscriberCredentials($subscriberId, [
    'providerId'  => '<insert-providerId>',
    'credentials' => '<insert-credentials>'
])->toArray();

// Update subscriber online status
$isOnlineStatus = true; // or false
$response = Novu::updateSubscriberOnlineStatus($subscriberId, $isOnlineStatus)->toArray();

// Get subscriber preferences
$preferences = Novu::getSubscriberPreferences($subscriberId)->toArray();

// Update subscriber preference
Novu::updateSubscriberPreference($subscriberId, $templateId, [
    'channel' => 'insert-channel',
    'enabled' => 'insert-boolean-value' // optional
]);

// Get a notification feed for a particular subscriber
$feed = Novu::getNotificationFeedForSubscriber($subscriberId);

// Get the unseen notification count for subscribers feed
$count = Novu::getUnseenNotificationCountForSubscriber($subscriberId);

// Mark a subscriber feed message as seen
Novu::markSubscriberFeedMessageAsSeen($subscriberId, $messageId, []);

// Mark message action as seen
Novu::markSubscriberMessageActionAsSeen($subscriberId, $messageId, $type, []);

```

### TOPICS

```php
use Novu\Laravel\Facades\Novu;

// Create a Topic
Novu::createTopic([
  'key'  => 'frontend-users',
  'name' => 'All frontend users'
]);

// Fetch all topics
Novu::getTopics();

// Get a topic
Novu::topic($topicKey);

// Add subscribers to a topic
$subscribers = [
    '63e271488c028c44fd3a64e7',
    '3445'
];
Novu::topic($topicKey)->addSubscribers($subscribers);

// Remove subscribers from a topic
$subscribers = [
    '63e271488c028c44fd3a64e7',
    '3445'
];
Novu::topic($topicKey)->removeSubscribers($subscribers);

// Rename a topic
Novu::topic($topicKey)->rename($topicName);

```

### ACTIVITY

```php
use Novu\Laravel\Facades\Novu;

// Get activity feed
$feed = Novu::getActivityFeed();

// Get activity statistics
$stats = Novu::getActivityStatistics()->toArray();

// Get activity graph statistics
$graphStats = Novu::getActivityGraphStatistics()->toArray();

```

### INTEGRATIONS

```php
use Novu\Laravel\Facades\Novu;

// Get integrations
Novu::getIntegrations()->toArray();

// Create integration
Novu::createIntegration([
    'providerId' => '<insert->provider->id>',
    'channel' => '<insert->channel>',
    'credentials' => [
        // insert all the fields
    ],
    'active' => true,
    'check' => true
])->toArray();

// Get active integrations
Novu::getActiveIntegrations()->toArray();

// Get webhook support status for provider
Novu::getWebhookSupportStatusForProvider($providerId)->toArray();

// Update integration
Novu::updateIntegration($integrationId, [
    'active' => true,
    'credentials' => [
        // insert all the fields
    ],
    'check' => true
])->toArray();

// Delete integration
Novu::deleteIntegration($integrationId);

```

### NOTIFICATIONS

```php
use Novu\Laravel\Facades\Novu;

// Get all notifications
Novu::getNotifications()->toArray();

// Get all notifications with query parameters
$queryParams = [
    'page' => 3
];
Novu::getNotifications($queryParams)->toArray();

// Get one notification 
Novu::getNotification($notificationId)->toArray();

// Get notification stats
Novu::getNotificationStats()->toArray();

// Get Notification graph stats
Novu::getNotificationGraphStats()->toArray();

// Get Notification graph stats with query parameters
$queryParams = [
    'days' => 5
];
Novu::getNotificationGraphStats($queryParams)->toArray();

```

### NOTIFICATION TEMPLATES

```php
use Novu\Laravel\Facades\Novu;

// Get notification templates
Novu::getNotificationTemplates()->toArray();

// Create notification template
Novu::createNotificationTemplate([
  "name" => "name",
  "notificationGroupId" => "notificationGroupId",
  "tags" => ["tags"],
  "description" => "description",
  "steps" => ["steps"],
  "active" => true,
  "draft" => true,
  "critical" => true,
  "preferenceSettings" => preferenceSettings
])->toArray();

// Update notification template
Novu::updateNotificationTemplate($templateId, [
  "name" => "name",
  "tags" => ["tags"],
  "description" => "description",
  "identifier" => "identifier",
  "steps" => ["steps"],
  "notificationGroupId" => "notificationGroupId",
  "active" => true,
  "critical" => true,
  "preferenceSettings" => preferenceSettings
])->toArray();

// Delete notification template
Novu::deleteNotificationTemplate($templateId);

// Get notification template
Novu::getANotificationTemplate($templateId);

// Update notification template status
Novu::updateNotificationTemplateStatus($templateId, [
    'active' => true
])

```

### NOTIFICATION GROUPS

```php
use Novu\Laravel\Facades\Novu;

// Create Notification group
Novu::createNotificationGroup([
    'name' => '<insert-name>'
]);

// Get Notification groups
Novu::getNotificationGroups()->toArray();

```
### CHANGES

```php
use Novu\Laravel\Facades\Novu;

// Get changes
Novu::getChanges();

// Get changes count
Novu::getChangesCount()->toArray();

// Apply changes
Novu::applyBulkChanges([
    'changeIds' = [
        '<insert-all-the-change-ids>'
    ]
])->toArray();

// Apply change
Novu::applyChange($changeId, []);

```

### ENVIRONMENTS

```php
use Novu\Laravel\Facades\Novu;

// Get current environment
Novu::getCurrentEnvironment()->toArray();

// Create environment
Novu::createEnvironment([
    'name' => '<insert-name>',
    'parentId' => '<insert-parent-id>' // optional
])->toArray();

// Get environments
Novu::getEnvironments()->toArray();

// Update environment by id
Novu::updateEnvironment($envId, [
  "name" => "name",
  "identifier" => "identifier",
  "parentId" => "parentId"
]);

// Get API KEYS
Novu::getEnvironmentsAPIKeys()->toArray();

// Regenerate API KEYS
$key = Novu::regenerateEnvironmentsAPIKeys()->toArray();

// Update Widget Settings
Novu::updateWidgetSettings([
    'notificationCenterEncryption' => true
]);

```

### FEEDS

```php
use Novu\Laravel\Facades\Novu;

// Create feed
Novu::createFeed([
    'name' => '<insert-name-for-feed>'
]);

// Get feeds
Novu::getFeeds()->toArray();

// Delete feed
Novu::deleteFeed();

```

### MESSAGES

```php
use Novu\Laravel\Facades\Novu;

// Get messages
Novu::getMessages();

// Delete message
Novu::deleteMessage();

```

## EXECUTION DETAILS

```php
use Novu\Laravel\Facades\Novu;

// Get execution details
Novu::getExecutionDetails([
    'notificationId' => '<insert-notification-id>',
    'subscriberId'   => '<insert-subscriber-id>'
])->toArray();

```

### Validate the MX Record setup for Inbound Parse functionality

```php
use Novu\Laravel\Facades\Novu;

// Validate MX Record for Inbound Parse
Novu::validateMXRecordForInboundParse()->toArray();

```

## License

Licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
