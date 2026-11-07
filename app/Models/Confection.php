<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Confection extends Model {
    public $timestamps = false;
    protected $fillable = ['cname','type','prizewinning'];
    protected function casts(): array {return ['prizewinning'=>'integer'];}
    public function prices(){ return $this->hasMany(Price::class,'confid'); }
    public function contents(){ return $this->hasMany(Content::class,'confid'); }
}
