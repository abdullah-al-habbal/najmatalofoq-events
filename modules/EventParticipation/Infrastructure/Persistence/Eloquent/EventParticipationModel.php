<?php
// modules/EventParticipation/Infrastructure/Persistence/Eloquent/EventParticipationModel.php
declare(strict_types=1);

namespace Modules\EventParticipation\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EventParticipationModel extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'event_participations';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'event_id',
        'position_id',
        'group_id',
        'employee_number',
        'status',
        'started_at',
        'ended_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'ended_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'user_id',
        );
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Event\Infrastructure\Persistence\Eloquent\EventModel::class,
            'event_id',
        );
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\EventStaffingPosition\Infrastructure\Persistence\Eloquent\EventStaffingPositionModel::class,
            'position_id',
        );
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\EventStaffingGroup\Infrastructure\Persistence\Eloquent\EventStaffingGroupModel::class,
            'group_id',
        );
    }

    public function contract(): HasOne
    {
        return $this->hasOne(
            \Modules\EventContract\Infrastructure\Persistence\Eloquent\EventContractModel::class,
            'event_participation_id',
        );
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(
            \Modules\EventAttendance\Infrastructure\Persistence\Eloquent\EventAttendanceModel::class,
            'event_participation_id',
        );
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(
            \Modules\ParticipationEvaluation\Infrastructure\Persistence\Eloquent\ParticipationEvaluationModel::class,
            'event_participation_id',
        );
    }

    public function violations(): HasMany
    {
        return $this->hasMany(
            \Modules\ParticipationViolation\Infrastructure\Persistence\Eloquent\ParticipationViolationModel::class,
            'event_participation_id',
        );
    }

    public function badge(): HasOne
    {
        return $this->hasOne(
            \Modules\EventParticipationBadge\Infrastructure\Persistence\Eloquent\EventParticipationBadgeModel::class,
            'event_participation_id',
        );
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(
            \Modules\EventExperienceCertificate\Infrastructure\Persistence\Eloquent\EventExperienceCertificateModel::class,
            'event_participation_id',
        );
    }
}
