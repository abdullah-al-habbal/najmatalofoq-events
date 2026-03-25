<?php
// modules/EventOperationalReport/Infrastructure/Persistence/Eloquent/EventOperationalReportModel.php
declare(strict_types=1);

namespace Modules\EventOperationalReport\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

final class EventOperationalReportModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'event_operational_reports';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['title', 'content'];

    protected $fillable = [
        'event_id',
        'report_type_id',
        'author_id',
        'title',
        'content',
        'date',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'content' => 'array',
            'date' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Event\Infrastructure\Persistence\Eloquent\EventModel::class,
            'event_id',
        );
    }

    public function reportType(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\ReportType\Infrastructure\Persistence\Eloquent\ReportTypeModel::class,
            'report_type_id',
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'author_id',
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
