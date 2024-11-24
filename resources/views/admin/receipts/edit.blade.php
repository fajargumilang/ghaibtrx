@extends('layout.backend.app', [
    'title' => 'Edit Receipt Print',
    'pageTitle' => 'Edit Receipt Print',
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
            <form id="payment-form" action="{{ route('receipts.update', $receipt->id) }}" method="POST">
                @csrf
                @method('PUT')


                <div class="row">
                    <!-- Form Column -->
                    <div class="col-md-6">
                        <h5><strong>Store Data</strong></h5>
                        <hr>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="store_name">Store Name:</label>
                                <input type="text" class="form-control @error('store_name') is-invalid @enderror"
                                    id="store_name" name="store_name" value="{{ old('store_name', $receipt->store_name) }}">
                                @error('store_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="address">Address:</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address', $receipt->address) }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="hp">HP:</label>
                                <input type="number" class="form-control  @error('hp') is-invalid @enderror" id="hp"
                                    name="hp" placeholder="ex: 0812 8888 1111" value="{{ old('hp', $receipt->hp) }}">
                                @error('hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label for="trans">Trans:</label>
                                <input type="number" class="form-control  @error('trans') is-invalid @enderror"
                                    id="trans" name="trans" placeholder="ex: 1155509001"
                                    value="{{ old('trans', $receipt->trans) }}">
                                @error('trans')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="kassa">Kassa:</label>
                                <input type="number" class="form-control  @error('kassa') is-invalid @enderror"
                                    id="kassa" name="kassa" placeholder="ex: 003"
                                    value="{{ old('kassa', $receipt->kassa) }}">
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
                                    value="{{ old('name_of_kassa', $receipt->name_of_kassa) }}">
                                @error('name_of_kassa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" class="form-control  @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal"
                                    value="{{ old('tanggal', \Carbon\Carbon::parse($receipt->tanggal)->format('Y-m-d')) }}">
                                @error('tanggal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-6">
                                <label for="time_transaction">Time Transaction:</label>
                                <input type="time" class="form-control @error('time_transaction') is-invalid @enderror"
                                    id="time_transaction" name="time_transaction"
                                    value="{{ old('time_transaction', \Carbon\Carbon::parse($receipt->time_transaction)->format('H:i')) }}"
                                    placeholder="ex: 11:55">

                                @error('time_transaction')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5><strong>Informations - (Optional)</strong></h5>
                                <hr>
                            </div>
                            <div class="form-group col-6">
                                <label for="member">Member:</label>
                                <input type="text" class="form-control @error('member') is-invalid @enderror"
                                    id="member" name="member" value="{{ old('member', $receipt->member) }}">
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
                                    value="{{ old('name_of_customer', $receipt->name_of_customer) }}">
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
                                    value="{{ old('pt_akhir', $receipt->pt_akhir) }}">
                                @error('pt_akhir')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5><strong>Payment</strong></h5>
                                <hr>
                            </div>
                            <div class="form-group col-6">
                                <label for="paymentMethod">Payment Method:</label>
                                <select class="form-control @error('payment_method') is-invalid @enderror"
                                    id="paymentMethod" name="payment_method">
                                    <option value="">-= Select Payment Method =-</option>
                                    <option value="cash"
                                        {{ old('payment_method', $receipt->payment_method) == 'cash' ? 'selected' : '' }}>
                                        Cash</option>
                                    <option value="card"
                                        {{ old('payment_method', $receipt->payment_method) == 'card' ? 'selected' : '' }}>
                                        Card</option>
                                    <option value="online"
                                        {{ old('payment_method', $receipt->payment_method) == 'online' ? 'selected' : '' }}>
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
                                    value="{{ old('anda_hemat', $receipt->anda_hemat) }}">
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
                                    value="{{ old('total_price', $receipt->final_amount) }}" readonly>
                            </div>

                            <div class="form-group col-6">
                                <label for="uang_tunai">Payment :</label>
                                <input type="number" class="form-control  @error('uang_tunai') is-invalid @enderror"
                                    id="uang_tunai" name="uang_tunai" placeholder="ex: 500.000"
                                    value="{{ old('uang_tunai', $receipt->uang_tunai) }}">
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
                            @foreach ($receipt->items as $index => $item)
                                <div class="product-group">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                            <label for="product_name">[{{ $index + 1 }}] Product Name:</label>
                                            <select class="select2 form-control product-select" name="product_name[]">
                                                <option value="">-= Select Product =-</option>
                                                @foreach ($products as $prod)
                                                    <option value="{{ $prod->name }}" data-price="{{ $prod->price }}"
                                                        {{ $item->product_name == $prod->name ? 'selected' : '' }}>
                                                        {{ $prod->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error("product_name.$index")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                            <label for="price">Price:</label>
                                            <input type="text" class="form-control price-input" name="price[]"
                                                data-original-price="{{ $item->price }}"
                                                data-index="{{ $index }}"
                                                value="{{ number_format(old("price.$index", $item->price), 0, ',', '.') }}"
                                                readonly>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                            <label for="quantity">Quantity:</label>
                                            <input type="number" class="form-control quantity-input" name="quantity[]"
                                                data-index="{{ $index }}" min="1"
                                                value="{{ old("quantity.$index", $item->quantity) }}"
                                                onchange="updatePrice(this)">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <hr>
                                            <button type="button"
                                                class="float-right btn btn-danger remove-field">Remove</button>


                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="deleted_items" name="deleted_items" value="[]">

                        <button type="button" id="add-field" class="btn btn-info">Add Field</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('receipts.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Similar JavaScript as in create.blade.php for handling dynamic fields
        });
    </script>
    <script>
        $(document).ready(function() {
            // Tangani klik tombol "Remove"
            $('.remove-field').click(function() {
                var productGroup = $(this).closest(
                    '.product-group'); // Ambil elemen .product-group yang berhubungan
                var productName = productGroup.find('.product-select')
                    .val(); // Ambil nilai dari select product_name

                if (productName) {
                    // Ambil nilai deleted_items yang sudah ada
                    var deletedItems = JSON.parse($('#deleted_items')
                        .val()); // Parse string JSON menjadi array

                    // Masukkan nama produk yang dihapus ke dalam array
                    deletedItems.push(productName); // Bisa juga menyimpan ID produk, tergantung kebutuhan

                    // Update nilai input hidden deleted_items dengan array yang baru
                    $('#deleted_items').val(JSON.stringify(
                        deletedItems)); // Ubah array menjadi string JSON dan set ke input hidden
                }

                // Hapus elemen produk
                productGroup.remove();
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

            // Update price when product is selected
            $(document).on('change', '.product-select', function() {
                let selectedOption = $(this).find('option:selected');
                let price = selectedOption.data('price') || 0;
                let priceInput = $(this).closest('.product-group').find('.price-input');

                priceInput.val(price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'));

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

            let deletedItems = [];

            function removeProduct(button) {
                const productItem = button.closest('.product-group');
                const productId = productItem.dataset.productId; // Get the product ID

                // Add product ID to deletedItems array
                deletedItems.push(productId);

                // Update the hidden input field with the deleted items array
                document.getElementById('deleted_items').value = JSON.stringify(deletedItems);

                // Remove the product group from the UI
                productItem.remove();
            }

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
                event.preventDefault();
                calculateTotalPrice();

                let uangTunai = $('#uang_tunai').val().replace(/\./g, '').replace(/[^0-9]/g, '');
                uangTunai = isNaN(uangTunai) ? 0 : parseInt(uangTunai);

                let totalPrice = $('#total_price').val().replace(/\./g, '').replace(/[^0-9]/g, '');
                totalPrice = isNaN(totalPrice) ? 0 : parseInt(totalPrice);

                if (totalPrice > uangTunai) {
                    alert("Total price cannot exceed payment amount.");
                } else {
                    $(this).off('submit').submit();
                }
            });
        });
    </script>
@endpush
