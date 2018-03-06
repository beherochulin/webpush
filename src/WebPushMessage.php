<?php
namespace NotificationChannels\WebPush;

class WebPushMessage {
    protected $title;
    protected $actions = [];
    protected $badge;
    protected $body;
    protected $dir;
    protected $icon;

    protected $image;
    protected $lang;
    protected $renotify;
    protected $requireInteraction;
    protected $tag;
    protected $vibrate;
    protected $data;

    public function title($value) {
        $this->title = $value;

        return $this;
    }
    public function action($title, $action) {
        $this->actions[] = compact('title', 'action');

        return $this;
    }
    public function badge($value) {
        $this->badge = $value;

        return $this;
    }
    public function body($value) {
        $this->body = $value;

        return $this;
    }
    public function dir($value) {
        $this->dir = $value;

        return $this;
    }
    public function icon($value) {
        $this->icon = $value;

        return $this;
    }
    public function image($value) {
        $this->image = $value;

        return $this;
    }
    public function lang($value) {
        $this->lang = $value;

        return $this;
    }
    public function renotify($value = true) {
        $this->renotify = $value;

        return $this;
    }
    public function requireInteraction($value = true) {
        $this->requireInteraction = $value;

        return $this;
    }
    public function tag($value) {
        $this->tag = $value;

        return $this;
    }
    public function vibrate($value) {
        $this->vibrate = $value;

        return $this;
    }
    public function data($value) {
        $this->data = $value;

        return $this;
    }
    public function toArray() {
        return collect([
            'title',
            'actions',
            'badge',
            'body',
            'dir',
            'icon',
            'image',
            'lang',
            'renotify',
            'requireInteraction',
            'tag',
            'vibrate',
            'data',
        ])
        ->mapWithKeys(function ($option) {
            return [$option => $this->{$option}];
        })
        ->reject(function ($value) {
            return is_null($value);
        })
        ->toArray();
    }
}
