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
    <div class="wrapper">
        <div class="container-fluid">
            <br><br>
            <div class="card">
                <!-- TOP SALES FILTERS FORM -->
                <form id="TopSalesFiltersForm" method="GET">
                    @csrf
                    <div class="card-header" style="background: #E9ECEF;">
                        <h3 class="card-title">Top Sales Filters</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Select Author</label>
                                <select class="select2 form-control" id="SelectAuthor" name="select_author"
                                    style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label>Select Category</label>
                                <select class="select2 form-control" id="SelectCategory" name="select_category"
                                    style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group col-6">
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
                            <div class="form-group col-6">
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
        </div>
    </div>
    <script>
    function populateTopSalesFiltersForm() {
        $.ajax({
            url: "{{ route('top.index') }}",
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
    $('#TopSalesFiltersForm').submit(function(event) {
        event.preventDefault();
        populateTopSalesFiltersForm();
        $('#SelectCollege').val(null).trigger('change');
        $('#SelectPublisher').val(null).trigger('change');
    });
    $(document).ready(function() {
        populateTopSalesFiltersForm();
    });
    </script>
</body>

</html>
@endsection