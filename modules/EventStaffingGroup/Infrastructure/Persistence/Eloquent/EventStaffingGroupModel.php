<?php
// modules/EventStaffingGroup/Infrastructure/Persistence/Eloquent/EventStaffingGroupModel.php
declare(strict_types=1);

namespace Modules\EventStaffingGroup\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class EventStaffingGroupModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'event_staffing_groups';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['name'];

    protected $fillable = [
        'event_id',
        'name',
        'color',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'is_locked' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Event\Infrastructure\Persistence\Eloquent\EventModel::class,
            'event_id',
        );
    }

    public function participations(): HasMany
    {
        return $this->hasMany(
            \Modules\EventParticipation\Infrastructure\Persistence\Eloquent\EventParticipationModel::class,
            'group_id',
        );
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(
            \Modules\EventTask\Infrastructure\Persistence\Eloquent\EventTaskModel::class,
            'group_id',
        );
    }
}
