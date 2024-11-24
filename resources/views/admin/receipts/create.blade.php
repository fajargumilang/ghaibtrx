@extends('layout.backend.app', [
    'title' => 'Create Receipt Print',
    'pageTitle' => 'Create Receipt Print',
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

            <form id="payment-form" action="{{ route('receipts.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Form Column -->
                    <div class="col-md-6">
                        <h5>
                            <strong>Store Data </strong>
                        </h5>
                        <hr>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="store_name">Store Name:</label>
                                <input type="text" class="form-control @error('store_name') is-invalid @enderror"
                                    id="store_name" name="store_name" placeholder="ex: SOLO SWA"
                                    value="{{ old('store_name') }}">
                                @error('store_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="form-group col-6">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control  @error('address') is-invalid @enderror"
                                    id="address" name="address" placeholder="ex: JL.  JEND.  SUDIRMAN -  BERAU"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="hp">HP:</label>
                                <input type="number" class="form-control  @error('hp') is-invalid @enderror" id="hp"
                                    name="hp" placeholder="ex: 0812 8888 1111" value="{{ old('hp') }}">
                                @error('hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="trans">Trans:</label>
                                <input type="number" class="form-control  @error('trans') is-invalid @enderror"
                                    id="trans" name="trans" placeholder="ex: 1155509001" value="{{ old('trans') }}">
                                @error('trans')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="kassa">Kassa:</label>
                                <input type="number" class="form-control  @error('kassa') is-invalid @enderror"
                                    id="kassa" name="kassa" placeholder="ex: 003" value="{{ old('kassa') }}">
                                @error('kassa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="name_of_kassa">Name of Kassa:</label>
                                <input type="text" class="form-control  @error('name_of_kassa') is-invalid @enderror"
                                    id="name_of_kassa" name="name_of_kassa" placeholder="ex: NURUL QOMARI"
                                    value="{{ old('name_of_kassa') }}">
                                @error('name_of_kassa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" class="form-control  @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal" value="" value="{{ old('tanggal') }}">
                                @error('tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="time_transaction">Time Transaction:</label>
                                <input type="time" class="form-control  @error('time_transaction') is-invalid @enderror"
                                    id="time_transaction" name="time_transaction" value="" placeholder="ex: 11:55"
                                    value="{{ old('time_transaction') }}">
                                @error('time_transaction')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class=" col-12">
                                <h5>
                                    <strong>Informations - (Optional)</strong>
                                </h5>
                                <hr>
                            </div>

                            <div class="form-group col-6">
                                <label for="member">Member:</label>
                                <input type="text" class="form-control  @error('member') is-invalid @enderror"
                                    id="member" name="member" placeholder="ex: M/SLO1190900247"
                                    value="{{ old('member') }}">
                                @error('member')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="name_of_customer">Name of Customer:</label>
                                <input type="text"
                                    class="form-control  @error('name_of_customer') is-invalid @enderror"
                                    id="name_of_customer" name="name_of_customer" placeholder="ex: VAHYU VANNY HERTANTO"
                                    value="{{ old('name_of_customer') }}">
                                @error('name_of_customer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="pt_akhir">PT Akhir:</label>
                                <input type="text" class="form-control  @error('pt_akhir') is-invalid @enderror"
                                    id="pt_akhir" name="pt_akhir" placeholder="ex: 477 Point"
                                    value="{{ old('pt_akhir') }}">
                                @error('pt_akhir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class=" col-12">
                                <h5>
                                    <strong>Payment </strong>
                                </h5>
                                <hr>
                            </div>


                            <div class="form-group col-6">
                                <label for="paymentMethod">Payment Method:</label>
                                <select class="form-control @error('payment_method') is-invalid @enderror"
                                    id="paymentMethod" name="payment_method">
                                    <option value="">-= Select Payment Method =-</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card
                                    </option>
                                    <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>
                                        Online</option>
                                </select>

                                @error('payment_method')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="anda_hemat">Anda Hemat : - (Optional)</label>
                                <input type="number" class="form-control  @error('anda_hemat') is-invalid @enderror"
                                    id="anda_hemat" name="anda_hemat" placeholder="ex: 500.000"
                                    value="{{ old('anda_hemat') }}">
                                @error('anda_hemat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="total_price">Total Price:</label>
                                <input type="text" class="form-control @error('total_price') is-invalid @enderror"
                                    id="total_price" name="total_price" placeholder="ex: 0"
                                    value="{{ old('total_price') }}" readonly>
                            </div>

                            <div class="form-group col-6">
                                <label for="uang_tunai">Payment :</label>
                                <input type="number" class="form-control  @error('uang_tunai') is-invalid @enderror"
                                    id="uang_tunai" name="uang_tunai" placeholder="ex: 500.000"
                                    value="{{ old('uang_tunai') }}">
                                @error('uang_tunai')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5><strong>Product</strong></h5>
                        <hr>

                        <div id="product-fields">
                            <div class="product-group">
                                <div class="row">
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                        <label for="product_name">[1] Product Name:</label>
                                        <select class="select2 form-control product-select" name="product_name[]"
                                            placeholder="ex: Enter product name">
                                            <option value="">-= Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->name }}" data-price="{{ $product->price }}">
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_name.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                        <label for="price">Price:</label>
                                        <input type="text" class="form-control price-input" name="price[]"
                                            placeholder="ex: 10000" readonly>
                                        @error('price.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" class="form-control quantity-input" id="quantity"
                                            name="quantity[]" placeholder="ex: 3">
                                        @error('quantity.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <hr>
                                        <button type="button"
                                            class="float-right btn btn-danger remove-field">Remove</button>
                                    </div>

                                    <hr>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-field" class="mt-2 mb-2 btn btn-info">Add Field</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('receipts.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
@endsection

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.7-beta.15/jquery.inputmask.min.js"></script> --}}
@push('js')
    {{-- CLONE FIELD PRODUCT, PRICE, QTY --}}

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Menggunakan jQuery untuk memudahkan pemilihan elemen dan manipulasi DOM
            $(document).on('change', '.product-select', function() {
                // Menyimpan referensi ke elemen yang berubah
                var $select = $(this);
                var $priceInput = $select.closest('.form-group').next('.form-group').find('.price-input');

                // Mendapatkan harga dari opsi yang dipilih
                var selectedOption = $select.find('option:selected');
                var price = selectedOption.data('price');

                // Memperbarui input harga
                $priceInput.val(price || '');
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Function to initialize Select2
            function initializeSelect2() {
                $('.select2').each(function() {
                    $(this).select2({
                        theme: 'bootstrap4'
                    });
                });
            }

            // Initialize Select2 for existing fields
            initializeSelect2();

            // Function to calculate total price
            function calculateTotalPrice() {
                let totalPrice = 0;

                $('.product-group').each(function() {
                    let price = $(this).find('.price-input').val().replace(/\./g, '').replace(/[^0-9]/g,
                        '');
                    let quantity = $(this).find('.quantity-input').val().replace(/\./g, '').replace(
                        /[^0-9]/g, '');

                    price = isNaN(price) ? 0 : parseInt(price);
                    quantity = isNaN(quantity) ? 0 : parseInt(quantity);

                    totalPrice += price * quantity;
                });

                $('#total_price').val(totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
            }

            // Calculate total price on input change
            $(document).on('input', '.price-input, .quantity-input', function() {
                calculateTotalPrice();
            });

            // Function to add new fields
            $('#add-field').click(function() {
                var newProductGroup = $('.product-group:first').clone();
                newProductGroup.find('input').val('');
                newProductGroup.find('select').each(function() {
                    $(this).removeClass('select2-hidden-accessible').removeData('select2').next(
                        '.select2-container').remove();
                    $(this).select2({
                        theme: 'bootstrap4'
                    });
                });
                var totalFields = $('.product-group').length + 1;
                newProductGroup.find('label[for="product_name"]').text('[' + totalFields +
                    '] Product Name:');
                $('#product-fields').append(newProductGroup);
                updateRemoveButtonVisibility();
            });

            // Function to remove fields
            $(document).on('click', '.remove-field', function() {
                $(this).closest('.product-group').remove();
                $('.product-group').each(function(index) {
                    $(this).find('label[for="product_name"]').text('[' + (index + 1) +
                        '] Product Name:');
                });
                updateRemoveButtonVisibility();
                calculateTotalPrice();
            });

            // Function to update remove button visibility
            function updateRemoveButtonVisibility() {
                if ($('.product-group').length > 1) {
                    $('.remove-field').show();
                } else {
                    $('.remove-field').hide();
                }
            }

            // Initial call to set the correct state of remove buttons
            updateRemoveButtonVisibility();

            // Handle form submission
            $('#payment-form').submit(function(event) {
                // Prevent default form submission
                event.preventDefault();

                // Calculate total price
                calculateTotalPrice();

                // Get the available cash
                let uangTunai = $('#uang_tunai').val().replace(/\./g, '').replace(/[^0-9]/g, '');
                uangTunai = isNaN(uangTunai) ? 0 : parseInt(uangTunai);

                // Get the total price
                let totalPrice = $('#total_price').val().replace(/\./g, '').replace(/[^0-9]/g, '');
                totalPrice = isNaN(totalPrice) ? 0 : parseInt(totalPrice);

                // Check if total price exceeds available cash
                if (totalPrice > uangTunai) {
                    alert("Total price cannot exceed payment amount.");
                } else {
                    // If valid, you can submit the form or perform the necessary action
                    // Uncomment the following line to actually submit the form
                    $(this).off('submit').submit();
                }
            });
        });
    </script>
@endpush
