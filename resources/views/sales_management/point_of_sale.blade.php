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
            <div class="card">
                <!-- ADD ITEM FORM -->
                <form id="AddItemForm" method="GET">
                    @csrf
                    <div class="card-header" style="background: #E9ECEF;">
                        <h3 class="card-title">Add Item</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Select IM</label>
                                <select class="select2 form-control" id="SelectIm" name="select_im" style="width: 100%;"
                                    required>
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Select Batch</label>
                                <select class="select2 form-control" id="SelectBatch" name="select_batch"
                                    style="width: 100%;" required>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group col-4">
                                <label>Quantity</label>
                                <select class="select2 form-control" id="SelectQuantity" name="select_quantity"
                                    style="width: 100%;" required>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label>Price</label>
                                <input type="text" readonly class="form-control" id="Price" name="price">
                            </div>
                            <div class="form-group col-4">
                                <label>Total Price</label>
                                <input type="text" readonly class="form-control" id="TotalPrice" name="total_price">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="background: #E9ECEF;">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-plus"></i>&nbsp;&nbsp;Add Item</button>
                        </div>
                    </div>
                </form>
                <!-- ADD ITEM FORM -->
            </div>
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Added Items</h3>
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
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" id="ConfirmPurchaseButton"
                            onClick="showConfirmPurchaseModal()"
                            style="background-color: #00491E; border-color: #00491E;"><i
                                class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Confirm Purchase</button>
                    </div>
                </div>
            </div>
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
                                <table class="table table-bordered table-striped" id="PurchaseHistoryTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th>Customer Name</th>
                                            <th>OR Number</th>
                                            <th>Instructional Material</th>
                                            <th>Batch</th>
                                            <th>Date Sold</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
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
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Customer Name</label>
                                                    <input type="text" class="form-control" name="customer_name" required>
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
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Cash</label>
                                                    <input type="text" oninput="calculateTotalChange(this)"
                                                        onpaste="return false;" class="form-control" name="cash">
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Amount</label>
                                                    <input type="text" readonly class="form-control" id="TotalAmount"
                                                        name="total_amount">
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Change</label>
                                                    <input type="text" readonly class="form-control" id="TotalChange"
                                                        name="total_change">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
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
                                        class="fas fa-check"></i>&nbsp;&nbsp;Confirm Purchase</button>
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
        var quantity = parseInt($('#SelectQuantity').val());
        var price = parseFloat($('#Price').val());
        var totalPrice = parseFloat($('#TotalPrice').val());
        var table = $('#AddedItemsTable').DataTable();
        var existingRow = table.rows().data().toArray().find(function(row) {
            return row[2].includes('value="' + imId + '"') && row[4].includes('value="' +
                batchId + '"');
        });
        if (existingRow) {
            var existingQuantity = parseInt(existingRow[6]);
            var existingTotalPrice = parseFloat(existingRow[10]);
            var newQuantity = existingQuantity + quantity;
            var newTotalPrice = existingTotalPrice + totalPrice;
            var quantityInput = '<input type="hidden" name="quantity[]" value="' + newQuantity + '">';
            existingRow[6] = newQuantity + quantityInput;
            existingRow[10] = newTotalPrice.toFixed(2);
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
                $('#SelectQuantity option:selected').text() + quantityInput,
                '<p class="text-right" style="font-weight: bold;"> Price: </p>',
                price.toFixed(2),
                '<p class="text-right" style="font-weight: bold;"> Total Price: </p>',
                totalPrice.toFixed(2)
            ];
            var rowNode = table.row.add(newRow).draw(false).node();
            $('#AddedItemsTable tbody tr').removeClass('recent-row');
            $(rowNode).addClass('recent-row');
        }
        var totalAmount = 0;
        table.rows().every(function() {
            var rowData = this.data();
            var rowTotalPrice = parseFloat(rowData[10]);
            totalAmount += rowTotalPrice;
        });
        $('#TotalAmount').val(totalAmount.toFixed(2));
    });
    $('#AddedItemsTable tbody').on('click', '.delete', function() {
        var table = $('#AddedItemsTable').DataTable();
        var row = $(this).closest('tr');
        table.row(row).remove().draw(false);
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
                        $('#Price').val(selectedBatch.price.toFixed(2));
                        var selectQuantity = $('#SelectQuantity');
                        selectQuantity.empty();
                        var availableStocks = selectedBatch.quantity_produced - selectedBatch
                            .total_quantity_deducted;
                        for (var i = 1; i <= availableStocks; i++) {
                            selectQuantity.append('<option value="' + i + '">' + i + '</option>');
                        }
                        selectQuantity.val(null).trigger('change');
                        selectQuantity.select2();
                    } else {
                        $('#Price').val(null);
                        $('#SelectQuantity').empty();
                    }
                });
                $('#Price, #SelectQuantity').on('input', function() {
                    var price = parseFloat($('#Price').val()) || 0;
                    var selectedQuantity = parseInt($('#SelectQuantity').val()) || 0;
                    var totalPrice = price * selectedQuantity;
                    $('#TotalPrice').val(totalPrice.toFixed(2));
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
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
        $('#ConfirmPurchaseModal').modal('show');
        $('#ConfirmPurchaseModal').on('show.bs.modal', function(e) {
            var totalAmount = 0;
            var table = $('#AddedItemsTable').DataTable();
            table.rows().every(function() {
                var rowData = this.data();
                var rowTotalPrice = parseFloat(rowData[10]);
                totalAmount += rowTotalPrice;
            });
            $('#TotalAmount').val(totalAmount.toFixed(2));
        });
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
    function calculateTotalChange(cashInput) {
        var inputValue = cashInput.value;
        var cleanedValue = inputValue.replace(/(\.\d*)\./, '$1');
        var pattern = /^\d*\.?\d*$/;
        if (!pattern.test(cleanedValue)) {
            cleanedValue = cleanedValue.replace(/[^0-9.]/g, '');
        }
        cashInput.value = cleanedValue;
        var cash = parseFloat(cashInput.value);
        var totalAmount = parseFloat($('#TotalAmount').val());
        var totalChange = cash - totalAmount;
        $('#TotalChange').val(totalChange.toFixed(2));
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
            "buttons": ["copy", "excel", "pdf", "print"],
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