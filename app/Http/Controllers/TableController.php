<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
// PASTIKAN BARIS INI ADA untuk mengimpor library QR Code
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        $data['tables'] = Table::orderBy('name', 'asc')->get();
        return view('tables.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Table::create($request->all());
        alert()->success('Meja berhasil ditambahkan', 'Success');
        return redirect()->route('tables.index');
    }

    public function update(Request $request, Table $table)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $table->update($request->all());
        alert()->success('Meja berhasil diubah', 'Success');
        return redirect()->route('tables.index');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return response()->json(['success' => 'Meja berhasil dihapus']);
    }

    // Method untuk membuat QR Code
    public function qrcode($id)
    {
        $table = Table::findOrFail($id);
        // URL ini akan menjadi tujuan saat QR code di-scan
        $url = route('customer.menu.table', $table->id); 

        // Generate QR Code dari URL
        $qrCode = QrCode::size(300)->generate($url);

        // Tampilkan QR Code sebagai gambar SVG
        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
}
