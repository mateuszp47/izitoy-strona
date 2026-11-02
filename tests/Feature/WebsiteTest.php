<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\{Product,User,Inquiry,Setting};
use Illuminate\Support\Facades\{Mail,Storage};
use Illuminate\Http\UploadedFile;
class WebsiteTest extends TestCase {
 private function data(): array {return ['name'=>'Klient testowy','email'=>'test@example.com','quantity'=>2,'product_id'=>Product::first()->id,'message'=>'Proszę o wycenę dostawy dwóch kabin.','privacy'=>1,'website'=>''];}
 private function admin(): User {return User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>'test-password-long','is_admin'=>true]);}
 public function test_public_pages_and_seo(): void {
  $this->get('/')->assertOk()->assertSee('3 500 zł')->assertSee('toaleta-przenosna-szary');
  foreach(Product::all() as $p)$this->get('/toalety/'.$p->slug)->assertOk()->assertSee('application/ld+json')->assertSee('selected',false);
  $this->get('/polityka-prywatnosci')->assertOk();$this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type','application/xml');$this->get('/robots.txt')->assertOk()->assertSee('Disallow: /admin');
 }
 public function test_contact_persists_without_smtp(): void {
  $this->post('/kontakt',$this->data())->assertRedirect()->assertSessionHas('success');
  $this->assertDatabaseHas('inquiries',['email'=>'test@example.com','quantity'=>2,'notification_status'=>'panel_only']);
 }
 public function test_contact_validation_and_honeypot(): void {
  $this->post('/kontakt',array_replace($this->data(),['privacy'=>0,'email'=>'bad','quantity'=>0,'website'=>'spam']))->assertSessionHasErrors(['privacy','email','quantity','website']);
  $this->assertDatabaseCount('inquiries',0);
 }
 public function test_hidden_product_cannot_be_requested_or_opened(): void {
  $p=Product::first();$p->update(['active'=>false]);
  $this->get('/toalety/'.$p->slug)->assertNotFound();
  $this->post('/kontakt',$this->data())->assertStatus(422);$this->assertDatabaseCount('inquiries',0);
 }
 public function test_admin_routes_are_protected(): void {
  $this->get('/admin')->assertRedirect('/admin/login');
  $user=User::create(['name'=>'User','email'=>'user@example.com','password'=>'test-password-long','is_admin'=>false]);
  $this->actingAs($user)->get('/admin')->assertForbidden();
  $this->put('/admin/ustawienia',['email'=>'hacker@example.com'])->assertForbidden();
 }
 public function test_login_rejects_non_admin_and_accepts_admin(): void {
  User::create(['name'=>'User','email'=>'user@example.com','password'=>'test-password-long','is_admin'=>false]);
  $this->post('/admin/login',['email'=>'user@example.com','password'=>'test-password-long'])->assertSessionHasErrors('email');
  $admin=$this->admin();$this->post('/admin/login',['email'=>$admin->email,'password'=>'test-password-long'])->assertRedirect('/admin');
  $this->get('/admin')->assertOk()->assertSee('Dane sprzedawcy');
 }
 public function test_admin_updates_product_uploads_and_hides_it(): void {
  Storage::fake('public');$this->actingAs($this->admin());$p=Product::first();
  $this->put('/admin/produkty/'.$p->slug,['name'=>'Nowa nazwa','price_gross'=>'3699.99','description'=>'Profesjonalny opis produktu.','image'=>UploadedFile::fake()->image('kabina.jpg'),'gallery'=>[UploadedFile::fake()->image('wnetrze.png')]])->assertSessionHasNoErrors()->assertRedirect();
  $p->refresh();$this->assertFalse($p->active);$this->assertEquals('3699.99',$p->price_gross);$this->assertEquals('3 699,99',$p->formatted_price);Storage::disk('public')->assertExists($p->image);$this->assertCount(4,$p->gallery);
  $this->get('/admin/produkty/'.$p->slug)->assertOk();
 }
 public function test_email_failure_does_not_lose_inquiry(): void {
  config(['mail.default'=>'smtp']);Setting::create(['key'=>'email','value'=>'sales@example.com']);
  Mail::shouldReceive('raw')->once()->andThrow(new \RuntimeException('SMTP down'));
  $this->post('/kontakt',$this->data())->assertSessionHas('success');$this->assertDatabaseHas('inquiries',['notification_status'=>'panel_only']);
 }
 public function test_admin_can_process_and_delete_inquiry(): void {
  $this->post('/kontakt',$this->data());$inquiry=Inquiry::first();$this->actingAs($this->admin());
  $this->patch('/admin/zapytania/'.$inquiry->id,['status'=>'in_progress'])->assertRedirect();$this->assertDatabaseHas('inquiries',['status'=>'in_progress']);
  $this->delete('/admin/zapytania/'.$inquiry->id)->assertRedirect();$this->assertDatabaseCount('inquiries',0);
 }
 public function test_seed_is_safe_to_repeat(): void {
  Product::first()->update(['price_gross'=>3999]);$this->seed();$this->assertDatabaseCount('products',2);$this->assertEquals('3999.00',Product::first()->price_gross);
 }
}
