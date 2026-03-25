<?php
// modules/User/Infrastructure/Persistence/Eloquent/UserModel.php
declare(strict_types=1);

namespace Modules\User\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Translatable\HasTranslations;

final class UserModel extends Model
{
    use HasApiTokens, HasUuids, HasTranslations, SoftDeletes;

    protected $table = 'users';

    protected $keyType = 'string';

    public $incrementing = false;

    public array $translatable = ['name'];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'national_id',
        'password',
        'avatar',
        'is_active',
        'phone_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'is_active' => 'boolean',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function participations(): HasMany
    {
        return $this->hasMany(
            \Modules\EventParticipation\Infrastructure\Persistence\Eloquent\EventParticipationModel::class,
            'user_id',
        );
    }

    public function applications(): HasMany
    {
        return $this->hasMany(
            \Modules\EventPositionApplication\Infrastructure\Persistence\Eloquent\EventPositionApplicationModel::class,
            'user_id',
        );
    }

    public function roleAssignments(): HasMany
    {
        return $this->hasMany(
            \Modules\EventRoleAssignment\Infrastructure\Persistence\Eloquent\EventRoleAssignmentModel::class,
            'user_id',
        );
    }
}
