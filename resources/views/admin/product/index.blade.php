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

    <!-- Modal Edit -->
    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-modalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="hidden" required="" id="id" name="id" class="form-control">
                            <input type="" required="" id="name" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price">price</label>
                            <input type="" required="" id="price" name="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="" required="" id="description" name="description" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="buton" class="btn btn-primary btn-update" id="btnupdate">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit -->

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
                        name: 'price',
                        render: function(data, type, row) {
                            // Format the price with thousands separator
                            return formatNumber(data);
                        }
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            // Format the date to dd.mm.yy
                            return formatDate(data);
                        }
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

        function formatNumber(value) {
            if (value === null || value === undefined) {
                return '';
            }
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function formatDate(dateString) {
            if (!dateString) {
                return '';
            }
            var date = new Date(dateString);
            var day = String(date.getDate()).padStart(2, '0');
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var year = String(date.getFullYear()).slice(); // Get last 2 digits of the year

            return day + '.' + month + '.' + year;
        }

        // Edit & Update
        $('body').on("click", ".btn-edit", function() {
            var id = $(this).data("id")

            $.ajax({
                url: "product/" + id + "/edit",

                method: "GET",
                success: function(response) {
                    $("#edit-modal").modal("show")
                    $("#id").val(response.id)
                    $("#name").val(response.name)
                    $("#price").val(response.price)
                    $("#description").val(response.description)
                }
            })
        });


        $('#btnupdate').on("click", function(e) {
            e.preventDefault();
            var form = $("#editForm");
            var id = $("#id").val();

            $.ajax({
                url: "product/" + id,
                method: "PUT",
                data: form.serialize(),
                success: function(response) {
                    $('.data-table').DataTable().ajax.reload();
                    $("#edit-modal").modal("hide");
                    flash("success", response.success);
                },
                error: function(xhr) {
                    // Tampilkan pesan error jika permintaan gagal
                    flash("error", "Terjadi kesalahan: " + xhr.responseText);
                }
            });
        });
        //Edit & Update


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
                    $('.data-table').DataTable().ajax.reload();
                    $("#destroy-modal").modal("hide");
                    flash('success', 'Product Delete Successfully');
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
