<?php
namespace App\Http\Domains\EAV\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'options',
    ];

    protected $casts = [
        'type' => AttributeTypeEnum::class,
        'options' => 'array',
    ];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
