<?php
namespace Tests\Feature;

use App\Models\{Product,User};
use App\Support\ProductDescription;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\{DB,Storage};
use Tests\TestCase;

class ProductEditingTest extends TestCase
{
 private function admin(): User {return User::create(['name'=>'Admin','email'=>'editor@example.com','password'=>'long-test-password','is_admin'=>true]);}
 private function data(): array {return ['name'=>'Model Zielony','color'=>'  Ciemny zielony / RAL 6005  ','price_gross'=>'4200.50','description'=>'<h2>Solidna kabina</h2><div><strong>Wyposażenie</strong> i <em>wygoda</em></div><ul><li>Pisuar</li><li>Zbiornik</li></ul><ol><li>Wybierz</li><li>Zamów</li></ol><div><a href="https://example.com/oferta">Szczegóły</a></div>','active'=>1];}

 public function test_admin_creates_custom_color_with_rich_description(): void {
  Storage::fake('public');$this->actingAs($this->admin());
  $this->get('/admin/produkty/nowy')->assertOk()->assertSee('<trix-editor',false)->assertSee('product-colors');
  $this->post('/admin/produkty',$this->data()+['image'=>UploadedFile::fake()->image('green.jpg')])->assertSessionHasNoErrors()->assertRedirect();
  $product=Product::where('slug','model-zielony')->firstOrFail();
  $this->assertSame('ciemny zielony / ral 6005',$product->color);
  $this->assertStringContainsString('<strong>Wyposażenie</strong>',$product->description);
  $page=$this->get('/toalety/'.$product->slug)->assertOk()->assertSee('<h2>Solidna kabina</h2>',false)->assertSee('<ul><li>Pisuar</li>',false)->assertSee('<ol><li>Wybierz</li>',false)->assertSee('href="https://example.com/oferta"',false);
  preg_match('~<script type="application/ld\\+json">(.*?)</script>~s',$page->getContent(),$match);
  $schema=json_decode($match[1],true,512,JSON_THROW_ON_ERROR);
  $this->assertStringNotContainsString('<strong>',$schema['description']);
  $this->get('/admin/produkty/'.$product->slug)->assertOk()->assertSee('ciemny zielony / ral 6005')->assertSee('&lt;strong&gt;Wyposażenie&lt;/strong&gt;',false);
  $this->get('/')->assertOk()->assertSee('CIEMNY ZIELONY / RAL 6005')->assertDontSee('wyłącznie dwa warianty');
 }

 public function test_update_sanitizes_html_and_keeps_allowed_formatting(): void {
  $this->actingAs($this->admin());$p=Product::first();
  $data=$this->data();$data['color']='Zielony';
  $data['description']='<h1 onclick="alert(1)">Nagłówek</h1><p><strong>Ważne</strong><script>alert(1)</script><img src="x" onerror="alert(2)"><a href="javascript:alert(3)" onclick="alert(4)">Niebezpieczny</a><a href="https://example.com">Bezpieczny</a></p>';
  $this->put('/admin/produkty/'.$p->slug,$data)->assertSessionHasNoErrors();$p->refresh();
  $this->assertSame('zielony',$p->color);
  $this->assertStringContainsString('<h2>Nagłówek</h2>',$p->description);
  $this->assertStringContainsString('<strong>Ważne</strong>',$p->description);
  foreach(['<script','<img','onclick','onerror','javascript:'] as $unsafe)$this->assertStringNotContainsString($unsafe,$p->description);
  $this->get('/toalety/'.$p->slug)->assertOk()->assertSee('<strong>Ważne</strong>',false)->assertDontSee('javascript:',false);
 }

 public function test_legacy_plain_text_and_unsafe_database_html_render_safely(): void {
  $p=Product::first();DB::table('products')->where('id',$p->id)->update(['description'=>"Linia pierwsza\nLinia druga & więcej. 2 < 3"]);
  $this->get('/toalety/'.$p->slug)->assertOk()->assertSee('Linia pierwsza<br',false)->assertSee('Linia druga &amp; więcej. 2 &lt; 3',false);
  DB::table('products')->where('id',$p->id)->update(['description'=>'<p>Opis <em>formatowany</em></p><svg onload="alert(9)"></svg><script>alert(8)</script>']);
  $this->get('/toalety/'.$p->slug)->assertOk()->assertSee('<em>formatowany</em>',false)->assertDontSee('onload=',false)->assertDontSee('alert(8)',false);
 }

 public function test_empty_formatted_description_is_rejected(): void {
  $this->actingAs($this->admin());$p=Product::first();
  $this->put('/admin/produkty/'.$p->slug,array_replace($this->data(),['description'=>'<div><br></div>']))->assertSessionHasErrors('description');
 }

 public function test_color_may_be_custom_but_must_be_short_text(): void {
  $this->actingAs($this->admin());$p=Product::first();
  $this->put('/admin/produkty/'.$p->slug,array_replace($this->data(),['color'=>str_repeat('a',61)]))->assertSessionHasErrors('color');
  $this->put('/admin/produkty/'.$p->slug,array_replace($this->data(),['color'=>'beżowy']))->assertSessionHasNoErrors();
  $this->assertSame('#c7b394',$p->fresh()->color_hex);
 }
}
