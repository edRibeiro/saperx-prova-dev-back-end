<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Contact",
 *     title="Contact",
 *     description="Schema para a entidade Contact",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID do contato"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nome do contato"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Endereço de e-mail do contato"
 *     ),
 *     @OA\Property(
 *         property="birth_date",
 *         type="string",
 *         format="date",
 *         description="Data de nascimento do contato (YYYY-MM-DD)"
 *     ),
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *         description="Lista de números de telefone do contato",
 *         @OA\Items(type="string")
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Data e hora de criação do contato"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Data e hora da última atualização do contato"
 *     )
 * )
 */
class Contact extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'birth_date'];

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function addPhone(string $number)
    {
        $this->phones()->create(['number' => $number]);
    }

    public function addPhones(array $numbers)
    {
        foreach ($numbers as $number) {
            $this->addPhone($number);
        }
    }
}
