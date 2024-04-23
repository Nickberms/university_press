@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Top Sales</title>
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
    <br>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="card">
                <!-- TOP SALES FILTERS FORM -->
                <form id="TopSalesFiltersForm" method="GET">
                    @csrf
                    <div class="card-header" style="background: #E9ECEF;">
                        <h3 class="card-title">Top Sales Filters</h3>
                    </div>
                    <div class="card-body" style="font-size: 14px;">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Specify Date Range</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="ChooseDateRange"
                                        name="date_range">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Select Author</label>
                                <select class="select2 form-control" id="SelectAuthor" name="select_author"
                                    style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label>Select Category</label>
                                <select class="select2 form-control" id="SelectCategory" name="select_category"
                                    style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Select College</label>
                                <select class="select2 form-control" id="SelectCollege" name="select_college"
                                    style="width: 100%;">
                                    <option value=" "></option>
                                    <option>College of Agriculture</option>
                                    <option>College of Arts and Sciences</option>
                                    <option>College of Business and Management</option>
                                    <option>College of Education</option>
                                    <option>College of Engineering</option>
                                    <option>College of Forestry and Environmental Sciences
                                    </option>
                                    <option>College of Human Ecology</option>
                                    <option>College of Information Sciences and Computing
                                    </option>
                                    <option>College of Nursing</option>
                                    <option>College of Veterinary Medicine</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label>Select Publisher</label>
                                <select class="select2 form-control" id="SelectPublisher" name="select_publisher"
                                    style="width: 100%;">
                                    <option value=" "></option>
                                    <option>University Press</option>
                                    <option>Consigned Material</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="background: #E9ECEF;">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-times-circle"></i>&nbsp;&nbsp;Clear Filters</button>
                        </div>
                    </div>
                </form>
                <!-- TOP SALES FILTERS FORM -->
            </div>
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Top Sales</h3>
                </div>
                <div class="card-body">
                    <!-- TOP SALES TABLE -->
                    <table class="table table-bordered table-striped" id="TopSalesTable" style="font-size: 14px;">
                        <thead class="text-center">
                            <tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Authors</th>
                                <th>Category</th>
                                <th>College</th>
                                <th>Publisher</th>
                                <th>Unit Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <!-- TOP SALES TABLE -->
                </div>
            </div>
        </div>
    </div>
    <br>
    <script>
    $('#TopSalesFiltersForm').submit(function(event) {
        event.preventDefault();
        populateTopSalesFiltersForm();
        $('#SelectCollege').val(null).trigger('change');
        $('#SelectPublisher').val(null).trigger('change');
    });
    function populateTopSalesFiltersForm() {
        $.ajax({
            url: "{{ route('top_sales.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectAuthor = $('#SelectAuthor');
                selectAuthor.empty();
                response.authors.forEach(function(author) {
                    selectAuthor.append('<option value="' + author.id + '">' + author
                        .first_name + ' ' + author.last_name + '</option>');
                });
                selectAuthor.val(null).trigger('change');
                selectAuthor.select2();
                var selectCategory = $('#SelectCategory');
                selectCategory.empty();
                response.categories.forEach(function(category) {
                    selectCategory.append('<option value="' + category.id + '">' + category
                        .name + '</option>');
                });
                selectCategory.val(null).trigger('change');
                selectCategory.select2();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function refreshTopSalesTable(startDate, endDate) {
        var selectAuthor = $('#SelectAuthor').val();
        var selectCategory = $('#SelectCategory').val();
        var selectCollege = $('#SelectCollege').val();
        var selectPublisher = $('#SelectPublisher').val();
        $.ajax({
            url: "{{ route('top_sales.index') }}",
            type: 'GET',
            dataType: 'json',
            data: {
                date_range: startDate + ' - ' + endDate,
                select_author: selectAuthor,
                select_category: selectCategory,
                select_college: selectCollege,
                select_publisher: selectPublisher
            },
            success: function(data) {
                var table = $('#TopSalesTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(im) {
                    var authors = '';
                    if (im.authors.length > 0) {
                        im.authors.forEach(function(author, index) {
                            authors += author.first_name;
                            if (author.middle_name) {
                                authors += ' ' + author.middle_name;
                            }
                            authors += ' ' + author.last_name;
                            if (index < im.authors.length - 1) {
                                authors += ', ';
                            }
                        });
                        authors += '<br>';
                    }
                    table.row.add([
                        im.code,
                        im.title,
                        authors,
                        im.category.name,
                        im.college,
                        im.publisher,
                        '<span style="float: right;">' + im.quantity_sold + '</span>'
                    ]);
                });
                table.draw();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
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
        populateTopSalesFiltersForm();
        refreshTopSalesTable(formattedStartDate, formattedEndDate);
        $('#TopSalesTable').DataTable({
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
        }).buttons().container().appendTo('#TopSalesTable_wrapper .col-md-6:eq(0)');
        $('#ChooseDateRange').on('apply.daterangepicker', function(ev, picker) {
            var startDate = picker.startDate.format('MM/DD/YYYY');
            var endDate = picker.endDate.format('MM/DD/YYYY');
            refreshTopSalesTable(startDate, endDate);
        });
        $('.select2').change(function() {
            var startDate = $('#ChooseDateRange').data('daterangepicker').startDate.format(
                'MM/DD/YYYY');
            var endDate = $('#ChooseDateRange').data('daterangepicker').endDate.format(
                'MM/DD/YYYY');
            refreshTopSalesTable(startDate, endDate);
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                var startDate = $('#ChooseDateRange').data('daterangepicker').startDate.format(
                    'MM/DD/YYYY');
                var endDate = $('#ChooseDateRange').data('daterangepicker').endDate.format(
                    'MM/DD/YYYY');
                refreshTopSalesTable(startDate, endDate);
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection