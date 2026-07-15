<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{
 protected $fillable = [
 'event_id', 'order_id', 'customer_name', 'customer_email',
'customer_phone', 'total_price', 'status', 'snap_token'
 ];
 public function event()
 {
 return $this->belongsTo(Event::class);
 }

 public function markAsSuccess()
 {
 // Prevent duplicate processing if already processed
 if (in_array(strtolower($this->status), ['success', 'settlement'])) {
 return false;
 }

 $this->status = 'success';
 $this->save();

 $event = $this->event;
 if ($event && $event->stock > 0) {
 $event->stock = $event->stock - 1;
 $event->save();

 try {
 \Illuminate\Support\Facades\Mail::to($this->customer_email)
 ->send(new \App\Mail\EventTicketMail($this));
 } catch (\Exception $e) {
 \Illuminate\Support\Facades\Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
 }
 }

 return true;
 }
}