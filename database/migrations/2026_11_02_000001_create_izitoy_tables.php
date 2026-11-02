<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('users', function(Blueprint $t){$t->id();$t->string('name');$t->string('email')->unique();$t->string('password');$t->boolean('is_admin')->default(false);$t->rememberToken();$t->timestamps();});
  Schema::create('products', function(Blueprint $t){$t->id();$t->string('name');$t->string('slug')->unique();$t->string('color')->unique();$t->decimal('price_gross',10,2);$t->text('description');$t->string('image')->nullable();$t->json('gallery')->nullable();$t->boolean('active')->default(true);$t->timestamps();});
  Schema::create('inquiries', function(Blueprint $t){$t->id();$t->foreignId('product_id')->nullable()->constrained()->nullOnDelete();$t->string('name');$t->string('email');$t->string('phone')->nullable();$t->string('city')->nullable();$t->unsignedInteger('quantity')->default(1);$t->text('message');$t->string('status')->default('new');$t->string('notification_status')->default('pending');$t->timestamp('privacy_accepted_at');$t->timestamps();});
  Schema::create('settings',function(Blueprint $t){$t->id();$t->string('key')->unique();$t->text('value')->nullable();$t->timestamps();});
 }
 public function down(): void {foreach(['inquiries','products','settings','users'] as $table) Schema::dropIfExists($table);}
};
