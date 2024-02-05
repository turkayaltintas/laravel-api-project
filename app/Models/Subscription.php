<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'expired_at',
        'renewed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionUser()
    {
        return $this->hasOne(SubscriptionUser::class, 'subscription_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    # Aktif Abonelikler
    public function scopeActive($query)
    {
        return $query->where('expired_at', '>', now());
    }

    # Süresi Dolmuş Abonelikler
    public function scopeExpired($query)
    {
        return $query->where('expired_at', '<=', now());
    }

    # Yenilenmiş Abonelikler
    public function scopeRenewed($query)
    {
        return $query->whereNotNull('renewed_at');
    }

    # Yakında Sona Erecek Abonelikler
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->where('expired_at', '<=', now()->addDays($days))->where('expired_at', '>', now());
    }

    # Son 30 Günde Oluşturulan Abonelikler
    public function scopeCreatedLastDays($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

}
