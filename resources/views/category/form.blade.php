<div class="card-body">

  <div class="form-group">
      <label for="exampleInputPassword1">Nama Kategori</label>
      {{ Form::text('name_category',null,['class'=>'form-control','placeholder'=>'Nama Kategori'])}}
      @if ($errors->has('name_category')) <span class="help-block" style="color:red">{{ $errors->first('name_category') }}</span> @endif
  </div>

</div>

<div class="card-footer">
  <div class="form-group">
      <button type="submit" class="btn btn-success btn-sm">simpan</button>
          
      <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">Kembali</a>
  </div>
</div>