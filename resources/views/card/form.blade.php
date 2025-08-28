<div class="card-body">

  <div class="form-group">
      <label for="exampleInputPassword1">Nama Metode Pembayaran</label>
      {{ Form::text('name_card',null,['class'=>'form-control','placeholder'=>'Nama Metode Pembayaran'])}}
      @if ($errors->has('name_card')) <span class="help-block" style="color:red">{{ $errors->first('name_card') }}</span> @endif
  </div>

</div>

<div class="card-footer">
  <div class="form-group">
      <button type="submit" class="btn btn-success btn-sm">simpan</button>
          
      <a href="{{ route('card.index') }}" class="btn btn-primary btn-sm">Kembali</a>
  </div>
</div>