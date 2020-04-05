<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Hash;
class UsersController extends Controller
{
    public function index ()
    {
        $usuarios = \DB::table('users')
                    ->select('users.*')
                    ->orderBy('id','DESC')
                    ->get();
        return view('usuarios')->with('usuarios',$usuarios) ;
            
    }
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(),[
            'nombre'=>'required|min:3|max:20',
            'email'=>'required|min:3|email',
            'pass1'=>'required|min:3|required_with:pass2|same:pass2',
            'pass2'=>'required|min:3'
        ]);
        if($validator ->fails()){
            return back()
            ->withInput()
            ->with('ErrorInsert','Favor de llenar todos los campos')
            ->withErrors($validator);
        }else{
            $usuario = User::create([
                'name'=>$request->nombre,
                'img'=>'default.jpg',
                'nivel'=>'usuario',
                'email'=>$request->email,
                'password'=>Hash::make($request->pass1)
            ]);
            return back()->with('Listo','Se ha insertado correctamente');
        }
        
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->img !='default.jpg'){
            if(files_exists( public_path('users/'.$user->img) )){
                unlink( public_path('users/'.$user->img));
            }
        }
        $user->delete();
        return back()->with('Listo','El registro se elimino correctamente');
    }
}
