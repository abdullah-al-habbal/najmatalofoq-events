<?php
// modules/IAM/Infrastructure/Persistence/Eloquent/UserModel.php
declare(strict_types=1);

namespace Modules\IAM\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laravel\Sanctum\HasApiTokens;

final class UserModel extends Model
{
    use HasApiTokens, HasUuids;

    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            RoleModel::class,
            'role_user',
            'user_id',
            'role_id',
            'id',
            'id'
        );
    }
}
