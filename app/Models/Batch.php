<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;
    protected $table = 'batches';
    protected $fillable = [
        'im_id',
        'name',
        'production_date',
        'production_cost',
        'price',
        'beginning_quantity',
        'available_stocks',
    ];
    public function im()
    {
        return $this->belongsTo(IM::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}