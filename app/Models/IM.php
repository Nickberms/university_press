<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IM extends Model
{
    use HasFactory;
    protected $table = 'ims';
    protected $fillable = [
        'code',
        'title',
        'category_id',
        'college',
        'publisher',
        'edition',
        'isbn',
        'description',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'im_authors', 'im_id', 'author_id');
    }
    public function batches()
    {
        return $this->hasMany(Batch::class, 'im_id');
    }
    public function purchases()
    {
        return $this->hasManyThrough(Purchase::class, Batch::class);
    }
    public function adjustment_logs()
    {
        return $this->hasManyThrough(AdjustmentLog::class, Batch::class);
    }
}