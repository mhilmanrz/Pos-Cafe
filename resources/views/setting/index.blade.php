@extends('layouts.app')
@section('title','Pengaturan')
@section('content')
<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-8">
                    {{-- Pastikan form di-bind dengan variabel $setting --}}
                    {{ Form::model($setting,['url'=>route('setting.update',[$setting->id]),'class'=>'form-horizontal','method'=>'PUT','files'=>true])}}
                    <div class="card card-with-nav">
                        <div class="card-body">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Nama</label>
                                        {{ Form::text('name',null,['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Telpon</label>
                                        {{ Form::text('phone',null,['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Logo</label>
                                        {{-- PERBAIKAN: Mengganti nama input dari 'images' menjadi 'logo' --}}
                                        <input type="file" class="form-control" name="logo">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Gambar QRIS</label>
                                        <input type="file" class="form-control" name="qris_image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Instagram</label>
                                        {{ Form::text('instagram',null,['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-1">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Alamat</label>
                                        {{ Form::textarea('address',null,['class' => 'form-control' , 'rows' => 3]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3 mb-3">
                                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-header bg-primary">
                            <div class="text-center text-white">
                                <h3>{{ $setting->name }}</h3>
                            </div>
                            <div class="profile-picture">
                                <div class="avatar avatar-xl">
                                    <img src="{{ asset('assets/img/setting/'.$setting->images) }}" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile text-center">
                                <div class="name">{{ $setting->name }}</div>
                                <div class="job">{{ $setting->phone }}</div>
                                <div class="desc">{{ $setting->address }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
