<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Content extends Model {
    public $timestamps = false;
    protected $fillable=['confid','free'];
    public function confection(){return $this->belongsTo(Confection::class,'confid');}
}
