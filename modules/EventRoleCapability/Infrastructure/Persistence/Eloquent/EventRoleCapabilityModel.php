<?php
// modules/EventRoleCapability/Infrastructure/Persistence/Eloquent/EventRoleCapabilityModel.php
declare(strict_types=1);

namespace Modules\EventRoleCapability\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class EventRoleCapabilityModel extends Model
{
    use HasUuids;

    protected $table = 'event_role_capabilities';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'event_id',
        'user_id',
        'capability',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Event\Infrastructure\Persistence\Eloquent\EventModel::class,
            'event_id',
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'user_id',
        );
    }
}
