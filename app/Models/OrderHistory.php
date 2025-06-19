<?php
// app/Models/OrderHistory.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = ['order_id', 'action', 'notes'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}