<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  foreach (['niebieski'=>'Niebieska','szary'=>'Szara'] as $color=>$label) {
   Product::firstOrCreate(['color'=>$color],[
    'name'=>'Toaleta przenośna '.$label, 'slug'=>'toaleta-przenosna-'.$color,
    'price_gross'=>3500, 'image'=>'assets/toaleta-'.$color.'.webp',
    'gallery'=>['assets/'.$color.'-wnetrze.webp','assets/'.$color.'-detal.webp','assets/'.$color.'-otwarta.webp'],
    'description'=>'Praktyczne zaplecze sanitarne na budowę, działkę i wydarzenia plenerowe. Kabina z polietylenu odpornego na promieniowanie UV łączy solidną konstrukcję z wygodną obsługą. Wzmocniony przód oraz obwodowa rama drzwi zwiększają stabilność podczas codziennego użytkowania. Gładkie ściany ułatwiają czyszczenie i pozwalają umieścić oznakowanie firmy. W standardzie otrzymujesz zbiornik 250 l, pisuar, plastikową paletę oraz półprzezroczysty dach. Samozamykające się drzwi mają wskaźnik zajętości i możliwość zamknięcia od zewnątrz. Produkt nowy. Wystawiamy fakturę VAT.',
   ]);
  }
 }
}
