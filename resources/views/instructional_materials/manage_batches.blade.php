@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Batches</title>
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
            <a class="btn btn-primary" onClick="showAddBatchModal()" href="javascript:void(0)">
                <i class="fas fa-plus"></i> Add Batch
            </a>
            <br><br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Batches</h3>
                </div>
                <div class="card-body">
                    <!-- BATCHES TABLE -->
                    <table class="table table-bordered table-striped" id="BatchesTable">
                        <thead>
                            <tr>
                                <th class="text-center">Actions</th>
                                <th>Instructional Material</th>
                                <th>Batch Name</th>
                                <th>Production Date</th>
                                <th>Production Cost</th>
                                <th>Price</th>
                                <th>Beginning Quantity</th>
                                <th>Available Stocks</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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
                    <div class="modal-header">
                        <h4 class="modal-title">Add Batch</h4>
                    </div>
                    <div class="modal-body">
                        <!-- ADD BATCH FORM -->
                        <form id="AddBatchForm" method="POST">
                            @csrf
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="instructional_material">Instructional Material</label>
                                                    <select class="select2 form-control"
                                                        id="ChooseInstructionalMaterial" name="instructional_material"
                                                        data-placeholder="Select Instructional Material"
                                                        style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Batch Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Enter Batch Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="production_date">Production Date</label>
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
                                                    <label for="production_cost">Production Cost</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control"
                                                        name="production_cost" placeholder="Enter Production Cost"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="price">Price</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control" name="price"
                                                        placeholder="Enter Price" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="beginning_quantity">Beginning Quantity</label>
                                                    <input type="text" oninput="NumbersOnly(this)" class="form-control"
                                                        name="beginning_quantity" placeholder="Enter Beginning Quantity"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" onClick="hideAddBatchModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                        <!-- ADD BATCH FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD BATCH MODAL -->
        <!-- EDIT BATCH MODAL -->
        <div class="modal fade" id="EditBatchModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Batch</h4>
                    </div>
                    <div class="modal-body">
                        <!-- EDIT BATCH FORM -->
                        <form id="EditBatchForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="BatchId" name="batch_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="instructional_material">Instructional Material</label>
                                                    <select class="select2 form-control" id="EditInstructionalMaterial"
                                                        name="instructional_material"
                                                        data-placeholder="Select Instructional Material"
                                                        style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name">Batch Name</label>
                                                    <input type="text" class="form-control" id="EditName" name="name"
                                                        placeholder="Enter Batch Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="production_date">Production Date</label>
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
                                                    <label for="production_cost">Production Cost</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control"
                                                        id="EditProductionCost" name="production_cost"
                                                        placeholder="Enter Production Cost" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="price">Price</label>
                                                    <input type="text" oninput="AmountOnly(this)"
                                                        onpaste="return false;" class="form-control" id="EditPrice"
                                                        name="price" placeholder="Enter Price" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="beginning_quantity">Beginning Quantity</label>
                                                    <input type="text" oninput="NumbersOnly(this)" class="form-control"
                                                        id="EditBeginningQuantity" name="beginning_quantity"
                                                        placeholder="Enter Beginning Quantity" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" onClick="hideEditBatchModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                        <!-- EDIT BATCH FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- EDIT BATCH MODAL -->
        <!-- DELETE BATCH MODAL -->
        <div class="modal fade" id="DeleteBatchModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Batch</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this batch?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onClick="hideDeleteBatchModal()"
                            href="javascript:void(0)">Cancel</button>
                        <button type="button" class="btn btn-danger" id="DeleteBatch">Delete</button>
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
                var selectInstructionalMaterial = $('#ChooseInstructionalMaterial');
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
                console.error(xhr.responseText);
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
                        $('#EditName').val(batch.name);
                        var productionDate = new Date(batch.production_date);
                        var formattedProductionDate = productionDate.toISOString().split('T')[
                            0];
                        $('#EditProductionDate').val(formattedProductionDate);
                        $('#EditProductionCost').val(batch.production_cost.toFixed(2));
                        $('#EditPrice').val(batch.price.toFixed(2));
                        $('#EditBeginningQuantity').val(batch.beginning_quantity);
                        $('#EditBatchModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
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
                location.reload();
                console.error(xhr.responseText);
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
                        batch.production_cost.toFixed(2),
                        batch.price.toFixed(2),
                        batch.beginning_quantity,
                        batch.available_stocks
                    ]);
                });
                table.draw();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
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
            "responsive": true,
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