<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 */
class Livro extends Model
{
    use HasFactory;

    protected $table = 'tb_livro';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'str_titulo',
        'str_editora',
        'num_edicao',
        'num_ano_publicacao',
        'num_valor'
    ];

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'tb_livro_autor', 'codigo_livro', 'codigo_autor');
    }

    public function assuntos()
    {
        return $this->belongsToMany(Assunto::class, 'tb_livro_assunto', 'codigo_livro', 'codigo_assunto');
    }
}
