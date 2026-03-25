<?php
// modules/EventPositionApplication/Infrastructure/Persistence/Eloquent/EventPositionApplicationModel.php
declare(strict_types=1);

namespace Modules\EventPositionApplication\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class EventPositionApplicationModel extends Model
{
    use HasUuids;

    protected $table = 'event_position_applications';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'position_id',
        'status',
        'ranking_score',
        'applied_at',
        'reviewed_at',
        'reviewed_by',
    ];

    protected function casts(): array
    {
        return [
            'ranking_score' => 'decimal:2',
            'applied_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'user_id',
        );
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\EventStaffingPosition\Infrastructure\Persistence\Eloquent\EventStaffingPositionModel::class,
            'position_id',
        );
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'reviewed_by',
        );
    }
}
