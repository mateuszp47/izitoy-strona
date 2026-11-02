<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
 protected $guarded = ['id'];
 public static function values(): array {
  return array_replace([
   'email'=>config('izitoy.email'), 'phone'=>config('izitoy.phone'),
   'company'=>config('izitoy.company'), 'address'=>config('izitoy.address'), 'nip'=>config('izitoy.nip'),
   'delivery'=>'Koszt transportu i termin realizacji ustalamy indywidualnie — podaj miejscowość dostawy w zapytaniu.',
  ], self::pluck('value','key')->all());
 }
}
