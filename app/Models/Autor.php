<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $id)
 * @method static orderBy(string $string, string $string1)
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

    /**
     * Exceção para delete de autor que possua relacionamento com algum livro
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($autor) {
            if ($autor->livros()->exists()) {
                throw new \Exception("O autor(a) '".$autor['str_nome']."' está relacionado(a) a um ou mais livros e não pode ser excluído.");
            }
        });
    }
}

