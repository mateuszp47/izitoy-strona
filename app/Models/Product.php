<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
 protected $guarded = ['id'];
 protected function casts(): array {return ['active'=>'boolean','gallery'=>'array','specifications'=>'array','price_gross'=>'decimal:2'];}
 public function getRouteKeyName(): string {return 'slug';}
 public function getImageUrlAttribute(): string {return str_starts_with($this->image ?? '', 'products/') ? asset('storage/'.$this->image) : asset($this->image ?: 'assets/toalety.webp');}
 public function getFormattedPriceAttribute(): string {return number_format((float)$this->price_gross, round((float)$this->price_gross,2) == round((float)$this->price_gross) ? 0 : 2, ',', ' ');}

 public function getDescriptionHtmlAttribute(): string {return app(\App\Support\ProductDescription::class)->html((string)$this->description);}
 public function getDescriptionTextAttribute(): string {return app(\App\Support\ProductDescription::class)->plainText((string)$this->description);}
 public function setDescriptionAttribute($value): void {$this->attributes['description']=app(\App\Support\ProductDescription::class)->sanitize((string)$value);}
 public static function colorOptions(): array {return ['niebieski','szary','zielony','antracyt','czarny','biały','czerwony','żółty','pomarańczowy','brązowy','beżowy'];}
 public function getColorHexAttribute(): string {
  return ['niebieski'=>'#0876b4','szary'=>'#aaaaaa','zielony'=>'#41824b','antracyt'=>'#384047','czarny'=>'#202020','biały'=>'#ffffff','czerwony'=>'#c84242','żółty'=>'#f0ce3c','pomarańczowy'=>'#e98c31','brązowy'=>'#895e43','beżowy'=>'#c7b394'][mb_strtolower(trim($this->color))] ?? '#8c9994';
 }
}
