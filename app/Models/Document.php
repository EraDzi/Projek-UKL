<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'photo_path', 'upload_date'];

    // Add an accessor for the photo URL
    public function getPhotoUrlAttribute()
    {
        if ($this->photo_path) {
            return Storage::url($this->photo_path);
        }

        return null;
    }
}
