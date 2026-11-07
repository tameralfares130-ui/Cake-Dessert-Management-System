<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Confection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ConfectionController extends Controller {
    public function index(){return view('admin.index',['confections'=>Confection::withCount(['prices','contents'])->orderBy('id')->paginate(15)]);}
    public function create(){return view('admin.create');}
    public function store(Request $request){Confection::create($this->validated($request));return redirect()->route('admin.confections.index')->with('success','Confection added.');}
    public function edit(Confection $confection){return view('admin.edit',compact('confection'));}
    public function update(Request $request, Confection $confection){$confection->update($this->validated($request));return redirect()->route('admin.confections.index')->with('success','Confection updated.');}
    public function destroy(Confection $confection){$confection->delete();return redirect()->route('admin.confections.index')->with('success','Confection deleted.');}
    private function validated(Request $request): array {
        return $request->validate(['cname'=>['required','string','max:255'],'type'=>['required','string','max:100'],'prizewinning'=>['required',Rule::in(['-1','0','1'])]]);
    }
}
