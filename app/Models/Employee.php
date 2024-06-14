<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
      'first_name',
      'last_name',
      'email',
      'phone',
      'post',
      'avatar',
    ];

    public $appends = [
        'name'
    ];

    public function getNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }
    public function getAvatarAttribute(){
        return Storage::url($this->attributes['avatar']);
    }

    public static function findAndExtract($id)
    {
        if ($data = self::find($id)) {
            return $data->only(array_merge(['id'], (new self)->getFillable()));
        }

        return null;
    }
}
