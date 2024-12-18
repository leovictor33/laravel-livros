<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $id)
 */
class Autor extends Model
{
    use HasFactory;

    protected $table = 'tb_autor';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'str_nome',
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'tb_livro_autor', 'codigo_autor', 'codigo_livro');
    }
}

