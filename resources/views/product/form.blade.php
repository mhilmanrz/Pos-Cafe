<div class="card-body">
    
    <div class="form-group">
        <label for="exampleInputPassword1">Nama Produk</label>
        {{ Form::text('name_product',null,['class'=>'form-control','placeholder'=>'Nama produk'])}}
        @if ($errors->has('name_product')) <span class="help-block" style="color:red">{{ $errors->first('name_product') }}</span> @endif
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Kategori</label>
        {!! Form::select('category_id', $categories, null,['class' => 'form-control','id' => 'basic','placeholder' => '-- pilih kategori  --']) !!}
        @if ($errors->has('category_id')) <span class="help-block" style="color:red">{{ $errors->first('category_id') }}</span> @endif
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Harga</label>
        {{ Form::text('price',null,['class'=>'form-control','placeholder'=>'Harga'])}}
        @if ($errors->has('price')) <span class="help-block" style="color:red">{{ $errors->first('price') }}</span> @endif
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Diskon</label>
        {{ Form::text('discount',null,['class'=>'form-control','placeholder'=>'Diskon'])}}
        @if ($errors->has('discount')) <span class="help-block" style="color:red">{{ $errors->first('discount') }}</span> @endif
    </div>

   <div class="form-group">
    <label for="stock">Stok Produk</label>
    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ $product->stock ?? old('stock') ?? 0 }}" required>
    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

    <div class="form-group">
        <label for="exampleInputPassword1">Gambar</label>
        {{ Form::file('image',['class'=>'form-control'])}}
        @if ($errors->has('image')) <span class="help-block" style="color:red">{{ $errors->first('image') }}</span> @endif
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Deskripsi</label>
        {{ Form::textarea('description',null,['class'=>'form-control','placeholder'=>'Description'])}}
        @if ($errors->has('description')) <span class="help-block" style="color:red">{{ $errors->first('description') }}</span> @endif
    </div>

</div>

<div class="card-footer">
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-sm">simpan</button>
            
        <a href="{{ route('product.index') }}" class="btn btn-primary btn-sm">kembali</a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'description' );
</script>
@endpush