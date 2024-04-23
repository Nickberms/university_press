<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentLog extends Model
{
    use HasFactory;
    protected $table = 'adjustment_logs';
    protected $fillable = [
        'adjustment_cause',
        'im_id',
        'batch_id',
        'date_adjusted',
        'quantity_deducted',
    ];
    public function im()
    {
        return $this->belongsTo(IM::class);
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}