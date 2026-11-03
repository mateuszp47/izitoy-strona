<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  foreach (['niebieski'=>'Niebieska','szary'=>'Szara'] as $color=>$label) {
   Product::firstOrCreate(['slug'=>'toaleta-przenosna-'.$color],[
    'name'=>'Toaleta przenośna '.$label, 'slug'=>'toaleta-przenosna-'.$color,
    'color'=>$color, 'price_gross'=>3500, 'image'=>$color==='szary'?'assets/toaleta-szary-white.webp':'assets/toaleta-niebieski.webp',
    'specifications'=>['height'=>'2220 mm','width'=>'1100 mm','depth'=>'1200 mm','weight'=>'77,5 kg','capacity'=>'250 l','material'=>'Polietylen odporny na UV'],
    'equipment'=>'Pisuar, plastikowa paleta, półprzezroczysty dach, samozamykające się drzwi, wskaźnik zajętości i zamknięcie od zewnątrz.',
    'gallery'=>$color==='szary'?['assets/szary-wnetrze-white.webp','assets/szary-detal-white.webp','assets/szary-otwarta-white.webp']:['assets/niebieski-wnetrze.webp','assets/niebieski-detal.webp','assets/niebieski-otwarta.webp'],
    'description'=>'Praktyczne zaplecze sanitarne na budowę, działkę i wydarzenia plenerowe. Kabina z polietylenu odpornego na promieniowanie UV łączy solidną konstrukcję z wygodną obsługą. Wzmocniony przód oraz obwodowa rama drzwi zwiększają stabilność podczas codziennego użytkowania. Gładkie ściany ułatwiają czyszczenie i pozwalają umieścić oznakowanie firmy. W standardzie otrzymujesz zbiornik 250 l, pisuar, plastikową paletę oraz półprzezroczysty dach. Samozamykające się drzwi mają wskaźnik zajętości i możliwość zamknięcia od zewnątrz. Produkt nowy. Wystawiamy fakturę VAT.',
   ]);
  }
 }
}
