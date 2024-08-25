@extends('layout.backend.app', [
    'title' => 'Product',
    'pageTitle' => 'Product',
])

@push('css')
    <link href="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    @elseif($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    @endif
    <div class="notify"></div>
    <div class="card">
        <div class="card-header">
            <!-- Button trigger modal -->
            <a href="{{ route('product.create') }}" class="btn btn-primary">
                Create Product
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="destroy-modal" tabindex="-1" role="dialog" aria-labelledby="destroy-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="destroy-modalLabel">Yakin Hapus ?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-destroy" data-id="">Hapus</button>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('template/backend/sb-admin-2') }}/js/demo/datatables-demo.js"></script>

    <script type="text/javascript">
        $(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('product.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    },
                ]
            });
        });

        $('body').on("click", ".btn-delete", function() {
            var id = $(this).data("id"); // Mengambil data-id dari tombol delete
            $(".btn-destroy").data("id", id); // Mengatur data-id ke tombol destroy
            $("#destroy-modal").modal("show");
        });

        $(".btn-destroy").on("click", function() {
            var id = $(this).data("id"); // Mengambil data-id dari tombol destroy

            $.ajax({
                url: "product/" + id,
                method: "DELETE",
                success: function() {
                    $("#destroy-modal").modal("hide");
                    $('.data-table').DataTable().ajax.reload();
                    flash('success', 'Data berhasil dihapus');
                },
                error: function(xhr) {
                    //salert('Error', xhr.responseJSON.error);
                    // flash('error', 'Gagal menghapus data');
                    flash('error', 'Gagal menghapus data');
                }
            });
        });

        function flash(type, message) {
            $(".notify").html(`<div class="alert alert-` + type + ` alert-dismissible fade show" role="alert">
                              ` + message + `
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>`)
        }
    </script>
@endpush
