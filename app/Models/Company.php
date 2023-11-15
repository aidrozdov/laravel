<?php

namespace App\Models;

//use Bpuig\Subby\Traits\HasSubscriptions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

/**
* @property string $name
* @property string $status
* @property string $user_id
* @property Carbon $created_at;
* @property Carbon $updated_at;
 */
class Company extends Model
{
    use HasFactory;
//    use HasSubscriptions;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_DEACTIVATED = 'deactivated';
    // предоставлен демо доступ
    public const STATUS_DEMO = 'demo';
    // ожидает оплаты
    public const STATUS_PENDING = 'pending';
    // оплата истекла доступен демо
    public const STATUS_EXPIRED = 'expired';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'name', 'status', 'user_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
}
