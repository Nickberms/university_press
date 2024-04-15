@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Purchases</title>
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
            <a class="btn btn-primary" onClick="showPurchaseHistoryModal()" href="javascript:void(0)"
                style="background-color: #00491E; border-color: #00491E;">
                <i class="fas fa-history"></i> Purchase History
            </a>
            <br><br>
        </div>
        <br>
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
                                            <th>IM Batch</th>
                                            <th>Date Sold</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
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
    </div>
    <script>
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
    });
    </script>
</body>

</html>
@endsection