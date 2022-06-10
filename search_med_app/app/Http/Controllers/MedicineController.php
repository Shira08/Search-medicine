<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Imports\MedicineImport;
use Maatwebsite\Excel\Facades\Excel;


class MedicineController extends Controller
{
    public function listMedicine()
    {
        $medicines = Medicine::get();
        return view('pages.medicine',['medicines'=>$medicines]);
    }

    public function importMedicine(Request $request)
    {
        $request->validate([
            'excel_file'=>'required|mimes:xlsx'
        ]);

        Excel::import(new MedicineImport, $request->file('excel_file'));
        return redirect()->back()->with('success', 'Les médicaments ont bien été ajouter!');
    }
    
    public function updateMedicine(Request $request)
    {
        $request->validate( [
            'name'=>'required',
            'type'=>'required',
            'dosage'=>'required',
            'people'=>'required',
        ] );

        $updatedTime = now()->toDateTimeString();
        

        $res = DB::table( 'medicines' )->where( 'id', $request->id )->update( [
            'name'=>$request->name,
            'type' => $request->type,
            'dosage' => $request->dosage,
            'people' => $request->people,
            'updated_at' => $updatedTime
        ] );
        if ( $res ) {
                return back()->with( 'success', 'Mise à jour bien faite' );

        } else {
            return back()->with( 'fail', 'Il y a un problème , Réessayez slp' );
        }
    }

    public function deleteMedicine($id)
    {
        Medicine::find($id)->delete();
  
        return redirect()->back();
    }
}
