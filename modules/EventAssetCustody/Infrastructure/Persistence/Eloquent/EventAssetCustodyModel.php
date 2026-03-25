<?php
// modules/EventAssetCustody/Infrastructure/Persistence/Eloquent/EventAssetCustodyModel.php
declare(strict_types=1);

namespace Modules\EventAssetCustody\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

final class EventAssetCustodyModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'event_asset_custodies';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['item_name', 'description'];

    protected $fillable = [
        'event_id',
        'event_participation_id',
        'item_name',
        'description',
        'handed_at',
        'returned_at',
        'status',
        'handed_by',
    ];

    protected function casts(): array
    {
        return [
            'item_name' => 'array',
            'description' => 'array',
            'handed_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\Event\Infrastructure\Persistence\Eloquent\EventModel::class,
            'event_id',
        );
    }

    public function participation(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\EventParticipation\Infrastructure\Persistence\Eloquent\EventParticipationModel::class,
            'event_participation_id',
        );
    }

    public function handedByUser(): BelongsTo
    {
        return $this->belongsTo(
            \Modules\User\Infrastructure\Persistence\Eloquent\UserModel::class,
            'handed_by',
        );
    }
}
