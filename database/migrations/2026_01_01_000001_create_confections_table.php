<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{Schema::create('confections',function(Blueprint $table){$table->id();$table->string('cname');$table->string('type');$table->integer('prizewinning')->default(0);});}
 public function down():void{Schema::dropIfExists('confections');}
};
