@extends('layouts.app')
@section('title', 'Edit Karyawan')
@section('content')
<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="page-header"><h4 class="page-title">Edit Data Karyawan</h4></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- PERBAIKAN: Form ini menunjuk ke route 'users.update' dengan parameter $user->id --}}
                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('users._form', ['edit' => true])
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection