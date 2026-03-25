<?php
// modules/ReportType/Infrastructure/Persistence/Eloquent/ReportTypeModel.php
declare(strict_types=1);

namespace Modules\ReportType\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

final class ReportTypeModel extends Model
{
    use HasUuids, HasTranslations;

    protected $table = 'report_types';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['name'];

    protected $fillable = [
        'slug',
        'name',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function reports(): HasMany
    {
        return $this->hasMany(
            \Modules\EventOperationalReport\Infrastructure\Persistence\Eloquent\EventOperationalReportModel::class,
            'report_type_id',
        );
    }
}
