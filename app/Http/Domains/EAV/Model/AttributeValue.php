<?php
namespace App\Http\Domains\EAV\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'entity_id',
        'entity_type',
        'value',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function entity()
    {
        return $this->morphTo();
    }
}
