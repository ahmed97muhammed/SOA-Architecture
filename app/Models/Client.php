<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends ModelParent
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_1',
        'phone_2',
        'email',
        'country_id',
        'address',
        'status',
        'opening_balance',
        'branch_id',
        'create_id',
        'update_id',
        'delete_id',
    ];

    /***
     * @return array
     */
    public function selectedColumns(): array
    {
        return array_merge(['id'],$this->fillable);
    }

    public function transactions()
    {
        return $this->morphMany(AccountantTransaction::class, 'transactionable');
    }
}
