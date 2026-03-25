<?php
// modules/EventAttendance/Infrastructure/Persistence/Eloquent/EventAttendanceModel.php
declare(strict_types=1);

namespace Modules\EventAttendance\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class EventAttendanceModel extends Model
{
    use HasUuids;

    protected $table = 'event_attendance_records';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'event_participation_id',
        'date',
        'check_in_at',
        'check_out_at',
        'check_in_latitude',
        'check_in_longitude',
        'check_out_latitude',
        'check_out_longitude',
        'method',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in_at' => 'datetime',
            'check_out_at' => 'datetime',
            'check_in_latitude' => 'decimal:7',
            'check_in_longitude' => 'decimal:7',
            'check_out_latitude' => 'decimal:7',
            'check_out_longitude' => 'decimal:7',
        ];
    }

    public function participation(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\EventParticipation\Infrastructure\Persistence\Eloquent\EventParticipationModel::class,
            'event_participation_id',
        );
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'verified_by',
        );
    }
}
