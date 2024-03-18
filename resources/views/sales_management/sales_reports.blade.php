@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Sales Reports</title>
    <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
    <script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="admin/plugins/toastr/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <div class="card card-primary col-md-3">
                <div class="card-body">
                    <div class="form-group">
                        <label for="date_range">Specify Date Range:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="ChooseDateRange" name="date_range">
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sales Reports</h3>
                </div>
                <div class="card-body">
                    <!-- REPORTS TABLE -->
                    <table class="table table-bordered table-striped" id="ReportsTable" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Batch</th>
                                <th>Unit Price</th>
                                <th>Beginning Quantity</th>
                                <th>Beginning Amount</th>
                                <th>Sold Quantity</th>
                                <th>Sold Amount</th>
                                <th>Ending Quantity</th>
                                <th>Ending Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- REPORTS TABLE -->
                </div>
            </div>
        </div>
        <br>
    </div>
    <script>
    function refreshReportsTable(startDate, endDate) {
        $.ajax({
            url: "{{ route('reports.index') }}",
            type: 'GET',
            dataType: 'json',
            data: {
                date_range: startDate + ' - ' + endDate
            },
            success: function(data) {
                var table = $('#ReportsTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(batch) {
                    var beginningQuantity = batch.quantity_produced - batch.sold_quantity_before;
                    var beginningAmount = batch.price.toFixed(2) * beginningQuantity;
                    var soldAmount = batch.price.toFixed(2) * batch.sold_quantity_within;
                    var endingQuantity = beginningQuantity - batch.sold_quantity_within;
                    var endingAmount = batch.price.toFixed(2) * endingQuantity;
                    table.row.add([
                        batch.im.code,
                        batch.im.title,
                        batch.name,
                        batch.price.toFixed(2),
                        beginningQuantity,
                        beginningAmount.toFixed(2),
                        batch.sold_quantity_within,
                        soldAmount.toFixed(2),
                        endingQuantity,
                        endingAmount.toFixed(2)
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
        var startDate = new Date();
        startDate.setFullYear(startDate.getFullYear() - 1);
        startDate.setHours(0, 0, 0, 0);
        var today = new Date();
        $('#ChooseDateRange').daterangepicker({
            startDate: startDate,
            endDate: today,
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
        $('#ReportsTable').DataTable({
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
        }).buttons().container().appendTo('#ReportsTable_wrapper .col-md-6:eq(0)');
        $('#ChooseDateRange').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('MM/DD/YYYY');
            var endDate = picker.endDate.format('MM/DD/YYYY');
            refreshReportsTable(startDate, endDate);
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                var startDate = $('#ChooseDateRange').data('daterangepicker').startDate.format(
                    'MM/DD/YYYY');
                var endDate = $('#ChooseDateRange').data('daterangepicker').endDate.format(
                    'MM/DD/YYYY');
                refreshReportsTable(startDate, endDate);
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection