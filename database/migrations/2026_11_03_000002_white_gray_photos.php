<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
 private function replace(array $map): void {
  DB::table('products')->orderBy('id')->chunkById(100,function($products)use($map){
   foreach($products as $product){
    $gallery=json_decode($product->gallery ?? '[]',true) ?: [];
    $gallery=array_map(fn($photo)=>$map[$photo] ?? $photo,$gallery);
    DB::table('products')->where('id',$product->id)->update(['image'=>$map[$product->image] ?? $product->image,'gallery'=>json_encode($gallery)]);
   }
  });
 }
 private function map(): array {return [
  'assets/toaleta-szary.webp'=>'assets/toaleta-szary-white.webp',
  'assets/szary-wnetrze.webp'=>'assets/szary-wnetrze-white.webp',
  'assets/szary-detal.webp'=>'assets/szary-detal-white.webp',
  'assets/szary-otwarta.webp'=>'assets/szary-otwarta-white.webp',
 ];}
 public function up(): void {$this->replace($this->map());}
 public function down(): void {$this->replace(array_flip($this->map()));}
};
