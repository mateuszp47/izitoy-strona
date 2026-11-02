<?php
namespace App\Http\Controllers;
use App\Models\{Product,Inquiry,Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class SiteController {
 public function home() {return view('site.home',['products'=>Product::where('active',true)->get()]);}
 public function product(Product $product) {abort_unless($product->active,404);return view('site.product',compact('product'));}
 public function contact(Request $request) {
  $data=$request->validate([
   'name'=>'required|string|max:120','email'=>'required|email|max:200','phone'=>'nullable|string|max:40',
   'city'=>'nullable|string|max:150','quantity'=>'required|integer|min:1|max:1000',
   'product_id'=>'nullable|exists:products,id','message'=>'required|string|min:10|max:5000',
   'privacy'=>'accepted','website'=>'nullable|size:0',
  ]);
  if(!empty($data['product_id'])) abort_unless(Product::whereKey($data['product_id'])->where('active',true)->exists(),422);
  unset($data['privacy'],$data['website']);
  $inquiry=Inquiry::create($data+['privacy_accepted_at'=>now()]);
  $email=Setting::values()['email'];
  $sent=false;
  if ($email && config('mail.default') !== 'log' && config('mail.default') !== 'array') {
   try {
    Mail::raw("Nowe zapytanie IZITOY #{$inquiry->id}\nImię: {$inquiry->name}\nE-mail: {$inquiry->email}\nTelefon: {$inquiry->phone}\nMiejscowość: {$inquiry->city}\nWariant: ".($inquiry->product?->name ?? 'Do ustalenia')."\nLiczba: {$inquiry->quantity}\n\n{$inquiry->message}",function($mail)use($email,$inquiry){$mail->to($email)->replyTo($inquiry->email,$inquiry->name)->subject('IZITOY — nowe zapytanie #'.$inquiry->id);});
    $sent=true;
   } catch(\Throwable $e) {report($e);}
  }
  $inquiry->update(['notification_status'=>$sent?'sent':'panel_only']);
  return back()->with('success','Dziękujemy! Twoje zapytanie nr '.$inquiry->id.' zostało zapisane. Skontaktujemy się z Tobą w sprawie zakupu.');
 }
}
