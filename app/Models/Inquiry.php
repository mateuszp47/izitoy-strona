<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Inquiry extends Model {
 protected $guarded = ['id'];
 protected function casts(): array {return ['privacy_accepted_at'=>'datetime'];}
 public function product() {return $this->belongsTo(Product::class);}
}
