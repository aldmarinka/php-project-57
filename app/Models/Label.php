<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Label extends Model
{
    use HasFactory;

    protected $table = 'labels';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'name',
        'description'
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
