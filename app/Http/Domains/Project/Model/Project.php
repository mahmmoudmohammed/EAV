<?php
namespace App\Http\Domains\Project\Model;

use App\Http\Domains\EAV\Model\AttributeValue;
use App\Http\Domains\TimeSheet\Model\Timesheet;
use App\Http\Domains\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];
    protected $casts = [
        'status' => ProjectStatusEnum::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function attributeValues()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }
}
