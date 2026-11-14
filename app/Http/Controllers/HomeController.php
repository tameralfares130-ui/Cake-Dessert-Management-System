<?php
namespace App\Http\Controllers;
use App\Models\Confection;
use App\Models\Price;
use Illuminate\Http\Request;
class HomeController extends Controller {
    public function home(){return view('home',['total'=>Confection::count(),'featured'=>Confection::with('prices')->where('type','cake')->orderBy('cname')->limit(6)->get()]);}
    public function database(Request $request){
        $filters=$request->validate([
            'search'=>['nullable','string','max:255'],
            'type'=>['nullable','string','max:100'],
            'page'=>['nullable','integer','min:1'],
        ]);
        $query=Confection::with(['prices','contents']);
        if($request->filled('search'))$query->where('cname','like','%'.$filters['search'].'%');
        if($request->filled('type'))$query->where('type',$filters['type']);
        return view('database',['confections'=>$query->orderBy('cname')->paginate(12)->withQueryString(),'types'=>Confection::distinct()->orderBy('type')->pluck('type')]);
    }
    public function graph(){
        $types=Confection::selectRaw('type, COUNT(*) as total')->groupBy('type')->orderByDesc('total')->get();
        $units=Price::selectRaw('unit, COUNT(*) as total')->groupBy('unit')->orderByDesc('total')->get();
        return view('graph',compact('types','units'));
    }
}
