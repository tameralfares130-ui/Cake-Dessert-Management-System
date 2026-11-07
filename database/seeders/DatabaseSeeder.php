<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  foreach(['confections','contents','prices'] as $table){
    $file=database_path('data/'.$table.'.tsv');
    if(!is_readable($file))throw new \RuntimeException('Missing data file: '.$file);
    $handle=fopen($file,'r');
    $header=explode("\t",trim((string)fgets($handle)));
    $batch=[];
    while(($line=fgets($handle))!==false){
      $values=explode("\t",rtrim($line,"\r\n"));
      if(count($values)!==count($header))throw new \RuntimeException('Bad TSV row in '.$file);
      $record=array_combine($header,$values);
      foreach(['id','confid','price','prizewinning'] as $key)if(isset($record[$key]))$record[$key]=(int)$record[$key];
      $batch[]=$record;
    }
    fclose($handle);
    foreach(array_chunk($batch,100) as $chunk){DB::table($table)->upsert($chunk,['id'],array_values(array_diff($header,['id'])));}
  }
  $email=trim((string)env('ADMIN_EMAIL',''));
  $password=(string)env('ADMIN_PASSWORD','');
  if($email!=='' && $password!==''){
    if(strlen($password)<12)throw new \RuntimeException('ADMIN_PASSWORD must be at least 12 characters.');
    User::updateOrCreate(['email'=>$email],['name'=>env('ADMIN_NAME','Site Administrator'),'password'=>Hash::make($password),'role'=>'admin']);
  }
 }
}
