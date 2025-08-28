@extends('layouts.app')
@section('content')
<div class="main-panel">
<div class="container">
  <div class="panel-header">
    <div class="page-inner py-5">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
          <h2 class="pb-2 fw-bold">Data Pajak</h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-inner mt--5">
    <div class="row mt--2">
      <div class="col-md-12">
        <div class="card full-height">
          {{ Form::model($tax,['url'=>route('tax.update',[$tax->id]),'class'=>'form-horizontal','method'=>'PUT'])}}
          <div class="card-body">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Nama pajak</label>
              <div class="col-sm-10">
                {{ Form::text('name',null,['class'=>'form-control','placeholder'=>'Name'])}}
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Jumlah pajak</label>
              <div class="col-sm-10">
                <div class="input-group mb-3">
                  {{ Form::text('value',null,['class'=>'form-control','placeholder'=>'Jumlah pajak'])}}
                  <div class="input-group-append">
                    <span class="input-group-text">%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-success btn-sm">Simpan</button>                        
              </div>
            </div>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection