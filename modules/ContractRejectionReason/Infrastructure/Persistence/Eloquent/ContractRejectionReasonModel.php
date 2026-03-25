<?php
// modules/ContractRejectionReason/Infrastructure/Persistence/Eloquent/ContractRejectionReasonModel.php
declare(strict_types=1);

namespace Modules\ContractRejectionReason\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class ContractRejectionReasonModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'contract_rejection_reasons';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['reason'];

    protected $fillable = [
        'reason',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'reason' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(
            \Modules\EventContract\Infrastructure\Persistence\Eloquent\EventContractModel::class,
            'rejection_reason_id',
        );
    }
}
