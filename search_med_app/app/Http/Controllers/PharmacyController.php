<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pharmacies;
use Hash;
use Session;
use DB;

class PharmacyController extends Controller {

    public function pharmacyLogin() {
        return view( 'logins.pharmacy-login' );
    }

    public function login( Request $request ) {
        $request->validate( [
            'email'=>'required',
            'password'=>'required|min:5|max:12'
        ] );

        $email = $request->email;
        $password = $request->password;

        /* $login = DB::table( 'pharmacies' )
        ->where( 'email', '=', $email )
        ->where( 'password', '=', $password )
        ->first();
        */
        $login = Pharmacies::where( 'email', $email )->first( [ 'id', 'password' ] );
        //dd( $login );
        if ( $login ) {
            if ( hash::check( $request->password, $login->password ) ) {
                $request->session()->put( 'loginId', $login->id );
                return redirect( 'dashboard-pharmacy' );
            } else {
                return back()->with( 'fail', ' pass not good' );
            }
        } else {
            return back()->with( 'fail', 'Email or pass not good' );
        }
    }

    public function addPharmacy() {
        return view( 'pages.pharmacy' );
    }

    public function savePharmacy( Request $request ) {
        $request->validate( [
            'name'=>'required',
            'contact'=>'required|max:17',
            'email'=>'required|email|unique:pharmacies',
            'indication'=>'required',
            'itineraire'=>'required',
            'password'=>'required|min:5|max:12'
        ] );

        $pharmacy = new Pharmacies();

        $pharmacy->name = $request->name;
        $pharmacy->contact = $request->contact;
        $pharmacy->email = $request->email;
        $pharmacy->indication = $request->indication;
        $pharmacy->itineraire = $request->itineraire;
        $pharmacy->password = Hash::make( $request->password );
        $res = $pharmacy->save();

        if ( $res ) {
            return back()->with( 'success', 'youre boss' );

        } else {
            return back()->with( 'fail', 'Something wrong' );
        }
    }

    public function displayPharmacy() {
        $displayData = Pharmacies::all();

        return view( 'pages/pharmacy-list', compact( 'displayData' ) );
    }

    public function editPharmacy( $id ) {
        $data = DB::table( 'pharmacies' )->where( 'id', $id )->first();
        return view( 'pages/edit-pharmacy', compact( 'data' ) );
    }

    public function updatePharmacy( Request $request ) {

        $request->validate( [
            'name'=>'required',
            'contact'=>'required|max:17',
            'email'=>'required|email|unique:pharmacies',
            'indication'=>'required',
            'itineraire'=>'required',
        ] );

        $updatedTime = now()->toDateTimeString();
        

        $res = DB::table( 'pharmacies' )->where( 'id', $request->id )->update( [
            'name'=>$request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'indication' => $request->indication,
            'itineraire' => $request->itineraire,
            'password' => Hash::make( $request->password ),
            'updated_at' => $updatedTime
        ] );
        

        if ( $res ) {
            $date = DB::table('pharmacies')->where('updated_at', $updatedTime)->get(['created_at']);
            if($date == $updatedTime)
            {
                return back()->with( 'fail', 'heure' );
            }else
            {
                return back()->with( 'success', 'Mise à jour bien faite' );
            }
            

        } else {
            return back()->with( 'fail', 'Il y a un problème , Réessayez slp' );
        }
    }

    public function deletePharmacy( $id ) {
        $res = DB::table( 'pharmacies' )->where( 'id', '=', $id )->delete();
        if ( $res ) {
            return back()->with( 'success', 'Pharmacies number' + $id + ' is deleted successfully' );

        } else {
            return back()->with( 'fail', 'Something wrong' );
        }
    }

    public function dashPharmacy() {
        return view( 'pages.dashboard-pharmacy' );
    }
}
