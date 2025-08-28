<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;

class TaxController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Menggunakan firstOrCreate untuk mencegah error on null.
        // Ini akan mencari tax dengan id=1. Jika tidak ada,
        // maka akan membuat data baru dengan nilai default.
        $data['tax'] = Tax::firstOrCreate(
            ['id' => 1],
            ['name' => 'PPN', 'value' => 11] // Anda bisa mengubah nilai default ini
        );

        return view('tax.index', $data);
    }


    public function update(Request $request, $id)
    {
        $tax = Tax::find($id);
        $tax->update($request->all());

        alert()->success('Data berhasil diubah' , 'Success');
        return redirect('tax');
    }
}
