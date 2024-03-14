<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable = [
        'customer_name',
        'im_id',
        'batch_id',
        'quantity',
        'date_sold',
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