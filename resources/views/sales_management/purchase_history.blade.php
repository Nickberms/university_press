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
    <style>
    #PurchaseHistoryTable th,
    #PurchaseHistoryTable td {
        white-space: nowrap;
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
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
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Purchase History</h3>
                </div>
                <div class="card-body">
                    <!-- PURCHASE HISTORY TABLE -->
                    <table class="table table-bordered table-striped" id="PurchaseHistoryTable"
                        style="font-size: 14px;">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Customer Name</th>
                                <th>OR Number</th>
                                <th>Code</th>
                                <th>Instructional Material</th>
                                <th>Batch</th>
                                <th>Date Sold</th>
                                <th>Date Returned</th>
                                <th>Quantity Sold</th>
                                <th>Quantity Returned</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Total Refund</th>
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
        <br>
        <!-- RETURN PURCHASE MODAL -->
        <div class="modal fade" id="ReturnPurchaseModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- RETURN PURCHASE FORM -->
                    <form id="ReturnPurchaseForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Return Purchase</h4>
                            <button type="button" class="close" onClick="hideReturnPurchaseModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <input type="hidden" id="PurchaseId" name="purchase_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- LEFT SIDE -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Customer Name</label>
                                                    <input type="text" readonly class="form-control"
                                                        id="ViewCustomerName">
                                                </div>
                                                <div class="form-group">
                                                    <label>OR Number</label>
                                                    <input type="text" readonly class="form-control" id="ViewOrNumber">
                                                </div>
                                                <div class="form-group">
                                                    <label>Instructional Material</label>
                                                    <input type="text" readonly class="form-control"
                                                        id="ViewInstructionalMaterial">
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity Sold</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="ViewQuantitySold">
                                                </div>
                                            </div>
                                            <!-- LEFT SIDE -->
                                            <!-- RIGHT SIDE -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Quantity Returned</label>
                                                    <input type="number" oninput="calculateTotalRefund(this)"
                                                        class="form-control text-right" id="EditQuantityReturned"
                                                        name="quantity_returned" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Unit Price</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="ViewUnitPrice">
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Price</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="ViewTotalPrice">
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Refund</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="ViewTotalRefund">
                                                </div>
                                            </div>
                                            <!-- RIGHT SIDE -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-primary" onClick="hideReturnPurchaseModal()"
                                href="javascript:void(0)" style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-danger"><i
                                    class="fas fa-check"></i>&nbsp;&nbsp;Return</button>
                        </div>
                    </form>
                    <!-- RETURN PURCHASE FORM -->
                </div>
            </div>
        </div>
        <!-- RETURN PURCHASE MODAL -->
    </div>
    <script>
    function showReturnPurchaseModal(purchaseId) {
        $.ajax({
            url: "{{ route('purchases.edit', ':id') }}".replace(':id', purchaseId),
            type: 'GET',
            dataType: 'json',
            success: function(purchase) {
                $('#PurchaseId').val(purchase.id);
                $('#ViewCustomerName').val(purchase.customer_name);
                $('#ViewOrNumber').val(purchase.or_number);
                $('#ViewInstructionalMaterial').val(purchase.im.title);
                $('#ViewQuantitySold').val(purchase.quantity_sold);
                $('#EditQuantityReturned').val(purchase.quantity_returned);
                $('#ViewUnitPrice').val(purchase.batch.price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g,
                    ","));
                var totalPrice = purchase.quantity_sold * purchase.batch.price.toFixed(2);
                $('#ViewTotalPrice').val(totalPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                var totalRefund = purchase.quantity_returned * purchase.batch.price.toFixed(2);
                $('#ViewTotalRefund').val(totalRefund.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('#ReturnPurchaseModal').modal('show');
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideReturnPurchaseModal() {
        $('#ReturnPurchaseModal').modal('hide');
    }
    $('#ReturnPurchaseForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var purchaseId = $('#PurchaseId').val();
        $.ajax({
            url: "{{ route('purchases.update', ':id') }}".replace(':id', purchaseId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideReturnPurchaseModal();
                toastr.success(successMessage);
                refreshPurchaseHistoryTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    function refreshPurchaseHistoryTable() {
        function monetaryValue(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $.ajax({
            url: "{{ route('purchases.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#PurchaseHistoryTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(purchase) {
                    var formattedDateSold = new Date(purchase.date_sold);
                    var formattedDateReturned = purchase.date_returned ? new Date(purchase
                        .date_returned) : null;
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var formattedDateSoldString = formattedDateSold.toLocaleDateString('en-US',
                        options);
                    var formattedDateReturnedString = formattedDateReturned ? formattedDateReturned
                        .toLocaleDateString('en-US', options) : '';
                    var totalPrice = purchase.batch.price.toFixed(2) * purchase.quantity_sold;
                    var totalRefund = purchase.batch.price.toFixed(2) * purchase.quantity_returned;
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="delete" title="Return" data-toggle="tooltip" data-id="' +
                        purchase.id + '" onclick="showReturnPurchaseModal(' + purchase.id +
                        ')">' +
                        '<i class="material-icons">&#xE15F;</i></a>' +
                        '</div>',
                        `<span title="${purchase.customer_name}">${purchase.customer_name}</span>`,
                        `<span title="${purchase.or_number}">${purchase.or_number}</span>`,
                        `<span title="${purchase.im.code}">${purchase.im.code}</span>`,
                        `<span title="${purchase.im.title}">${purchase.im.title}</span>`,
                        `<span title="${purchase.batch.name}">${purchase.batch.name}</span>`,
                        `<span title="${formattedDateSoldString}">${formattedDateSoldString}</span>`,
                        `<span title="${formattedDateReturnedString}">${formattedDateReturnedString}</span>`,
                        `<span style="float: right;" title="${purchase.quantity_sold}">${purchase.quantity_sold}</span>`,
                        `<span style="float: right;" title="${purchase.quantity_returned}">${purchase.quantity_returned}</span>`,
                        `<span style="float: right;" title="${monetaryValue(purchase.batch.price.toFixed(2))}">${monetaryValue(purchase.batch.price.toFixed(2))}</span>`,
                        `<span style="float: right;" title="${monetaryValue(totalPrice.toFixed(2))}">${monetaryValue(totalPrice.toFixed(2))}</span>`,
                        `<span style="float: right;" title="${monetaryValue(totalRefund.toFixed(2))}">${monetaryValue(totalRefund.toFixed(2))}</span>`
                    ]);
                });
                table.draw();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function calculateTotalRefund(inputField) {
        var pattern = /^[0-9]+$/;
        var inputValue = inputField.value;
        if (!pattern.test(inputValue)) {
            inputField.value = inputValue.replace(/[^0-9]/g, '');
        }
        var quantityReturned = document.getElementById('EditQuantityReturned').value;
        var unitPrice = document.getElementById('ViewUnitPrice').value.replace(/,/g, '');
        var totalRefund = 0;
        if (quantityReturned && unitPrice) {
            totalRefund = parseFloat(quantityReturned) * parseFloat(unitPrice);
        }
        document.getElementById('ViewTotalRefund').value = totalRefund.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $(document).ready(function() {
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
            "pageLength": 10
        }).buttons().container().appendTo('#PurchaseHistoryTable_wrapper .col-md-6:eq(0)');
        refreshPurchaseHistoryTable();
        setInterval(refreshPurchaseHistoryTable, 120000);
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshPurchaseHistoryTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection