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
                    <table class="table table-bordered table-striped" id="PurchaseHistoryTable" style="font-size: 14px;">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Customer Name</th>
                                <th>OR Number</th>
                                <th>Code</th>
                                <th>Title</th>
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
      
        <!-- EDIT DEPARTMENT MODAL -->
        <div class="modal fade" id="EditDepartmentModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- EDIT DEPARTMENT FORM -->
                    <form id="EditDepartmentForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Edit Department</h4>
                            <button type="button" class="close" onClick="hideEditDepartmentModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <input type="hidden" id="DepartmentId" name="department_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Code</label>
                                                    <input type="text" class="form-control" id="EditCode" name="code"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Department Name</label>
                                                    <input type="text" class="form-control" id="EditDepartmentName"
                                                        name="name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideEditDepartmentModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-check"></i>&nbsp;&nbsp;Update</button>
                        </div>
                    </form>
                    <!-- EDIT DEPARTMENT FORM -->
                </div>
            </div>
        </div>
        <!-- EDIT DEPARTMENT MODAL -->
        
    </div>
    <script>
    
    function showEditDepartmentModal(departmentId) {
        $.ajax({
            url: "{{ route('departments.edit', ':id') }}".replace(':id', departmentId),
            type: 'GET',
            dataType: 'json',
            success: function(department) {
                $('#DepartmentId').val(department.id);
                $('#EditCode').val(department.code);
                $('#EditDepartmentName').val(department.name);
                $('#EditDepartmentModal').modal('show');
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideEditDepartmentModal() {
        $('#EditDepartmentModal').modal('hide');
    }
   
   
    $('#EditDepartmentForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var departmentId = $('#DepartmentId').val();
        $.ajax({
            url: "{{ route('departments.update', ':id') }}".replace(':id', departmentId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditDepartmentModal();
                toastr.success(successMessage);
                refreshDepartmentsTable();
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
                    var formattedDateReturned = new Date(purchase.date_returned);
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var formattedDateSoldString = formattedDateSold.toLocaleDateString('en-US',
                        options);
                    var formattedDateReturnedString = formattedDateReturned.toLocaleDateString(
                        'en-US', options);
                    var totalPrice = purchase.batch.price.toFixed(2) * purchase.quantity_sold;
                    var totalRefund = purchase.batch.price.toFixed(2) * purchase.quantity_returned;
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        purchase.id + '" onclick="showEditPurchaseModal(' + purchase.id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '</div>',
                        purchase.customer_name,
                        purchase.or_number,
                        purchase.im.code,
                        purchase.im.title,
                        purchase.batch.name,
                        formattedDateSoldString,
                        formattedDateReturnedString,
                        '<span style="float: right;">' + purchase.quantity_sold + '</span>',
                        '<span style="float: right;">' + purchase.quantity_returned + '</span>',
                        '<span style="float: right;">' + monetaryValue(purchase.batch.price.toFixed(2)) + '</span>',
                        '<span style="float: right;">' + monetaryValue(totalPrice.toFixed(2)) + '</span>',
                        '<span style="float: right;">' + monetaryValue(totalRefund.toFixed(2)) + '</span>'
                    ]);
                });
                table.draw();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
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
        setInterval(refreshPurchaseHistoryTable, 60000);
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