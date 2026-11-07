<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Price extends Model {
    public $timestamps = false;
    protected $fillable=['confid','price','unit'];
    public function confection(){return $this->belongsTo(Confection::class,'confid');}
}
