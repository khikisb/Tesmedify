<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;
        protected $fillable = [
        'nama', 'harga_beli', 'harga_jual', 'supplier', 'jenis', 'foto',
    ];
}
