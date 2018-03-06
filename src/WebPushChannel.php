<?php
namespace NotificationChannels\WebPush;

use Minishlink\WebPush\WebPush;
use Illuminate\Notifications\Notification;

class WebPushChannel {
    protected $webPush;

    public function __construct(WebPush $webPush) {
        $this->webPush = $webPush;
    }

    public function send($notifiable, Notification $notification) {
        $subscriptions = $notifiable->routeNotificationFor('WebPush');

        if ( $subscriptions->isEmpty() ) return;

        $payload = json_encode($notification->toWebPush($notifiable, $notification)->toArray());

        $subscriptions->each(function ($sub) use ($payload) {
            $this->webPush->sendNotification(
                $sub->endpoint,
                $payload,
                $sub->public_key,
                $sub->auth_token
            );
        });

        $response = $this->webPush->flush();

        $this->deleteInvalidSubscriptions($response, $subscriptions);
    }
    protected function deleteInvalidSubscriptions($response, $subscriptions) {
        if ( ! is_array($response) ) return;

        foreach ( $response as $index => $value ) {
            if ( ! $value['success'] && isset($subscriptions[$index]) ) $subscriptions[$index]->delete();
        }
    }
}
