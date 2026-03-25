<?php
// modules/EventTask/Infrastructure/Persistence/Eloquent/EventTaskModel.php
declare(strict_types=1);

namespace Modules\EventTask\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

final class EventTaskModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'event_tasks';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['title', 'description'];

    protected $fillable = [
        'event_id',
        'assigned_to',
        'group_id',
        'title',
        'description',
        'due_at',
        'location_latitude',
        'location_longitude',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'due_at' => 'datetime',
            'location_latitude' => 'decimal:7',
            'location_longitude' => 'decimal:7',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Event\Infrastructure\Persistence\Eloquent\EventModel::class,
            'event_id',
        );
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'assigned_to',
        );
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\EventStaffingGroup\Infrastructure\Persistence\Eloquent\EventStaffingGroupModel::class,
            'group_id',
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'created_by',
        );
    }
}
