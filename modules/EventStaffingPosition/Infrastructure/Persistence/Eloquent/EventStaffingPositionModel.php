<?php
// modules/EventStaffingPosition/Infrastructure/Persistence/Eloquent/EventStaffingPositionModel.php
declare(strict_types=1);

namespace Modules\EventStaffingPosition\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class EventStaffingPositionModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'event_staffing_positions';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['title', 'requirements'];

    protected $fillable = [
        'event_id',
        'title',
        'wage_amount',
        'wage_type',
        'headcount',
        'requirements',
        'is_announced',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'requirements' => 'array',
            'wage_amount' => 'decimal:2',
            'headcount' => 'integer',
            'is_announced' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Event\Infrastructure\Persistence\Eloquent\EventModel::class,
            'event_id',
        );
    }

    public function applications(): HasMany
    {
        return $this->hasMany(
            \Modules\EventPositionApplication\Infrastructure\Persistence\Eloquent\EventPositionApplicationModel::class,
            'position_id',
        );
    }

    public function participations(): HasMany
    {
        return $this->hasMany(
            \Modules\EventParticipation\Infrastructure\Persistence\Eloquent\EventParticipationModel::class,
            'position_id',
        );
    }
}
