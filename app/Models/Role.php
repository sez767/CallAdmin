<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var int
     */
    const ADMIN_CODE = 888;
    const REGULAR_CODE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
    ];


    /**
     * scopes
     */

    public function scopeRegular($query)
    {
    	return $query->where('code', self::REGULAR_CODE);
    }

    public function scopeAdmin($query)
    {
    	return $query->where('code', self::ADMIN_CODE);
    }

    /**
     * helpers
     */
    public static function constantRoles()
    {
        return [
            'admin' => Role::ADMIN_CODE,
            'regular' => Role::REGULAR_CODE,
        ];
    }
    
    public static function constantRoleWarning()
    {
        return ['constantRoleWarning' => 'Основные роли нельзя удалять и редактировать'];
    }

    /**
     * provides with role by type
     * @param string $code
     * @return object Role role
     */
    public static function roleByCode($code)
    {
        switch ($code) {
            case Role::ADMIN_CODE:
                return self::admin()->first();
            case Role::REGULAR_CODE:
                return self::regular()->first();
            default:
                return null;
        }
    }
}
