<?php
// modules/EventRoleAssignment/Infrastructure/Persistence/Eloquent/EventRoleAssignmentModel.php
declare(strict_types=1);

namespace Modules\EventRoleAssignment\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class EventRoleAssignmentModel extends Model
{
    use HasUuids;

    protected $table = 'event_role_assignments';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'event_id',
        'user_id',
        'role_id',
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

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Role\Infrastructure\Persistence\Eloquent\RoleModel::class,
            'role_id',
        );
    }
}
