<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'idtask';

    // La tabla no tiene created_at ni updated_at
    public $timestamps = false;

    protected $fillable = ['nombre', 'detalle', 'estatus'];
}