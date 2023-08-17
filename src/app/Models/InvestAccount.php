<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $id
 * @property $user_id
 * @property $alias
 * @property $created_at
 * @property $updated_at
 */
class InvestAccount extends Model
{
    const ID = 'id';

    const USER_ID = 'user_id';

    const ALIAS = 'alias';

    protected $table = 'invest_account';

    protected $fillable = [
        'user_id',
        'alias'
    ];

}
