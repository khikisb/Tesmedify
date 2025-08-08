<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Menentukan field yang bisa diisi secara mass-assignment
    protected $fillable = ['nama', 'kode'];

    // Relasi many-to-many dengan MasterItem
    public function masterItems()
    {
        return $this->belongsToMany(MasterItem::class, 'category_master_item');
    }
}
