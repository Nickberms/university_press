@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Point of Sale</title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    .recent-row {
        background-color: #FFC600;
    }
    #AddedItemsTable th,
    #AddedItemsTable td {
        white-space: nowrap;
    }
    #PurchaseHistoryTable th,
    #PurchaseHistoryTable td {
        white-space: nowrap;
    }
    .dataTables_paginate .paginate_button {
        display: none;
    }
    .dataTables_paginate .paginate_button.previous,
    .dataTables_paginate .paginate_button.next {
        display: inline-block;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini" style="font-family: Roboto, sans-serif;">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <a class="btn btn-primary" onClick="showPurchaseHistoryModal()" href="javascript:void(0)"
                style="background-color: #00491E; border-color: #00491E;">
                <i class="fas fa-history"></i>&nbsp;&nbsp;Purchase History
            </a>
            <br><br>
            <div class="row">
                <div class="col-sm-4" id="AddItemFormContainer">
                    <div class="card">
                        <!-- ADD ITEM FORM -->
                        <form id="AddItemForm" method="GET">
                            @csrf
                            <div class="card-header" style="background: #E9ECEF;">
                                <h3 class="card-title">Add Item</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-12" id="SelectImContainer">
                                        <label>Instructional Material</label>
                                        <select class="select2 form-control" id="SelectIm" style="width: 100%;"
                                            required>
                                        </select>
                                    </div>
                                    <div class="form-group col-12" id="SelectBatchContainer">
                                        <label>Batch</label>
                                        <select class="select2 form-control" id="SelectBatch" style="width: 100%;"
                                            required>
                                        </select>
                                    </div>
                                    <div class="form-group col-12" id="AvailableContainer">
                                        <label>Available Stocks</label>
                                        <input type="text" readonly class="form-control text-right"
                                            id="Available">
                                    </div>
                                    <div class="form-group col-12" id="QuantityContainer">
                                        <label>Quantity</label>
                                        <input type="number" oninput="numbersOnly(this)" class="form-control text-right"
                                            id="Quantity" required>
                                    </div>
                                    <div class="form-group col-12" id="PriceContainer">
                                        <label>Unit Price</label>
                                        <input type="text" readonly class="form-control text-right" id="Price">
                                    </div>
                                    <input type="hidden" readonly class="form-control text-right" id="TotalPrice">
                                </div>
                            </div>
                            <div class="card-footer" style="background: #E9ECEF;">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #00491E; border-color: #00491E;"><i
                                            class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                                </div>
                            </div>
                        </form>
                        <!-- ADD ITEM FORM -->
                    </div>
                </div>
                <div class="col-sm-8" id="AddedItemsTableContainer">
                    <div class="card">
                        <div class="card-header" style="background: #E9ECEF;">
                            <h3 class="card-title">Added Items</h3>
                            <div class="text-right">
                                <a class="btn btn-warning btn-sm" id="ExpandButton" onClick="toggleDivClasses()"
                                    href="javascript:void(0)">
                                    <i class="fas fa-expand"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- ADDED ITEMS TABLE -->
                            <table class="table" id="AddedItemsTable" style="font-size: 14px;">
                                <thead class="text-center">
                                    <tr style="display: none;">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                            <!-- ADDED ITEMS TABLE -->
                        </div>
                        <div class="card-footer" style="background: #E9ECEF;">
                            <h3 class="card-title text-left" style="font-size: 14px;">
                                <div id="DisplayTotalAmount">Total Amount: 0.00</div>
                            </h3>
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" id="ConfirmPurchaseButton"
                                    onClick="showConfirmPurchaseModal()"
                                    style="background-color: #00491E; border-color: #00491E;"><i
                                        class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <!-- PURCHASE HISTORY MODAL -->
        <div class="modal fade" id="PurchaseHistoryModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="background: #E9ECEF;">
                        <h4 class="modal-title">Purchase History</h4>
                        <button type="button" class="close" onClick="hidePurchaseHistoryModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: #02681E;">
                        <div class="card">
                            <div class="card-body">
                                <!-- PURCHASE HISTORY TABLE -->
                                <table class="table table-bordered table-striped" id="PurchaseHistoryTable" style="font-size: 14px;">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>OR Number</th>
                                            <th>Instructional Material</th>
                                            <th>Batch</th>
                                            <th>Date Sold</th>
                                            <th>Quantity Sold</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                <!-- PURCHASE HISTORY TABLE -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PURCHASE HISTORY MODAL -->
        <!-- CONFIRM PURCHASE MODAL -->
        <div class="modal fade" id="ConfirmPurchaseModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- CONFIRM PURCHASE FORM -->
                    <form id="ConfirmPurchaseForm" method="POST">
                        @csrf
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Confirm Purchase</h4>
                            <button type="button" class="close" onClick="hideConfirmPurchaseModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- LEFT SIDE -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Customer Name</label>
                                                    <input type="text" class="form-control" name="customer_name"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>OR Number</label>
                                                    <input type="text" class="form-control" name="or_number" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Date Sold</label>
                                                    <input type="date" class="form-control" name="date_sold" required>
                                                </div>
                                            </div>
                                            <!-- LEFT SIDE -->
                                            <!-- RIGHT SIDE -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cash</label>
                                                    <input type="text" oninput="calculateChange(this)"
                                                        onpaste="return false;" class="form-control text-right"
                                                        name="cash">
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="TotalAmount" name="total_amount">
                                                </div>
                                                <div class="form-group">
                                                    <label>Change</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="Change">
                                                </div>
                                            </div>
                                            <!-- RIGHT SIDE -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <div class="text-right">
                                <button type="button" class="btn btn-danger" onClick="hideConfirmPurchaseModal()"
                                    href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #00491E; border-color: #00491E;"><i
                                        class="fas fa-check"></i>&nbsp;&nbsp;Confirm</button>
                            </div>
                        </div>
                    </form>
                    <!-- CONFIRM PURCHASE FORM -->
                </div>
            </div>
        </div>
        <!-- CONFIRM PURCHASE MODAL -->
    </div>
    <script>
    $('#AddItemForm').submit(function(event) {
        event.preventDefault();
        var imId = $('#SelectIm').val();
        var batchId = $('#SelectBatch').val();
        var quantity = parseInt($('#Quantity').val());
        var price = parseFloat($('#Price').val().replace(/,/g, ''));
        var totalPrice = parseFloat($('#TotalPrice').val());
        if (quantity <= 0) {
            return;
        } else {
            var table = $('#AddedItemsTable').DataTable();
            var existingRow = table.rows().data().toArray().find(function(row) {
                return row[2].includes('value="' + imId + '"') && row[4].includes('value="' +
                    batchId + '"');
            });
            if (existingRow) {
                var existingQuantity = parseInt(existingRow[7]);
                var existingTotalPrice = parseFloat(existingRow[12].replace(/,/g, ''));
                var newQuantity = existingQuantity + quantity;
                var newTotalPrice = existingTotalPrice + totalPrice;
                var quantityInput = '<input type="hidden" name="quantity[]" value="' + newQuantity + '">';
                existingRow[7] = newQuantity + quantityInput;
                existingRow[12] = newTotalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                var rowIndex = table.rows().data().toArray().findIndex(function(row) {
                    return row[2].includes('value="' + imId + '"') && row[4].includes(
                        'value="' +
                        batchId + '"');
                });
                table.row(rowIndex).data(existingRow).draw(false);
                $('#AddedItemsTable tbody tr').removeClass('recent-row');
                table.row(rowIndex).node().classList.add('recent-row');
            } else {
                var imIdInput = '<input type="hidden" name="im_id[]" value="' + imId + '">';
                var batchIdInput = '<input type="hidden" name="batch_id[]" value="' + batchId + '">';
                var quantityInput = '<input type="hidden" name="quantity[]" value="' + quantity + '">';
                var newRow = [
                    '<div class="text-right">' +
                    '<a href="#" class="delete"><i class="material-icons">&#xE872;</i></a>' +
                    '</div>',
                    '<p class="text-right" style="font-weight: bold;"> Instructional Material: </p>',
                    $('#SelectIm option:selected').text() + imIdInput,
                    '<p class="text-right" style="font-weight: bold;"> Batch: </p>',
                    $('#SelectBatch option:selected').text() + batchIdInput,
                    '<p class="text-right" style="font-weight: bold;"> Quantity: </p>',
                    '<div class="text-right">' +
                    '<a href="#" class="minus-icon"><i class="fas fa-minus" style="color: #00491E;"></i></a>' +
                    '</div>',
                    quantity + quantityInput,
                    '<div class="text-left">' +
                    '<a href="#" class="plus-icon"><i class="fas fa-plus" style="color: #00491E;"></i></a>' +
                    '</div>',
                    '<p class="text-right" style="font-weight: bold;"> Unit Price: </p>',
                    price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","),
                    '<p class="text-right" style="font-weight: bold;"> Total Price: </p>',
                    totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                ];
                var rowNode = table.row.add(newRow).draw(false).node();
                $('#AddedItemsTable tbody tr').removeClass('recent-row');
                $(rowNode).addClass('recent-row');
            }
            var totalAmount = 0;
            table.rows().every(function() {
                var rowData = this.data();
                var rowTotalPrice = parseFloat(rowData[12].replace(/,/g, ''));
                totalAmount += rowTotalPrice;
            });
            $('#TotalAmount').val(totalAmount.toFixed(2));
            calculateTotalAmount();
        }
    });
    $('#AddedItemsTable tbody').on('click', '.delete', function() {
        var table = $('#AddedItemsTable').DataTable();
        var row = $(this).closest('tr');
        table.row(row).remove().draw(false);
        calculateTotalAmount();
    });
    $('#AddedItemsTable tbody').on('click', '.minus-icon', function() {
        var table = $('#AddedItemsTable').DataTable();
        var row = $(this).closest('tr');
        var rowData = table.row(row).data();
        var quantityCell = table.cell(row, 7);
        var unitPriceCell = table.cell(row, 10);
        var currentQuantity = parseInt(quantityCell.data());
        if (currentQuantity > 0) {
            quantityCell.data(currentQuantity - 1).draw(false);
            var newQuantity = currentQuantity - 1;
            var quantityInput = '<input type="hidden" name="quantity[]" value="' + newQuantity + '">';
            var unitPrice = parseFloat(unitPriceCell.data().replace(/,/g, ''));
            var newTotalPrice = newQuantity * unitPrice;
            var totalPriceCell = table.cell(row, 12);
            totalPriceCell.data(newTotalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")).draw(false);
            var existingRow = table.row(row).data();
            if (existingRow) {
                existingRow[7] = newQuantity + quantityInput;
                existingRow[12] = newTotalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                table.row(row).data(existingRow).draw(false);
            }
        }
        if (currentQuantity === 1) {
            table.row(row).remove().draw(false);
        }
        $('#AddedItemsTable tbody tr').removeClass('recent-row');
        row.addClass('recent-row');
        calculateTotalAmount();
    });
    $('#AddedItemsTable tbody').on('click', '.plus-icon', function() {
        var table = $('#AddedItemsTable').DataTable();
        var row = $(this).closest('tr');
        var rowData = table.row(row).data();
        var quantityCell = table.cell(row, 7);
        var unitPriceCell = table.cell(row, 10);
        var currentQuantity = parseInt(quantityCell.data());
        quantityCell.data(currentQuantity + 1).draw(false);
        var newQuantity = currentQuantity + 1;
        var quantityInput = '<input type="hidden" name="quantity[]" value="' + newQuantity + '">';
        var unitPrice = parseFloat(unitPriceCell.data().replace(/,/g, ''));
        var newTotalPrice = newQuantity * unitPrice;
        var totalPriceCell = table.cell(row, 12);
        totalPriceCell.data(newTotalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")).draw(false);
        var existingRow = table.row(row).data();
        if (existingRow) {
            existingRow[7] = newQuantity + quantityInput;
            existingRow[12] = newTotalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            table.row(row).data(existingRow).draw(false);
        }
        $('#AddedItemsTable tbody tr').removeClass('recent-row');
        row.addClass('recent-row');
        calculateTotalAmount();
    });
    function populateAddItemForm() {
        $.ajax({
            url: "{{ route('purchases.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectIm = $('#SelectIm');
                selectIm.empty();
                response.forEach(function(im) {
                    selectIm.append('<option value="' + im.id + '">' + im.title +
                        '</option>');
                });
                selectIm.val(null).trigger('change');
                selectIm.select2();
                $('#SelectIm').on('change', function() {
                    $('#TotalPrice').val(null);
                    var imId = $(this).val();
                    if (imId) {
                        var selectedIm = response.find(function(im) {
                            return im.id == imId;
                        });
                        var batches = selectedIm.batches;
                        var selectBatch = $('#SelectBatch');
                        selectBatch.empty();
                        batches.forEach(function(batch) {
                            selectBatch.append('<option value="' + batch.id + '">' + batch
                                .name + '</option>');
                        });
                        selectBatch.val(null).trigger('change');
                        selectBatch.select2();
                    }
                });
                $('#SelectBatch').on('change', function() {
                    $('#Quantity').val(null);
                    $('#TotalPrice').val(null);
                    var batchId = $(this).val();
                    if (batchId) {
                        var selectedIm = response.find(function(im) {
                            return im.id == $('#SelectIm').val();
                        });
                        var selectedBatch = selectedIm.batches.find(function(
                            batch) {
                            return batch.id == batchId;
                        });
                        var available = selectedBatch.quantity_produced - selectedBatch
                            .total_quantity_deducted;
                        $('#Available').val(available);
                        $('#Price').val(selectedBatch.price.toFixed(2).replace(
                            /\B(?=(\d{3})+(?!\d))/g, ","));
                    } else {
                        $('#Available').val(null);
                        $('#Quantity').val(null);
                        $('#Price').val(null);
                    }
                });
                $('#Quantity, #Price').on('input', function() {
                    var quantity = parseInt($('#Quantity').val()) || 0;
                    var price = parseFloat($('#Price').val().replace(/,/g, '')) || 0;
                    var totalPrice = quantity * price;
                    $('#TotalPrice').val(totalPrice.toFixed(2));
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function disableExpandButton() {
        var expandButton = document.getElementById('ExpandButton');
        if (window.innerWidth < 576) {
            expandButton.style.display = 'none';
        } else {
            expandButton.style.display = 'inline-block';
        }
    }
    function toggleDivClasses() {
        var addItemFormContainer = document.getElementById("AddItemFormContainer");
        var addedItemsTableContainer = document.getElementById("AddedItemsTableContainer");
        var selectImContainer = document.getElementById("SelectImContainer");
        var selectBatchContainer = document.getElementById("SelectBatchContainer");
        var availableContainer = document.getElementById("AvailableContainer");
        var quantityContainer = document.getElementById("QuantityContainer");
        var priceContainer = document.getElementById("PriceContainer");
        if (addItemFormContainer.className === "col-sm-4") {
            addItemFormContainer.className = "col-sm-12";
            addedItemsTableContainer.className = "col-sm-12";
            selectImContainer.className = "form-group col-6";
            selectBatchContainer.className = "form-group col-6";
            availableContainer.className = "form-group col-4";
            quantityContainer.className = "form-group col-4";
            priceContainer.className = "form-group col-4";
        } else {
            addItemFormContainer.className = "col-sm-4";
            addedItemsTableContainer.className = "col-sm-8";
            selectImContainer.className = "form-group col-12";
            selectBatchContainer.className = "form-group col-12";
            availableContainer.className = "form-group col-12";
            quantityContainer.className = "form-group col-12";
            priceContainer.className = "form-group col-12";
        }
    }
    function calculateTotalAmount() {
        var totalAmount = 0;
        var table = $('#AddedItemsTable').DataTable();
        table.rows().every(function() {
            var rowData = this.data();
            var rowTotalPrice = parseFloat(rowData[12].replace(/,/g, ''));
            totalAmount += rowTotalPrice;
        });
        $('#TotalAmount').val(totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        document.getElementById('DisplayTotalAmount').innerText = "Total Amount: " + totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function checkAddedItemsTableRows() {
        var table = $('#AddedItemsTable').DataTable();
        var rowCount = table.rows().count();
        if (rowCount > 0) {
            $('#ConfirmPurchaseButton').prop('disabled', false);
        } else {
            $('#ConfirmPurchaseButton').prop('disabled', true);
        }
    }
    function showPurchaseHistoryModal() {
        $('#PurchaseHistoryModal').modal('show');
        $('#PurchaseHistoryModal').on('shown.bs.modal', function(e) {
            refreshPurchaseHistoryTable();
        });
    }
    function hidePurchaseHistoryModal() {
        $('#PurchaseHistoryModal').modal('hide');
    }
    function refreshPurchaseHistoryTable() {
        $.ajax({
            url: "{{ route('purchases.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#PurchaseHistoryTable').DataTable();
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
                        '<span style="float: right;">' + purchase.quantity + '</span>',
                        '<span style="float: right;">' + monetaryValue(purchase.batch.price
                            .toFixed(2)) + '</span>',
                        '<span style="float: right;">' + monetaryValue(totalPrice.toFixed(
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
    function showConfirmPurchaseModal() {
        calculateTotalAmount();
        $('#ConfirmPurchaseModal').modal('show');
    }
    function hideConfirmPurchaseModal() {
        $('#ConfirmPurchaseModal').modal('hide');
    }
    $('#ConfirmPurchaseForm').submit(function(event) {
        event.preventDefault();
        var purchasedItems = [];
        $('#AddedItemsTable tbody tr').each(function() {
            var customerName = $('input[name="customer_name"]').val();
            var orNumber = $('input[name="or_number"]').val();
            var imId = $(this).find('input[name="im_id[]"]').val();
            var batchId = $(this).find('input[name="batch_id[]"]').val();
            var dateSold = $('input[name="date_sold"]').val();
            var quantity = $(this).find('input[name="quantity[]"]').val();
            var item = {
                customer_name: customerName,
                or_number: orNumber,
                im_id: imId,
                batch_id: batchId,
                date_sold: dateSold,
                quantity: quantity
            };
            purchasedItems.push(item);
        });
        $.ajax({
            url: "{{ route('purchases.store') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                purchased_items: purchasedItems
            },
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideConfirmPurchaseModal();
                toastr.success(successMessage);
                var table = $('#AddedItemsTable').DataTable();
                table.clear().draw();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    function numbersOnly(inputField) {
        var pattern = /^[0-9]+$/;
        var inputValue = inputField.value;
        if (!pattern.test(inputValue)) {
            inputField.value = inputValue.replace(/[^0-9]/g, '');
        }
    }
    function calculateChange(cashInput) {
        function cleanAndFormatValue(inputValue) {
            var cleanedValue = inputValue.replace(/[^\d.]/g, '').replace(/\.(?=.*\.)/g, '');
            var parts = cleanedValue.split('.');
            if (parts.length > 2) {
                cleanedValue = parts.slice(0, -1).join('') + '.' + parts.pop();
            }
            var integerPart = cleanedValue.split('.')[0];
            var formattedIntegerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            return formattedIntegerPart + (parts.length > 1 ? '.' + parts[1] : '');
        }
        var inputValue = cashInput.value;
        var cleanedValue = cleanAndFormatValue(inputValue);
        cashInput.value = cleanedValue;
        var cash = parseFloat(cleanedValue.replace(/,/g, ''));
        var totalAmount = parseFloat($('#TotalAmount').val().replace(/,/g, ''));
        var change = cash - totalAmount;
        $('#Change').val(change.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }
    $(document).ready(function() {
        populateAddItemForm();
        $('#AddedItemsTable').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            "scrollX": true,
            "scrollY": true,
            "scrollCollapse": false
        }).buttons().container().appendTo('#AddedItemsTable_wrapper .col-md-6:eq(0)');
        disableExpandButton();
        window.addEventListener('resize', disableExpandButton);
        checkAddedItemsTableRows();
        $('#AddedItemsTable').on('draw.dt', function() {
            checkAddedItemsTableRows();
        });
        $('#PurchaseHistoryTable').DataTable({
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
            "buttons": ["copy", "excel", "pdf"],
            "pageLength": 8
        }).buttons().container().appendTo('#PurchaseHistoryTable_wrapper .col-md-6:eq(0)');
        setInterval(refreshPurchaseHistoryTable, 60000);
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshPurchaseHistoryTable();
                previousWidth = currentWidth;
            }
        });
        $('#ConfirmPurchaseModal').on('hidden.bs.modal', function(e) {
            $('#AddItemForm')[0].reset();
            $('#AddItemForm select').val(null).trigger('change');
            populateAddItemForm();
            $('#ConfirmPurchaseForm')[0].reset();
            $('#ConfirmPurchaseModal select').val(null).trigger('change');
        });
    });
    </script>
</body>

</html>
@endsection