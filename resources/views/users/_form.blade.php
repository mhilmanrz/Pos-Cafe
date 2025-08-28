{{-- PERBAIKAN: File ini tidak lagi memiliki tag <form> --}}
<div class="form-group">
    <label for="name">Nama Lengkap</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
</div>
<div class="form-group">
    <label for="email">Alamat Email</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
</div>
<div class="form-group">
    <label for="role">Peran (Role)</label>
    <select class="form-control" id="role" name="role" required>
        <option value="kasir" {{ old('role', $user->role ?? '') == 'kasir' ? 'selected' : '' }}>Kasir</option>
        <option value="kitchen" {{ old('role', $user->role ?? '') == 'kitchen' ? 'selected' : '' }}>Dapur (Kitchen)</option>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
</div>
<div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" {{ empty($edit) ? 'required' : '' }}>
    @if(!empty($edit)) <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small> @endif
</div>
<div class="form-group">
    <label for="password_confirmation">Konfirmasi Password</label>
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ empty($edit) ? 'required' : '' }}>
</div>
<div class="card-action">
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('users.index') }}" class="btn btn-danger">Batal</a>
</div>