<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    protected $table = 'imagens';

    protected $fillable = [
        'imagem_id',
        'imagem_type',
        'filename',
        'url',
    ];

    public function imagemable()
    {
        return $this->morphTo();
    }
}
