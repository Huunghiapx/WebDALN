<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sach extends Model
{
    use HasFactory;

    protected $table = 'sach';

    protected $fillable = [
        'TenSach',
        'namXuatBan',
    ];
}
