<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesorio extends Producto
{
    use HasFactory;
    public function producto()
    {
        return $this->hasOne(Producto::class, 'id', 'fk_producto_id');
    }
}
