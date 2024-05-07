@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Adjustment Logs</title>
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
    #AdjustmentLogsTable th,
    #AdjustmentLogsTable td {
        white-space: nowrap;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini" style="font-family: Roboto, sans-serif;">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Adjustment Logs</h3>
                    <div class="text-right">
                        <a class="btn btn-primary" onClick="showAddAdjustmentLogModal()" href="javascript:void(0)"
                            style="background-color: #00491E; border-color: #00491E;">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- ADJUSTMENT LOGS TABLE -->
                    <table class="table table-bordered table-striped" id="AdjustmentLogsTable" style="font-size: 14px;">
                        <thead class="text-center">
                            <tr>
                                <th>Adjustment Cause</th>
                                <th>Instructional Material</th>
                                <th>Batch</th>
                                <th>Date Adjusted</th>
                                <th>Quantity Deducted</th>
                                <th>Unit Price</th>
                                <th>Total Loss</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <!-- ADJUSTMENT LOGS TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD ADJUSTMENT LOG MODAL -->
        <div class="modal fade" id="AddAdjustmentLogModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- ADD ADJUSTMENT LOG FORM -->
                    <form id="AddAdjustmentLogForm" method="POST">
                        @csrf
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Add Adjustment Log</h4>
                            <button type="button" class="close" onClick="hideAddAdjustmentLogModal()">
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
                                                    <label>Adjustment Cause</label>
                                                    <textarea type="text" class="form-control" name="adjustment_cause"
                                                        style="height: 125px;" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Select IM</label>
                                                    <select class="select2 form-control" id="SelectIm" name="im_id"
                                                        style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Select Batch</label>
                                                    <select class="select2 form-control" id="SelectBatch"
                                                        name="batch_id" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Date Adjusted</label>
                                                    <input type="date" class="form-control" name="date_adjusted"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Quantity Deducted</label>
                                                    <input type="number" oninput="numbersOnly(this)"
                                                        class="form-control text-right" id="QuantityDeducted"
                                                        name="quantity_deducted" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Unit Price</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="Price" name="price">
                                                </div>
                                                <div class="form-group">
                                                    <label>Total Loss</label>
                                                    <input type="text" readonly class="form-control text-right"
                                                        id="TotalLoss" name="total_loss">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideAddAdjustmentLogModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                        </div>
                    </form>
                    <!-- ADD ADJUSTMENT LOG FORM -->
                </div>
            </div>
        </div>
        <!-- ADD ADJUSTMENT LOG MODAL -->
    </div>
    <script>
    function showAddAdjustmentLogModal() {
        $.ajax({
            url: "{{ route('adjustment_logs.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectIm = $('#SelectIm');
                selectIm.empty();
                response.forEach(function(im) {
                    selectIm.append('<option value="' + im.id + '">' + im.title +
                        '</option>');
                });
                $('#AddAdjustmentLogModal').modal('show');
                selectIm.val(null).trigger('change');
                selectIm.select2();
                $('#SelectIm').on('change', function() {
                    $('#TotalLoss').val(null);
                    var imId = $(this).val();
                    if (imId) {
                        var selectedIm = response.find(function(im) {
                            return im.id == imId;
                        });
                        var batches = selectedIm.batches;
                        var selectBatch = $('#SelectBatch');
                        selectBatch.empty();
                        batches.forEach(function(batch) {
                            selectBatch.append('<option value="' + batch.id + '">' + batch
                                .name + '</option>');
                        });
                        selectBatch.val(null).trigger('change');
                        selectBatch.select2();
                    }
                });
                $('#SelectBatch').on('change', function() {
                    $('#QuantityDeducted').val(null);
                    $('#TotalLoss').val(null);
                    var batchId = $(this).val();
                    if (batchId) {
                        var selectedIm = response.find(function(im) {
                            return im.id == $('#SelectIm').val();
                        });
                        var selectedBatch = selectedIm.batches.find(function(
                            batch) {
                            return batch.id == batchId;
                        });
                        $('#Price').val(selectedBatch.price.toFixed(2).replace(
                            /\B(?=(\d{3})+(?!\d))/g, ","));
                    } else {
                        $('#QuantityDeducted').val(null);
                        $('#Price').val(null);
                    }
                });
                $('#QuantityDeducted, #Price').on('input', function() {
                    var quantityDeducted = parseInt($('#QuantityDeducted').val()) || 0;
                    var price = parseFloat($('#Price').val().replace(/,/g, '')) || 0;
                    var totalLoss = quantityDeducted * price;
                    $('#TotalLoss').val(totalLoss.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function hideAddAdjustmentLogModal() {
        $('#AddAdjustmentLogModal').modal('hide');
    }
    $('#AddAdjustmentLogForm').submit(function(event) {
        event.preventDefault();
        var quantityDeducted = parseInt($('#QuantityDeducted').val());
        if (quantityDeducted <= 0) {
            return;
        } else {
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('adjustment_logs.store') }}",
                type: 'POST',
                data: formData,
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideAddAdjustmentLogModal();
                    toastr.success(successMessage);
                    refreshAdjustmentLogsTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        }
    });
    function refreshAdjustmentLogsTable() {
        $.ajax({
            url: "{{ route('adjustment_logs.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#AdjustmentLogsTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(adjustment_log) {
                    var formattedDateAdjusted = new Date(adjustment_log.date_adjusted);
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var formattedDateAdjustedString = formattedDateAdjusted.toLocaleDateString(
                        'en-US',
                        options);
                    var totalLoss = adjustment_log.batch.price.toFixed(2) * adjustment_log
                        .quantity_deducted;
                    function monetaryValue(x) {
                        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    table.row.add([
                        adjustment_log.adjustment_cause,
                        adjustment_log.im.title,
                        adjustment_log.batch.name,
                        formattedDateAdjustedString,
                        '<span style="float:right;">' + adjustment_log.quantity_deducted +
                        '</span>',
                        '<span style="float:right;">' + monetaryValue(adjustment_log.batch
                            .price.toFixed(2)) + '</span>',
                        '<span style="float:right;">' + monetaryValue(totalLoss.toFixed(
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
    function numbersOnly(inputField) {
        var pattern = /^[0-9]+$/;
        var inputValue = inputField.value;
        if (!pattern.test(inputValue)) {
            inputField.value = inputValue.replace(/[^0-9]/g, '');
        }
    }
    $(document).ready(function() {
        $('#AdjustmentLogsTable').DataTable({
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
            "pageLength": 10
        }).buttons().container().appendTo('#AdjustmentLogsTable_wrapper .col-md-6:eq(0)');
        refreshAdjustmentLogsTable();
        setInterval(refreshAdjustmentLogsTable, 60000);
        $('#AddAdjustmentLogModal').on('hidden.bs.modal', function(e) {
            $('#AddAdjustmentLogForm')[0].reset();
            $('#AddAdjustmentLogModal select').val(null).trigger('change');
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshAdjustmentLogsTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection