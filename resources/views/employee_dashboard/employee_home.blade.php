@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Employee Dashboard</title>
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

<body style="font-family: Roboto, sans-serif;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Employee Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- DASHBOARD CARDS -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $countBatches }}</h3>
                            <p>Batches</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-copy"></i>
                        </div>
                        <a href="{{ route('batches.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $countIms }}</h3>
                            <p>Masterlist</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="{{ route('ims.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $countAuthors }}</h3>
                            <p>Authors</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-pen-nib"></i>
                        </div>
                        <a href="{{ route('authors.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $countCategories }}</h3>
                            <p>Categories</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-table"></i>
                        </div>
                        <a href="{{ route('categories.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- DASHBOARD CARDS -->
            <br>
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Sales Today</h3>
                </div>
                <div class="card-body">
                    <!-- SALES TODAY TABLE -->
                    <table class="table table-bordered table-striped" id="SalesTodayTable">
                        <thead class="text-center">
                            <tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Batch</th>
                                <th>Price</th>
                                <th>Quantity Sold</th>
                                <th>Quantity Deducted</th>
                                <th>Sales</th>
                                <th>Available Stocks</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <!-- SALES TODAY TABLE -->
                </div>
            </div>
            <br>
        </div>
    </section>
    <script>
    function refreshSalesTodayTable() {
        $.ajax({
            url: "{{ route('dashboards.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#SalesTodayTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(batch) {
                    var sales = batch.price.toFixed(2) * batch.quantity_sold_today;
                    var totalQuantityDeducted = parseInt(batch.quantity_sold) + parseInt(batch
                        .quantity_deducted);
                    var availableStocks = batch.quantity_produced - totalQuantityDeducted;
                    function monetaryValue(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    table.row.add([
                        batch.im.code,
                        batch.im.title,
                        batch.name,
                        '<span style="float: right;">' + monetaryValue(batch.price.toFixed(
                            2)) + '</span>',
                        '<span style="float: right;">' + batch.quantity_sold_today +
                        '</span>',
                        '<span style="float: right;">' + batch.quantity_deducted_today +
                        '</span>',
                        '<span style="float: right;">' + monetaryValue(sales.toFixed(2)) +
                        '</span>',
                        '<span style="float: right;">' + availableStocks + '</span>'
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
        $('#SalesTodayTable').DataTable({
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
        }).buttons().container().appendTo('#SalesTodayTable_wrapper .col-md-6:eq(0)');
        refreshSalesTodayTable();
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshSalesTodayTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection