@extends('layout.backend.app', [
    'title' => 'Create Product',
    'pageTitle' => 'Create Product',
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
    <div class="card">
        <div class="card-body">

            <form action="{{ route('product.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <h5><strong>Product</strong></h5>
                        <hr>

                        <div id="product-fields">
                            <div class="product-group">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="product_name">Product Name:</label>
                                        <input type="text"
                                            class="form-control  @error('product_name') is-invalid @enderror"
                                            id="product_name" name="product_name" placeholder="ex: COLA COLA"
                                            value="{{ old('product_name') }}">
                                        @error('product_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="price">Price:</label>
                                        <input type="number" class="form-control  @error('price') is-invalid @enderror"
                                            price-input" id="price" name="price" placeholder="ex: 10000">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group col-4">
                                        <label for="description">Description:</label>
                                        <input type="text"
                                            class="form-control  @error('description') is-invalid @enderror"
                                            description-input" id="description" name="description"
                                            placeholder="ex: Lorem Ipsuum">
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('product.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        $('#paymentMethod').select2();
    });
</script>
