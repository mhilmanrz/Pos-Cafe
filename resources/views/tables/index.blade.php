@extends('layouts.app')
@section('title', 'Data Meja')
@section('content')
<div class="main-panel">
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Meja</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Daftar Meja</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#formModal">
                                    <i class="fa fa-plus"></i>
                                    Tambah Meja
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="basic-datatables" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">No</th>
                                            <th>Nama Meja</th>
                                            <th style="width: 25%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tables as $table)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $table->name }}</td>
                                            <td>
                                                {{-- PERBAIKAN: Memindahkan tombol QR code ke dalam div ini --}}
                                                <div class="form-button-action">
                                                    <button type="button" data-toggle="tooltip" title="Edit" class="btn btn-link btn-primary btn-lg btn-edit" data-id="{{ $table->id }}" data-name="{{ $table->name }}">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    {{-- Tombol untuk Generate QR Code --}}
                                                    <a href="{{ route('tables.qrcode', $table->id) }}" data-toggle="tooltip" title="Generate QR Code" class="btn btn-link btn-info" target="_blank">
                                                        <i class="fa fa-qrcode"></i>
                                                    </a>

                                                    <button type="button" data-toggle="tooltip" title="Hapus" class="btn btn-link btn-danger delete-table" data-id="{{ $table->id }}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabel">Tambah Meja Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="table-form" action="{{ route('tables.store') }}" method="POST">
            @csrf
            <div id="form-method"></div>
            <div class="form-group">
                <label for="name">Nama Meja</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Meja 10" required>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" form="table-form">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        // Reset form saat modal "Tambah" dibuka
        $('#formModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            if (!button.hasClass('btn-edit')) {
                $('#formModalLabel').text('Tambah Meja Baru');
                $('#table-form').attr('action', '{{ route('tables.store') }}');
                $('#form-method').html('');
                $('#name').val('');
            }
        });

        // Saat tombol "Edit" di klik, siapkan form di modal
        $('.btn-edit').click(function(){
            var id = $(this).data('id');
            var name = $(this).data('name');

            $('#formModalLabel').text('Edit Meja');
            $('#table-form').attr('action', '/tables/' + id);
            $('#form-method').html('@method("PUT")');
            $('#name').val(name);

            $('#formModal').modal('show');
        });

        // Script untuk tombol hapus dengan konfirmasi
        $('.delete-table').click(function(e) {
            var id = $(this).data('id'); 
            swal({
                title: 'Apakah kamu yakin?',
                text: "Meja akan dihapus secara permanen!",
                type: 'warning',
                buttons:{
                    confirm: {
                        text : 'Ya, hapus!',
                        className : 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '/tables/' + id,
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE"
                        },
                        success: function(data){
                            swal("Berhasil!", "Meja telah dihapus.", {
                                icon : "success",
                                buttons: { confirm: { className: 'btn btn-success' }}
                            });
                            location.reload();
                        }
                    });
                } else {
                    swal.close();
                }
            });
        });
    });
</script>
@endpush
