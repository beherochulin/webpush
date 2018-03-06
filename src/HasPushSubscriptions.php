<?php
namespace NotificationChannels\WebPush;

trait HasPushSubscriptions {
    public function pushSubscriptions() {
        return $this->hasMany(PushSubscription::class);
    }
    public function updatePushSubscription($endpoint, $key = null, $token = null) {
        $subscription = PushSubscription::findByEndpoint($endpoint);

        if ($subscription && $this->pushSubscriptionBelongsToUser($subscription)) {
            $subscription->public_key = $key;
            $subscription->auth_token = $token;
            $subscription->save();

            return $subscription;
        }

        if ($subscription && ! $this->pushSubscriptionBelongsToUser($subscription)) {
            $subscription->delete();
        }

        return $this->pushSubscriptions()->save(new PushSubscription([
            'endpoint' => $endpoint,
            'public_key' => $key,
            'auth_token' => $token,
        ]));
    }
    public function pushSubscriptionBelongsToUser($subscription) {
        return (int) $subscription->user_id === (int) $this->getAuthIdentifier();
    }
    public function deletePushSubscription($endpoint) {
        $this->pushSubscriptions()
            ->where('endpoint', $endpoint)
            ->delete();
    }
    public function routeNotificationForWebPush() {
        return $this->pushSubscriptions;
    }
}
