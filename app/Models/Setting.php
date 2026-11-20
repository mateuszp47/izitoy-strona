<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
 protected $guarded = ['id'];
 public static function values(): array {
  $values = array_replace([
   'email'=>config('izitoy.email'), 'phone'=>config('izitoy.phone'),
   'company'=>config('izitoy.company'), 'address'=>config('izitoy.address'), 'nip'=>config('izitoy.nip'),
   'delivery'=>'Koszt transportu i termin realizacji ustalamy indywidualnie — podaj miejscowość dostawy w zapytaniu.',
  ], self::pluck('value','key')->all());
  if (trim((string)($values['phone'] ?? '')) === '') $values['phone'] = config('izitoy.phone') ?: '+48 600 042 660';
  $digits = preg_replace('/\D/', '', (string)$values['phone']);
  if (in_array($digits, ['600042660', '48600042660'], true)) $values['phone'] = '+48 600 042 660';
  return $values;
 }
}
