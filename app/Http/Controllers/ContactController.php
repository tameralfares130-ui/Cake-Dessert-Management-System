<?php
namespace App\Http\Controllers;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
class ContactController extends Controller {
    public function create(){return view('contact');}
    public function store(Request $request){
        $data=$request->validate(['name'=>['required','string','max:100'],'email'=>['required','email','max:255'],'subject'=>['required','string','max:150'],'message'=>['required','string','min:10','max:3000']]);
        ContactMessage::create($data);
        return redirect()->route('contact')->with('success','Your message has been saved.');
    }
    public function index(){return view('messages',['messages'=>ContactMessage::latest()->paginate(10)]);}
}
