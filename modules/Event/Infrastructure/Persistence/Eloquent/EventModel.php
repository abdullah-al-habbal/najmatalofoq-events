<?php
// modules/Event/Infrastructure/Persistence/Eloquent/EventModel.php
declare(strict_types=1);

namespace Modules\Event\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

final class EventModel extends Model
{
    use HasUuids, HasTranslations, SoftDeletes;

    protected $table = 'events';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['name', 'description', 'address', 'employment_terms'];

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'geofence_radius',
        'address',
        'start_date',
        'end_date',
        'daily_start_time',
        'daily_end_time',
        'employment_terms',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
            'address' => 'array',
            'employment_terms' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'geofence_radius' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'created_by',
        );
    }

    public function positions(): HasMany
    {
        return $this->hasMany(
            \Modules\EventStaffingPosition\Infrastructure\Persistence\Eloquent\EventStaffingPositionModel::class,
            'event_id',
        );
    }

    public function groups(): HasMany
    {
        return $this->hasMany(
            \Modules\EventStaffingGroup\Infrastructure\Persistence\Eloquent\EventStaffingGroupModel::class,
            'event_id',
        );
    }

    public function participations(): HasMany
    {
        return $this->hasMany(
            \Modules\EventParticipation\Infrastructure\Persistence\Eloquent\EventParticipationModel::class,
            'event_id',
        );
    }

    public function roleAssignments(): HasMany
    {
        return $this->hasMany(
            \Modules\EventRoleAssignment\Infrastructure\Persistence\Eloquent\EventRoleAssignmentModel::class,
            'event_id',
        );
    }

    public function capabilities(): HasMany
    {
        return $this->hasMany(
            \Modules\EventRoleCapability\Infrastructure\Persistence\Eloquent\EventRoleCapabilityModel::class,
            'event_id',
        );
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(
            \Modules\EventTask\Infrastructure\Persistence\Eloquent\EventTaskModel::class,
            'event_id',
        );
    }

    public function reports(): HasMany
    {
        return $this->hasMany(
            \Modules\EventOperationalReport\Infrastructure\Persistence\Eloquent\EventOperationalReportModel::class,
            'event_id',
        );
    }

    public function custodies(): HasMany
    {
        return $this->hasMany(
            \Modules\EventAssetCustody\Infrastructure\Persistence\Eloquent\EventAssetCustodyModel::class,
            'event_id',
        );
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(
            \Modules\EventExpense\Infrastructure\Persistence\Eloquent\EventExpenseModel::class,
            'event_id',
        );
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(
            \Modules\EventAnnouncement\Infrastructure\Persistence\Eloquent\EventAnnouncementModel::class,
            'event_id',
        );
    }
}
