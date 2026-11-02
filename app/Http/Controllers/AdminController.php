<?php
namespace App\Http\Controllers;
use App\Models\{Product,Inquiry,Setting};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Storage};
class AdminController {
 public function login(Request $r) {
  $data=$r->validate(['email'=>'required|email','password'=>'required|string']);
  if(!Auth::attempt($data+['is_admin'=>true]))return back()->withErrors(['email'=>'Nieprawidłowy e-mail lub hasło.'])->onlyInput('email');
  $r->session()->regenerate();return redirect('/admin');
 }
 public function logout(Request $r) {Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect('/admin/login');}
 public function index() {return view('admin.dashboard',['products'=>Product::all(),'inquiries'=>Inquiry::with('product')->latest()->paginate(20),'newCount'=>Inquiry::where('status','new')->count()]);}
 public function edit(Product $product) {return view('admin.product',compact('product'));}
 public function update(Request $r,Product $product) {
  $data=$r->validate(['name'=>'required|string|max:150','price_gross'=>'required|numeric|min:0|max:999999.99','description'=>'required|string|max:12000','image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:8192','remove_gallery'=>'nullable|array','remove_gallery.*'=>'string|max:300','gallery'=>'nullable|array|max:8','gallery.*'=>'image|mimes:jpg,jpeg,png,webp|max:8192']);
  unset($data['image'],$data['gallery'],$data['remove_gallery']);$data['active']=$r->boolean('active');
  $gallery=$product->gallery ?? [];
  $remove=$r->input('remove_gallery',[]);
  if(is_array($remove)) $gallery=array_values(array_diff($gallery,$remove));
  if(count($gallery)+count($r->file('gallery',[]))>8)return back()->withErrors(['gallery'=>'Galeria może zawierać maksymalnie 8 zdjęć.']);
  if($r->hasFile('image')) $data['image']=$r->file('image')->store('products','public');
  foreach($r->file('gallery',[]) as $file)$gallery[]=$file->store('products','public');
  $data['gallery']=$gallery;$product->update($data);return back()->with('success','Produkt zapisany.');
 }
 public function inquiry(Request $r,Inquiry $inquiry) {
  $data=$r->validate(['status'=>'required|in:new,in_progress,closed']);$inquiry->update($data);return back()->with('success','Status zapytania zapisany.');
 }
 public function deleteInquiry(Inquiry $inquiry) {$inquiry->delete();return back()->with('success','Zapytanie usunięte.');}
 public function settings(Request $r) {
  $data=$r->validate(['email'=>'nullable|email|max:200','phone'=>'nullable|string|max:40','company'=>'nullable|string|max:200','address'=>'nullable|string|max:500','nip'=>'nullable|string|max:30','delivery'=>'required|string|max:2000']);
  foreach($data as $key=>$value) Setting::updateOrCreate(['key'=>$key],['value'=>$value ?? '']);
  return back()->with('success','Ustawienia zapisane.');
 }
}
