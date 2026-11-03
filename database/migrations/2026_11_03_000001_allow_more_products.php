<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema,DB};
return new class extends Migration {
 public function up(): void {
  Schema::table('products',function(Blueprint $t){
   $t->dropUnique('products_color_unique');
   $t->json('specifications')->nullable();
   $t->text('equipment')->nullable();
  });
  DB::table('products')->whereIn('slug',['toaleta-przenosna-niebieski','toaleta-przenosna-szary'])->update([
   'specifications'=>json_encode(['height'=>'2220 mm','width'=>'1100 mm','depth'=>'1200 mm','weight'=>'77,5 kg','capacity'=>'250 l','material'=>'Polietylen odporny na UV']),
   'equipment'=>'Pisuar, plastikowa paleta, półprzezroczysty dach, samozamykające się drzwi, wskaźnik zajętości i zamknięcie od zewnątrz.',
  ]);
 }
 public function down(): void {
  if(DB::table('products')->select('color')->groupBy('color')->havingRaw('COUNT(*) > 1')->exists())
   throw new RuntimeException('Nie można przywrócić unikalności kolorów: więcej niż jeden produkt ma ten sam kolor.');
  Schema::table('products',function(Blueprint $t){$t->dropColumn(['specifications','equipment']);$t->unique('color');});
 }
};
