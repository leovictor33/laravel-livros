<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    use HasFactory;

    protected $table = 'tb_assunto';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'str_descricao',
    ];

    public function livros()
    {
        return $this->belongsToMany(Livro::class, 'tb_livro_assunto', 'codigo_assunto', 'codigo_livro');
    }
}
