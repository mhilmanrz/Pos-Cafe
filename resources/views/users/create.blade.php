@extends('layouts.app')
@section('title', 'Tambah Karyawan')
@section('content')
<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="page-header"><h4 class="page-title">Tambah Karyawan Baru</h4></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- PERBAIKAN: Form ini menunjuk ke route 'users.store' --}}
                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf
                                @include('users._form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection