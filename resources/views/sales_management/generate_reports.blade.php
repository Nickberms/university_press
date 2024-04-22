@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Generate Reports</title>
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

<body class="hold-transition sidebar-mini" style="font-family: Roboto, sans-serif;">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <div class="card card-primary col-md-6">
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
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Generate Reports</h3>
                </div>
                <div class="card-body">
                    <!-- REPORTS TABLE -->
                    <table class="table table-bordered table-striped" id="ReportsTable">
                        <thead class="text-center">
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
                        <tfoot>
                        </tfoot>
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
                    function monetaryValue(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    table.row.add([
                        batch.im.code,
                        batch.im.title,
                        batch.name,
                        '<span style="float: right;">' + monetaryValue(batch.price.toFixed(
                            2)) + '</span>',
                        '<span style="float: right;">' + beginningQuantity + '</span>',
                        '<span style="float: right;">' + monetaryValue(beginningAmount
                            .toFixed(2)) + '</span>',
                        '<span style="float: right;">' + batch.sold_quantity_within +
                        '</span>',
                        '<span style="float: right;">' + monetaryValue(soldAmount.toFixed(
                        2)) + '</span>',
                        '<span style="float: right;">' + endingQuantity + '</span>',
                        '<span style="float: right;">' + monetaryValue(endingAmount.toFixed(
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
        var startDate = new Date();
        startDate.setDate(1);
        startDate.setHours(0, 0, 0, 0);
        var endDate = new Date();
        endDate.setHours(0, 0, 0, 0);
        $('#ChooseDateRange').daterangepicker({
            startDate: startDate,
            endDate: endDate,
            locale: {
                format: 'MM/DD/YYYY'
            }
        });
        var formattedStartDate = startDate.toLocaleDateString('en-US', {
            month: '2-digit',
            day: '2-digit',
            year: 'numeric'
        });
        var formattedEndDate = endDate.toLocaleDateString('en-US', {
            month: '2-digit',
            day: '2-digit',
            year: 'numeric'
        });
        refreshReportsTable(formattedStartDate, formattedEndDate);
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