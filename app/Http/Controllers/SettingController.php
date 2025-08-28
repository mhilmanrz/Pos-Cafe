<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\File; // Import class File untuk menghapus file lama

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan utama.
     * Fungsi ini mengambil data pengaturan dari database.
     * Jika tidak ada data, fungsi ini akan membuat data default
     * untuk menghindari error pada halaman.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menggunakan firstOrCreate untuk memastikan data dengan id=1 selalu ada.
        // Ini adalah praktik yang baik untuk tabel pengaturan (settings table).
        $setting = Setting::firstOrCreate(
            ['id' => 1], // Kondisi pencarian
            [
                'name' => 'Nama Kafe Anda', // Nilai default jika data tidak ditemukan
                'address' => 'Alamat Default Anda'
            ]
        );

        // Mengirim data setting ke view 'setting.index'
        return view('setting.index', compact('setting'));
    }

    /**
     * Memperbarui data pengaturan di database.
     * Fungsi ini menerima data dari form, memvalidasinya,
     * memproses file upload (logo & QRIS), dan menyimpannya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi semua input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'instagram' => 'nullable|string|max:255',
            // Gunakan nama input dari form HTML Anda, contoh: 'logo'
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil data setting yang akan di-update
        $setting = Setting::findOrFail($id);

        // 3. Ambil semua input teks dari request
        $input = $request->except(['_token', '_method', 'logo', 'qris_image']);

        // 4. Proses upload file LOGO jika ada file baru yang diupload
        if ($request->hasFile('logo')) {
            $fileLogo = $request->file('logo');
            // Membuat nama file yang unik berdasarkan waktu
            $fileNameLogo = time() . '_logo.' . $fileLogo->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/setting');

            // Hapus file logo lama jika ada
            if ($setting->images && File::exists($destinationPath . '/' . $setting->images)) {
                File::delete($destinationPath . '/' . $setting->images);
            }

            // Pindahkan file baru ke folder tujuan
            $fileLogo->move($destinationPath, $fileNameLogo);

            // Simpan nama file baru ke dalam array $input
            // Pastikan nama kolom di database adalah 'images'
            $input['images'] = $fileNameLogo;
        }

        // 5. Proses upload file QRIS jika ada file baru yang diupload (LOGIKA TERPISAH)
        if ($request->hasFile('qris_image')) {
            $fileQris = $request->file('qris_image');
            $fileNameQris = time() . '_qris.' . $fileQris->getClientOriginalExtension();
            $destinationPath = public_path('/assets/img/setting');

            // Hapus file qris lama jika ada
            if ($setting->qris_image && File::exists($destinationPath . '/' . $setting->qris_image)) {
                File::delete($destinationPath . '/' . $setting->qris_image);
            }

            // Pindahkan file baru ke folder tujuan
            $fileQris->move($destinationPath, $fileNameQris);

            // Simpan nama file baru ke dalam array $input
            $input['qris_image'] = $fileNameQris;
        }

        // 6. Update semua data (termasuk nama file gambar jika ada) ke database
        $setting->update($input);

        // 7. Tampilkan pesan sukses dan kembali ke halaman pengaturan
        alert()->success('Data berhasil diubah', 'Success');
        return redirect()->route('setting.index');
    }
}
