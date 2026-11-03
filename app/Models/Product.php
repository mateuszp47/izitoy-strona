<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
 protected $guarded = ['id'];
 protected function casts(): array {return ['active'=>'boolean','gallery'=>'array','specifications'=>'array','price_gross'=>'decimal:2'];}
 public function getRouteKeyName(): string {return 'slug';}
 public function getImageUrlAttribute(): string {return str_starts_with($this->image ?? '', 'products/') ? asset('storage/'.$this->image) : asset($this->image ?: 'assets/toalety.webp');}
 public function getFormattedPriceAttribute(): string {return number_format((float)$this->price_gross, round((float)$this->price_gross,2) == round((float)$this->price_gross) ? 0 : 2, ',', ' ');}
}
