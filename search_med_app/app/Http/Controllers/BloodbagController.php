<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bloodbag;
use App\Imports\BloodbagImport;
use Maatwebsite\Excel\Facades\Excel;

class BloodbagController extends Controller
{
    public function listBloodbag()
    {
        $bloodbags = Bloodbag::get();
        return view('pages.bloodbag',['bloodbags'=>$bloodbags]);
    }

    public function importBloodBag(Request $request)
    {
        $request->validate([
            'excel_file'=>'required|mimes:xlsx'
        ]);

        Excel::import(new BloodbagImport, $request->file('excel_file'));
        return redirect()->back()->with('success', 'Les poches de sang ont bien été ajouter!');
    }

    public function deleteBloodbag($id)
    {
        Bloodbag::find($id)->delete();
  
        return redirect()->back();
    }
}
