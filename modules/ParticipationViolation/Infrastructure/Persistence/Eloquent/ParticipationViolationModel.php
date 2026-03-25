<?php
// modules/ParticipationViolation/Infrastructure/Persistence/Eloquent/ParticipationViolationModel.php
declare(strict_types=1);

namespace Modules\ParticipationViolation\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ParticipationViolationModel extends Model
{
    use HasUuids;

    protected $table = 'participation_violations';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'event_participation_id',
        'violation_type_id',
        'reported_by',
        'description',
        'date',
        'current_tier',
        'status',
        'deduction_amount',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'current_tier' => 'integer',
            'deduction_amount' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    public function participation(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\EventParticipation\Infrastructure\Persistence\Eloquent\EventParticipationModel::class,
            'event_participation_id',
        );
    }

    public function violationType(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\ViolationType\Infrastructure\Persistence\Eloquent\ViolationTypeModel::class,
            'violation_type_id',
        );
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'reported_by',
        );
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'approved_by',
        );
    }
}
