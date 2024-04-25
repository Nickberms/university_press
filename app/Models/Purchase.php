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
        'or_number',
        'im_id',
        'batch_id',
        'date_sold',
        'quantity',
    ];
    public function im()
    {
        return $this->belongsTo(Im::class);
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}