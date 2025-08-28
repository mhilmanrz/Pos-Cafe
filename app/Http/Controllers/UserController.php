<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar semua pengguna/karyawan.
     */
    public function index()
    {
        // Mengambil semua data pengguna, kecuali admin yang sedang login
        $data['users'] = User::where('id', '!=', auth()->id())->get();
        return view('users.index', $data);
    }

    /**
     * Menampilkan form untuk menambah karyawan baru.
     */
    public function create()
    {
        // PERBAIKAN: Mengirimkan instance User baru yang kosong ke view
        // untuk mencegah error "Undefined variable $user" di form.
        $user = new User();
        return view('users.create', compact('user'));
    }

    /**
     * Menyimpan karyawan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,kasir,kitchen',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        alert()->success('Karyawan baru berhasil ditambahkan', 'Success');
        return redirect()->route('users.index');
    }

    /**
     * Menampilkan form untuk mengedit data karyawan.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data karyawan di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,kasir,kitchen',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        alert()->success('Data karyawan berhasil diperbarui', 'Success');
        return redirect()->route('users.index');
    }

    /**
     * Menghapus data karyawan dari database.
     */
    public function destroy(User $user)
    {
        // Mencegah admin menghapus akunnya sendiri
        if ($user->id === auth()->id()) {
            alert()->error('Tidak dapat menghapus akun Anda sendiri', 'Error');
            return redirect()->route('users.index');
        }

        $user->delete();
        alert()->success('Karyawan berhasil dihapus', 'Success');
        return redirect()->route('users.index');
    }
}