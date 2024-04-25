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
        'quantity_produced',
    ];
    public function im()
    {
        return $this->belongsTo(Im::class);
    }
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    public function adjustment_logs()
    {
        return $this->hasMany(AdjustmentLog::class);
    }
}