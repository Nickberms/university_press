<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $table = 'authors';
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
    ];
    public function ims()
    {
        return $this->belongsToMany(Im::class, 'im_authors');
    }
}