<?php
namespace NotificationChannels\WebPush;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model {
    protected $fillable = [
        'endpoint',
        'public_key',
        'auth_token',
    ];

    public function user() {
        return $this->belongsTo(Config::get('auth.providers.users.model'));
    }
    public static function findByEndpoint($endpoint) {
        return static::where('endpoint', $endpoint)->first();
    }
}
