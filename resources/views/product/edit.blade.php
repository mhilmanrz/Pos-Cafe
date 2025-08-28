@extends('layouts.app')
@section('title','Edit Product')
@section('content')

<div class="main-panel">
    <div class="container">
       <div class="page-inner">
          <div class="row">
            <div class="col-md-2">
 
            </div>
             <div class="col-md-8">
                <div class="card">
                   <div class="card-body">
                    {{ Form::model($product,['url'=>route('product.update',[$product->id]),'class'=>'form-horizontal','method'=>'PUT','files'=>true])}}
                    
                    @include('product.form')  
           
                     {!! Form::close() !!}  
                   </div>
                </div>
             </div>
             <div class="col-md-2">
 
             </div>
          </div>
       </div>
    </div>
 </div>
 </div>
@endsection