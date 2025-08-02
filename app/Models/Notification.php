<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'body', 'notifiable_id', 'notifiable_type', 'is_read','contentable_id','contentable_type'];
    public $translatable = ['title','body'];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function contentable()
    {
        return $this->morphTo();
    }
    public function scopeForNotifiable($query, $notifiable)
    {
        return $query->where('notifiable_id', $notifiable->id)
            ->where('notifiable_type', get_class($notifiable));
    }

    public static function unreadCountForNotifiable($notifiable)
    {
        return self::where('notifiable_id', $notifiable->id)
            ->where('notifiable_type', get_class($notifiable))
            ->where('is_read', false)
            ->count();
    }

    public static function markAllAsRead($notifiable)
    {
        return self::where('notifiable_id', $notifiable->id)
            ->where('notifiable_type', get_class($notifiable))
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}
