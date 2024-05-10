@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Batches</title>
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
    #BatchesTable th,
    #BatchesTable td {
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
                    <h3 class="card-title">Filter by</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label>Author</label>
                            <select class="select2 form-control" id="SelectAuthor" name="select_author"
                                style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Category</label>
                            <select class="select2 form-control" id="SelectCategory" name="select_category"
                                style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>College</label>
                            <select class="select2 form-control" id="SelectCollege" name="select_college"
                                style="width: 100%;">
                                <option value="">&nbsp;</option>
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
                        <div class="form-group col-sm-3">
                            <label>Publisher</label>
                            <select class="select2 form-control" id="SelectPublisher" name="select_publisher"
                                style="width: 100%;">
                                <option value="">&nbsp;</option>
                                <option>University Press</option>
                                <option>Consigned Material</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Manage Batches</h3>
                    <div class="text-right">
                        <a class="btn btn-primary" onClick="showAddBatchModal()" href="javascript:void(0)"
                            style="background-color: #00491E; border-color: #00491E;">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- BATCHES TABLE -->
                    <table class="table table-bordered table-striped" id="BatchesTable" style="font-size: 14px;">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Instructional Material</th>
                                <th>Batch Name</th>
                                <th>Production Date</th>
                                <th>Production Cost</th>
                                <th>Unit Price</th>
                                <th>Quantity Produced</th>
                                <th>Quantity Sold</th>
                                <th>Quantity Deducted</th>
                                <th>Available Stocks</th>
                                <th>Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <!-- BATCHES TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD BATCH MODAL -->
        <div class="modal fade" id="AddBatchModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- ADD BATCH FORM -->
                    <form id="AddBatchForm" method="POST">
                        @csrf
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Add Batch</h4>
                            <button type="button" class="close" onClick="hideAddBatchModal()">
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
                                                    <label>Instructional Material</label>
                                                    <select class="select2 form-control"
                                                        id="SelectInstructionalMaterial" name="im_id"
                                                        style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Batch Name</label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Production Date</label>
                                                    <input type="date" class="form-control" name="production_date"
                                                        required>
                                                </div>
                                            </div>
                                            <!-- LEFT SIDE -->
                                            <!-- RIGHT SIDE -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Production Cost</label>
                                                    <input type="text" oninput="amountOnly(this)"
                                                        onpaste="return false;" class="form-control text-right"
                                                        name="production_cost" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Unit Price</label>
                                                    <input type="text" oninput="amountOnly(this)"
                                                        onpaste="return false;" class="form-control text-right" name="price"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity Produced</label>
                                                    <input type="number" oninput="numbersOnly(this)" class="form-control text-right"
                                                        name="quantity_produced" required>
                                                </div>
                                            </div>
                                            <!-- RIGHT SIDE -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideAddBatchModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                        </div>
                    </form>
                    <!-- ADD BATCH FORM -->
                </div>
            </div>
        </div>
        <!-- ADD BATCH MODAL -->
        <!-- EDIT BATCH MODAL -->
        <div class="modal fade" id="EditBatchModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- EDIT BATCH FORM -->
                    <form id="EditBatchForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Edit Batch</h4>
                            <button type="button" class="close" onClick="hideEditBatchModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <input type="hidden" id="BatchId" name="batch_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- LEFT SIDE -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Instructional Material</label>
                                                    <select class="select2 form-control" id="EditInstructionalMaterial"
                                                        name="im_id" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Batch Name</label>
                                                    <input type="text" class="form-control" id="EditBatchName"
                                                        name="name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Production Date</label>
                                                    <input type="date" class="form-control" id="EditProductionDate"
                                                        name="production_date" required>
                                                </div>
                                            </div>
                                            <!-- LEFT SIDE -->
                                            <!-- RIGHT SIDE -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Production Cost</label>
                                                    <input type="text" oninput="amountOnly(this)"
                                                        onpaste="return false;" class="form-control text-right"
                                                        id="EditProductionCost" name="production_cost" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Unit Price</label>
                                                    <input type="text" oninput="amountOnly(this)"
                                                        onpaste="return false;" class="form-control text-right" id="EditPrice"
                                                        name="price" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity Produced</label>
                                                    <input type="number" oninput="numbersOnly(this)" class="form-control text-right"
                                                        id="EditQuantityProduced" name="quantity_produced" required>
                                                </div>
                                            </div>
                                            <!-- RIGHT SIDE -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideEditBatchModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-check"></i>&nbsp;&nbsp;Update</button>
                        </div>
                    </form>
                    <!-- EDIT BATCH FORM -->
                </div>
            </div>
        </div>
        <!-- EDIT BATCH MODAL -->
        <!-- DELETE BATCH MODAL -->
        <div class="modal fade" id="DeleteBatchModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #E9ECEF;">
                        <h4 class="modal-title">Delete Batch</h4>
                        <button type="button" class="close" onClick="hideDeleteBatchModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: #E9ECEF;">
                        Are you sure you want to delete this batch?
                    </div>
                    <div class="modal-footer" style="background: #E9ECEF;">
                        <button type="button" class="btn btn-primary" onClick="hideDeleteBatchModal()"
                            href="javascript:void(0)" style="background-color: #00491E; border-color: #00491E;"><i
                                class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                        <button type="button" class="btn btn-danger" id="DeleteBatch"><i
                                class="fas fa-trash"></i>&nbsp;&nbsp;Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE BATCH MODAL -->
    </div>
    <script>
    function showAddBatchModal() {
        $.ajax({
            url: "{{ route('batches.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectInstructionalMaterial = $('#SelectInstructionalMaterial');
                selectInstructionalMaterial.empty();
                response.forEach(function(im) {
                    selectInstructionalMaterial.append('<option value="' + im.id + '">' + im.title +
                        '</option>');
                });
                selectInstructionalMaterial.val(null).trigger('change');
                selectInstructionalMaterial.select2();
                $('#AddBatchModal').modal('show');
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideAddBatchModal() {
        $('#AddBatchModal').modal('hide');
    }
    function showEditBatchModal(batchId) {
        $.ajax({
            url: "{{ route('batches.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectInstructionalMaterial = $('#EditInstructionalMaterial');
                selectInstructionalMaterial.empty();
                response.forEach(function(im) {
                    selectInstructionalMaterial.append('<option value="' + im.id + '">' + im.title +
                        '</option>');
                });
                selectInstructionalMaterial.select2();
                $.ajax({
                    url: "{{ route('batches.edit', ':id') }}".replace(':id', batchId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(batch) {
                        $('#BatchId').val(batch.id);
                        $('#EditInstructionalMaterial').val(batch.im_id).trigger('change');
                        $('#EditBatchName').val(batch.name);
                        var productionDate = new Date(batch.production_date);
                        var formattedProductionDate = productionDate.toISOString().split('T')[
                            0];
                        $('#EditProductionDate').val(formattedProductionDate);
                        var formattedProductionCost = batch.production_cost.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#EditProductionCost').val(formattedProductionCost);
                        var formattedPrice = batch.price.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#EditPrice').val(formattedPrice);
                        $('#EditQuantityProduced').val(batch.quantity_produced);
                        $('#EditBatchModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = JSON.parse(xhr.responseText).error;
                        console.error(errorMessage);
                        toastr.error(errorMessage);
                    }
                });
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideEditBatchModal() {
        $('#EditBatchModal').modal('hide');
    }
    function showDeleteBatchModal() {
        $('#DeleteBatchModal').modal('show');
    }
    function hideDeleteBatchModal() {
        $('#DeleteBatchModal').modal('hide');
    }
    function populateBatchesFilters() {
        $.ajax({
            url: "{{ route('filters.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectAuthor = $('#SelectAuthor');
                selectAuthor.empty();
                selectAuthor.empty().append('<option value="">&nbsp;</option>');
                response.authors.forEach(function(author) {
                    selectAuthor.append('<option value="' + author.id + '">' + author
                        .first_name + ' ' + author.last_name + '</option>');
                });
                selectAuthor.val(null).trigger('change');
                selectAuthor.select2();
                var selectCategory = $('#SelectCategory');
                selectCategory.empty();
                selectCategory.empty().append('<option value="">&nbsp;</option>');
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
    function refreshBatchesTable() {
        var selectAuthor = $('#SelectAuthor').val();
        var selectCategory = $('#SelectCategory').val();
        var selectCollege = $('#SelectCollege').val();
        var selectPublisher = $('#SelectPublisher').val();
        $.ajax({
            url: "{{ route('batches.index') }}",
            type: 'GET',
            dataType: 'json',
            data: {
                select_author: selectAuthor,
                select_category: selectCategory,
                select_college: selectCollege,
                select_publisher: selectPublisher
            },
            success: function(data) {
                var table = $('#BatchesTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(batch) {
                    var formattedProductionDate = new Date(batch.production_date);
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var formattedProductionDateString = formattedProductionDate.toLocaleDateString(
                        'en-US', options);
                    var totalQuantityDeducted = parseInt(batch.quantity_sold) + parseInt(batch
                        .quantity_deducted);
                    var availableStocks = batch.quantity_produced - totalQuantityDeducted;
                    var totalRevenue = (batch.price.toFixed(2) * batch.quantity_sold) - batch
                        .production_cost.toFixed(2);
                    function monetaryValue(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        batch.id + '" onclick="showEditBatchModal(' + batch.id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '<a href="#" class="delete" title="Delete" data-toggle="tooltip" data-id="' +
                        batch.id + '"><i class="material-icons">&#xE872;</i></a>' +
                        '</div>',
                        batch.im.title,
                        batch.name,
                        formattedProductionDateString,
                        '<span style="float: right;">' + monetaryValue(batch
                            .production_cost.toFixed(2)) + '</span>',
                        '<span style="float: right;">' + monetaryValue(batch.price
                            .toFixed(2)) + '</span>',
                        '<span style="float: right;">' + batch.quantity_produced +
                        '</span>',
                        '<span style="float: right;">' + batch.quantity_sold + '</span>',
                        '<span style="float: right;">' + batch.quantity_deducted +
                        '</span>',
                        '<span style="float: right;">' + availableStocks + '</span>',
                        '<span style="float: right;">' + monetaryValue(totalRevenue
                            .toFixed(2)) + '</span>'
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
    function amountOnly(inputField) {
        var cleanedValue = inputField.value.replace(/[^\d.]/g, '').replace(/\.(?=.*\.)/g, '');
        var parts = cleanedValue.split('.');
        if (parts.length > 2) {
            cleanedValue = parts.slice(0, -1).join('') + '.' + parts.pop();
        }
        var integerPart = cleanedValue.split('.')[0];
        var formattedIntegerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        var formattedValue = formattedIntegerPart + (parts.length > 1 ? '.' + parts[1] : '');
        inputField.value = formattedValue;
    }
    function numbersOnly(inputField) {
        var pattern = /^[0-9]+$/;
        var inputValue = inputField.value;
        if (!pattern.test(inputValue)) {
            inputField.value = inputValue.replace(/[^0-9]/g, '');
        }
    }
    $('#AddBatchForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('batches.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideAddBatchModal();
                toastr.success(successMessage);
                refreshBatchesTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#EditBatchForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var batchId = $('#BatchId').val();
        $.ajax({
            url: "{{ route('batches.update', ':id') }}".replace(':id', batchId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditBatchModal();
                toastr.success(successMessage);
                refreshBatchesTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#BatchesTable').on('click', '.delete', function(event) {
        event.preventDefault();
        var batchId = $(this).data('id');
        showDeleteBatchModal();
        $('#DeleteBatch').off().on('click', function() {
            $.ajax({
                url: "{{ route('batches.destroy', ':id') }}".replace(':id', batchId),
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideDeleteBatchModal();
                    toastr.success(successMessage);
                    refreshBatchesTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        });
    });
    $(document).ready(function() {
        $('#AddBatchModal').on('hidden.bs.modal', function(e) {
            $('#AddBatchForm')[0].reset();
            $('#AddBatchModal select').val(null).trigger('change');
        });
        populateBatchesFilters();
        $('.select2').change(function() {
            refreshBatchesTable();
        });
        $('#BatchesTable').DataTable({
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
        }).buttons().container().appendTo('#BatchesTable_wrapper .col-md-6:eq(0)');
        refreshBatchesTable();
        setInterval(refreshBatchesTable, 60000);
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshBatchesTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection