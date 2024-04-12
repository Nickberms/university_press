@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Purchase History</title>
    <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
    <link rel="icon" href="images/cmu_press_logo.png" type="image/png">
    <script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="admin/plugins/toastr/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body class="hold-transition sidebar-mini" style="font-family: Roboto, sans-serif">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <a class="btn btn-primary" onClick="showNewPurchaseModal()" href="javascript:void(0)"
                style="background-color: #00491E; border-color: #00491E;">
                <i class="fas fa-plus"></i> New Purchase
            </a>
            <br><br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchase History</h3>
                </div>
                <div class="card-body">
                    <!-- PURCHASES TABLE -->
                    <table class="table table-bordered table-striped" id="PurchasesTable">
                        <thead class="text-center">
                            <tr>
                                <th>Customer Name</th>
                                <th>OR Number</th>
                                <th>Instructional Material</th>
                                <th>IM Batch</th>
                                <th>Date Sold</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- PURCHASES TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- NEW PURCHASE MODAL -->
        <div class="modal fade" id="NewPurchaseModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Purchase</h4>
                    </div>
                    <div class="modal-body">
                        <form id="PurchaseSummaryForm" method="POST">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Customer Name</label>
                                                    <input type="text" class="form-control" id="CustomerName"
                                                        placeholder="Enter Customer Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>OR Number</label>
                                                    <input type="text" class="form-control" id="OrNumber"
                                                        placeholder="Enter OR Number" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Date Sold</label>
                                                    <input type="date" class="form-control" id="DateSold" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="text" readonly class="form-control" id="TotalAmount"
                                                        value="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- NEW PURCHASE FORM -->
                        <form id="NewPurchaseForm" method="POST" style="display: none;">
                            @csrf
                            <input type="text" class="customer-name-mirror" name="customer_name">
                            <input type="text" class="or-number-mirror" name="or_number">
                            <input type="text" class="date-sold-mirror" name="date_sold">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Instructional Material</label>
                                                    <select id="ChooseInstructionalMaterial"
                                                        name="instructional_material"
                                                        data-placeholder="Select Instructional Material"
                                                        style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>IM Batch</label>
                                                    <select id="ChooseImBatch" name="im_batch"
                                                        data-placeholder="Select IM Batch" style="width: 100%;"
                                                        required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Price</label>
                                                    <input type="text" readonly class="form-control" id="Price"
                                                        name="price">
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity</label>
                                                    <select id="ChooseQuantity" name="quantity"
                                                        data-placeholder="Select Quantity" style="width: 100%;"
                                                        required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Price</label>
                                                    <input type="text" readonly class="form-control total-price"
                                                        id="TotalPrice" name="total_price">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- NEW PURCHASE FORM -->


                        <div id="NewPurchaseFormContainer"></div>



                        <div class="text-right">
                            <button type="button" class="btn btn-danger" onClick="hideNewPurchaseModal()"
                                href="javascript:void(0)">Cancel</button>
                            <button type="button" class="btn btn-primary" onClick="submitAllForms()">Record
                                Purchase</button>
                            <button type="button" class="btn btn-primary" onClick="addItem()">Add Item</button>
                            <button type="button" class="btn btn-danger" onClick="removeItem()">Remove Item</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- NEW PURCHASE MODAL -->
    </div>


    <script type="text/javascript">
    function showNewPurchaseModal() {
        $('#NewPurchaseModal').modal('show');
        addItem();
    }

    function hideNewPurchaseModal() {
        $('#NewPurchaseModal').modal('hide');
    }



    function mirrorCustomerName() {
        const sourceInput = document.getElementById('CustomerName');
        const mirrorInputs = document.querySelectorAll('.customer-name-mirror');
        sourceInput.addEventListener('input', function() {
            mirrorInputs.forEach(input => {
                input.value = sourceInput.value;
            });
        });
    }
    const customerNameInput = document.getElementById('CustomerName');
    customerNameInput.addEventListener('input', mirrorCustomerName);

    function mirrorOrNumber() {
        const sourceInput = document.getElementById('OrNumber');
        const mirrorInputs = document.querySelectorAll('.or-number-mirror');
        sourceInput.addEventListener('input', function() {
            mirrorInputs.forEach(input => {
                input.value = sourceInput.value;
            });
        });
    }
    const orNumberInput = document.getElementById('OrNumber');
    orNumberInput.addEventListener('input', mirrorOrNumber);

    function mirrorDateSold() {
        const sourceInput = document.getElementById('DateSold');
        const mirrorInputs = document.querySelectorAll('.date-sold-mirror');
        sourceInput.addEventListener('change', function() {
            mirrorInputs.forEach(input => {
                input.value = sourceInput.value;
            });
        });
    }
    const dateSoldInput = document.getElementById('DateSold');
    dateSoldInput.addEventListener('input', mirrorDateSold);

    function calculateTotal() {
        const totalPrices = document.querySelectorAll('.total-price');
        let totalAmount = 0.00;
        totalPrices.forEach(input => {
            totalAmount += parseFloat(input.value) || 0.00;
        });
        document.getElementById('TotalAmount').value = totalAmount.toFixed(2);
    }










    var formCounter = 1;

    function addItem() {
        var clonedForm = $('#NewPurchaseForm').clone();
        clonedForm.find('[id]').each(function() {
            var currentId = $(this).attr('id');
            var newId = currentId + '-' + formCounter;
            $(this).attr('id', newId);
        });
        // clonedForm.find('[name]').each(function() {
        //     var currentName = $(this).attr('name');
        //     var newName = currentName + '-' + formCounter;
        //     $(this).attr('name', newName);
        // });
        $('#NewPurchaseFormContainer').append(clonedForm);
        refreshCsrfTokens();
        clonedForm.show();
        clonedForm.addClass('new-purchase-form');
        clonedForm.find('.select2').select2();
        var clonedFunction = populateNewPurchaseFormFields(formCounter);
        clonedFunction();
        formCounter++;
    }

    function removeItem() {
        if (formCounter > 2) {
            const latestForm = $('#NewPurchaseFormContainer').children().last();
            latestForm.find('*').remove();
            calculateTotal();
            latestForm.remove();
            formCounter--;
        }
    }





    function populateNewPurchaseFormFields(idSuffix) {
        var selectInstructionalMaterial = $('#ChooseInstructionalMaterial-' + idSuffix);
        selectInstructionalMaterial.select2();
        var selectImBatch = $('#ChooseImBatch-' + idSuffix);
        selectImBatch.select2();
        var selectQuantity = $('#ChooseQuantity-' + idSuffix);
        selectQuantity.select2();
        return function() {
            $.ajax({
                url: "{{ route('purchases.create') }}",
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    selectInstructionalMaterial.empty();
                    response.forEach(function(im) {
                        selectInstructionalMaterial.append('<option value="' + im.id + '">' + im
                            .title +
                            '</option>');
                    });
                    selectInstructionalMaterial.val(null).trigger('change');
                    $('#ChooseInstructionalMaterial-' + idSuffix).on('change', function() {
                        $('#TotalPrice-' + idSuffix).val(null);
                        var imId = $(this).val();
                        if (imId) {
                            var selectedInstructionalMaterial = response.find(function(im) {
                                return im.id == imId;
                            });
                            var batches = selectedInstructionalMaterial.batches;
                            selectImBatch.empty();
                            batches.forEach(function(batch) {
                                selectImBatch.append('<option value="' + batch.id +
                                    '">' + batch
                                    .name + '</option>');
                            });
                            selectImBatch.val(null).trigger('change');
                            calculateTotal();
                        }
                    });
                    $('#ChooseImBatch-' + idSuffix).on('change', function() {
                        $('#TotalPrice-' + idSuffix).val(null);
                        var batchId = $(this).val();
                        if (batchId) {
                            var selectedInstructionalMaterial = response.find(function(im) {
                                return im.id == $('#ChooseInstructionalMaterial-' +
                                    idSuffix).val();
                            });
                            var selectedBatch = selectedInstructionalMaterial.batches.find(
                                function(
                                    batch) {
                                    return batch.id == batchId;
                                });
                            $('#Price-' + idSuffix).val(selectedBatch.price.toFixed(2));
                            calculateTotal();
                            selectQuantity.empty();
                            var availableStocks = selectedBatch.quantity_produced -
                                selectedBatch
                                .quantity_sold;
                            for (var i = 1; i <= availableStocks; i++) {
                                selectQuantity.append('<option value="' + i + '">' + i +
                                    '</option>');
                            }
                            selectQuantity.val(null).trigger('change');
                        } else {
                            $('#Price-' + idSuffix).val(null);
                            $('#ChooseQuantity-' + idSuffix).empty();
                        }
                    });
                    $('#Price-' + idSuffix + ', #ChooseQuantity-' + idSuffix).on('input', function() {
                        var price = parseFloat($('#Price-' + idSuffix).val()) || 0;
                        var quantity = parseInt($('#ChooseQuantity-' + idSuffix).val()) || 0;
                        var totalPrice = price * quantity;
                        $('#TotalPrice-' + idSuffix).val(totalPrice.toFixed(2));
                        calculateTotal();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        };
    }

    function refreshCsrfTokens() {
        fetch('/csrf-token') // Assuming you have a route like this
            .then(response => response.json())
            .then(data => {
                const clonedForms = $('.new-purchase-form');
                clonedForms.each(function() {
                    $(this).find('input[name="_token"]').val(data.token);
                });
            });
    }




    function submitAllForms() {
        const clonedForms = $('.new-purchase-form');
        clonedForms.each(function() {
            event.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: "{{ route('purchases.store') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideNewPurchaseModal();
                    toastr.success(successMessage);
                    refreshPurchasesTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        });
    }



    function refreshPurchasesTable() {
        $.ajax({
            url: "{{ route('purchases.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#PurchasesTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(purchase) {
                    var formattedDateSold = new Date(purchase.date_sold);
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var formattedDateSoldString = formattedDateSold.toLocaleDateString('en-US',
                        options);
                    var totalPrice = purchase.batch.price.toFixed(2) * purchase.quantity;

                    function monetaryValue(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    table.row.add([
                        purchase.customer_name,
                        purchase.or_number,
                        purchase.im.title,
                        purchase.batch.name,
                        formattedDateSoldString,
                        '<span style="float:right;">' + monetaryValue(purchase.batch.price
                            .toFixed(2)) + '</span>',
                        '<span style="float:right;">' + purchase.quantity + '</span>',
                        '<span style="float:right;">' + monetaryValue(totalPrice.toFixed(
                            2)) + '</span>'
                    ]);
                });
                table.draw();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function NumbersOnly(inputField) {
        var pattern = /^[0-9]+$/;
        var inputValue = inputField.value;
        if (!pattern.test(inputValue)) {
            inputField.value = inputValue.replace(/[^0-9]/g, '');
        }
    }
    $(document).ready(function() {
        $('#PurchasesTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": false,
            "scrollX": true,
            "scrollY": true,
            "scrollCollapse": false,
            "buttons": ["copy", "excel", "pdf", "print"],
            "pageLength": 8
        }).buttons().container().appendTo('#PurchasesTable_wrapper .col-md-6:eq(0)');
        refreshPurchasesTable();
        setInterval(refreshPurchasesTable, 60000);

        $('#NewPurchaseModal').on('hidden.bs.modal', function(e) {
            $('#PurchaseSummaryForm')[0].reset();
            $('#PurchaseSummaryForm select').val(null).trigger('change');
            $('#NewPurchaseForm')[0].reset();
            $('#NewPurchaseForm select').val(null).trigger('change');
            $('form[id^="NewPurchaseForm-"], input[id], select[id]').each(function() {
                if (this.type === 'select-one' || this.type === 'select-multiple') {
                    $(this).val(null).trigger('change');
                } else {
                    this.value = '';
                }
            });
            $('input[name], select[name]').each(function() {
                if (this.type === 'select-one' || this.type === 'select-multiple') {
                    $(this).val(null).trigger('change');
                } else {
                    this.value = '';
                }
            });
        });

        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshPurchasesTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection