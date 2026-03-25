<?php
// modules/ViolationType/Infrastructure/Persistence/Eloquent/ViolationTypeModel.php
declare(strict_types=1);

namespace Modules\ViolationType\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class ViolationTypeModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'violation_types';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'default_deduction',
        'severity',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'default_deduction' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function violations(): HasMany
    {
        return $this->hasMany(
            \Modules\ParticipationViolation\Infrastructure\Persistence\Eloquent\ParticipationViolationModel::class,
            'violation_type_id',
        );
    }
}
