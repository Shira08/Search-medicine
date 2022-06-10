<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hopital;
use Hash;
use Session;
use DB;

class HospitalController extends Controller
{
    public function hospitalLogin()
    {
        return view('logins.hospital-login');
    }

    public function login(Request $request)
    {
         $request->validate([
            'email'=>'required',
            'password'=>'required|min:5|max:12'
        ]);  
        $email = $request->email;
        $password = $request->password;

       
       /* $login = DB::table('pharmacies')
                ->where('email', '=', $email)
                ->where('password', '=', $password)
                ->first();*/
                $login = Hopital::where('email', $email)->first(['id', 'password']);
                //dd($login);
        if($login)
        {
                if(hash::check($request->password, $login->password))
                {
                    $request->session()->put('loginId',$login->id);
                    return redirect('dashboard-hospital');
                }else
                {
                    return back()->with( 'fail', ' pass not good' );
                }
        }else
        {
            return back()->with( 'fail', 'Email or pass not good' );
        }
    }

    public function addHospital()
    {
        return view('pages.add-hospital');
    }

    public function saveHospital( Request $request )
     {
        $request->validate( [
            'name'=>'required',
            'contact'=>'required|max:17',
            'email'=>'required|email|unique:pharmacies',
            'indication'=>'required',
            'itineraire'=>'required',
            'password'=>'required|min:5|max:12'
        ] );

        $hopital = new Hopital();

        $hopital->name = $request->name;
        $hopital->contact = $request->contact;
        $hopital->indication = $request->indication;
        $hopital->itineraire = $request->itineraire;
        $hopital->email = $request->email;
        $hopital->password = Hash::make( $request->password );
        $res = $hopital->save();

        if ( $res ) {
            return back()->with( 'success', 'youre boss' );

        } else {
            return back()->with( 'fail', 'Something wrong' );
        }
    }
    public function listHospital() {
        $datas = Hopital::all();

        return view( 'pages/hospital-list', compact( 'datas' ) );
    }
    public function editHospital($id)
    {
        $data = DB::table('hopitals')->where('id', $id)->first();
        return view( 'pages/edit-hospital', compact( 'data' ));
    } 

    public function updateHospital(Request $request) {

        $request->validate( [
            'name'=>'required',
            'contact'=>'required|max:17',
            'email'=>'required|email|unique:pharmacies',
            'indication'=>'required',
            'itineraire'=>'required',
        ] );

        $res = DB::table('hopitals')->where('id',$request->id)->update([
            'name'=>$request->name,
            'contact' => $request->contact,
            'indication' => $request->indication,
            'itineraire' => $request->itineraire,
            'email' => $request->email,
            'password' => Hash::make( $request->password )
        ]);

        if ( $res ) {
            return back()->with( 'success', 'Pharmacies information are correctly updated' );

        } else {
            return back()->with( 'fail', 'Something wrong' );
        }
    }
    public function deleteHospital($id)
    {
        $res = DB::table('hopitals')->where('id', '=', $id)->delete();
        if ( $res ) {
            return back()->with( 'success', 'Hospital number is deleted successfully');

        } else {
            return back()->with( 'fail', 'Something wrong' );
        }
    }

    public function dashHospital() {
        return view( 'pages.dashboard-hospital' );
    }
}
