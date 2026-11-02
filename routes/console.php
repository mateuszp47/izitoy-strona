<?php
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
Artisan::command('admin:create {email} {--name=Administrator}', function () {
 $email=$this->argument('email');
 if (!filter_var($email,FILTER_VALIDATE_EMAIL)) { $this->error('Nieprawidłowy e-mail.'); return 1; }
 $password=$this->secret('Hasło (minimum 12 znaków)');
 if (strlen($password ?? '')<12) {$this->error('Hasło musi mieć minimum 12 znaków.');return 1;}
 User::updateOrCreate(['email'=>$email],['name'=>$this->option('name'),'password'=>$password,'is_admin'=>true]);
 $this->info('Konto administratora gotowe. Panel: /admin');
})->purpose('Utwórz administratora lub bezpiecznie zmień jego hasło');
