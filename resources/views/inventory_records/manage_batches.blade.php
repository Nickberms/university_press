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
</head>

<body class="hold-transition sidebar-mini" style="font-family: Roboto, sans-serif;">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <a class="btn btn-primary" onClick="showAddBatchModal()" href="javascript:void(0)"
                style="background-color: #00491E; border-color: #00491E;">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Batch
            </a>
            <br><br>
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Manage Batches</h3>
                </div>
                <div class="card-body">
                    <!-- BATCHES TABLE -->
                    <table class="table table-bordered table-striped" id="BatchesTable">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Instructional Material</th>
                                <th>Batch Name</th>
                                <th>Production Date</th>
                                <th>Production Cost</th>
                                <th>Price</th>
                                <th>Quantity Produced</th>
                                <th>Quantity Sold</th>
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
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
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
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Production Cost</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control"
                                                        name="production_cost" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Price</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control" name="price"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity Produced</label>
                                                    <input type="text" oninput="NumbersOnly(this)" class="form-control"
                                                        name="quantity_produced" required>
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
                                <button type="button" class="btn btn-danger" onClick="hideAddBatchModal()"
                                    href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #00491E; border-color: #00491E;"><i
                                        class="fas fa-plus"></i>&nbsp;&nbsp;Add Batch</button>
                            </div>
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
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Instructional Material</label>
                                                    <select class="select2 form-control" id="EditInstructionalMaterial"
                                                        name="im_id" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Batch Name</label>
                                                    <input type="text" class="form-control" id="EditBatchName" name="name"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Production Date</label>
                                                    <input type="date" class="form-control" id="EditProductionDate"
                                                        name="production_date" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Production Cost</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control"
                                                        id="EditProductionCost" name="production_cost" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Price</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control" id="EditPrice"
                                                        name="price" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity Produced</label>
                                                    <input type="text" oninput="NumbersOnly(this)" class="form-control"
                                                        id="EditQuantityProduced" name="quantity_produced" required>
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
                                <button type="button" class="btn btn-danger" onClick="hideEditBatchModal()"
                                    href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #00491E; border-color: #00491E;"><i
                                        class="fas fa-check"></i>&nbsp;&nbsp;Update Batch</button>
                            </div>
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
                                class="fas fa-trash"></i>&nbsp;&nbsp;Delete Batch</button>
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
                        $('#EditProductionCost').val(batch.production_cost.toFixed(2));
                        $('#EditPrice').val(batch.price.toFixed(2));
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
    function refreshBatchesTable() {
        $.ajax({
            url: "{{ route('batches.index') }}",
            type: 'GET',
            dataType: 'json',
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
                    var availableStocks = batch.quantity_produced - batch.quantity_sold;
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
                        '<span style="float: right;">' + batch.quantity_produced + '</span>',
                        '<span style="float: right;">' + batch.quantity_sold + '</span>',
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
    function NumbersOnly(inputField) {
        var pattern = /^[0-9]+$/;
        var inputValue = inputField.value;
        if (!pattern.test(inputValue)) {
            inputField.value = inputValue.replace(/[^0-9]/g, '');
        }
    }
    function AmountOnly(inputField) {
        var inputValue = inputField.value;
        var cleanedValue = inputValue.replace(/(\.\d*)\./, '$1');
        var pattern = /^\d*\.?\d*$/;
        if (!pattern.test(cleanedValue)) {
            cleanedValue = cleanedValue.replace(/[^0-9.]/g, '');
        }
        inputField.value = cleanedValue;
    }
    $(document).ready(function() {
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
            "buttons": ["copy", "excel", "pdf", "print"],
            "pageLength": 8
        }).buttons().container().appendTo('#BatchesTable_wrapper .col-md-6:eq(0)');
        refreshBatchesTable();
        setInterval(refreshBatchesTable, 60000);
        $('#AddBatchModal').on('hidden.bs.modal', function(e) {
            $('#AddBatchForm')[0].reset();
            $('#AddBatchModal select').val(null).trigger('change');
        });
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