<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        static::creating(function ($file) {
            $file->uuid = Str::uuid();
        });

        static::deleted(function ($file) {
            Storage::disk('s3')->delete($file->path);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
