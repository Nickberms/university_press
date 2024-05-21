@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Departments</title>
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
    #DepartmentsTable th,
    #DepartmentsTable td {
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
                    <h3 class="card-title">Manage Departments</h3>
                    <div class="text-right">
                        <a class="btn btn-primary" onClick="showAddDepartmentModal()" href="javascript:void(0)"
                            style="background-color: #00491E; border-color: #00491E;">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- DEPARTMENTS TABLE -->
                    <table class="table table-bordered table-striped" id="DepartmentsTable" style="font-size: 14px;">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Code</th>
                                <th>Department Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <!-- DEPARTMENTS TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD DEPARTMENT MODAL -->
        <div class="modal fade" id="AddDepartmentModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- ADD DEPARTMENT FORM -->
                    <form id="AddDepartmentForm" method="POST">
                        @csrf
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Add Department</h4>
                            <button type="button" class="close" onClick="hideAddDepartmentModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Code</label>
                                                    <input type="text" class="form-control" name="code" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Department Name</label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideAddDepartmentModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                        </div>
                    </form>
                    <!-- ADD DEPARTMENT FORM -->
                </div>
            </div>
        </div>
        <!-- ADD DEPARTMENT MODAL -->
        <!-- EDIT DEPARTMENT MODAL -->
        <div class="modal fade" id="EditDepartmentModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- EDIT DEPARTMENT FORM -->
                    <form id="EditDepartmentForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Edit Department</h4>
                            <button type="button" class="close" onClick="hideEditDepartmentModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <input type="hidden" id="DepartmentId" name="department_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Code</label>
                                                    <input type="text" class="form-control" id="EditCode" name="code"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Department Name</label>
                                                    <input type="text" class="form-control" id="EditDepartmentName"
                                                        name="name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideEditDepartmentModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-check"></i>&nbsp;&nbsp;Update</button>
                        </div>
                    </form>
                    <!-- EDIT DEPARTMENT FORM -->
                </div>
            </div>
        </div>
        <!-- EDIT DEPARTMENT MODAL -->
        <!-- DELETE DEPARTMENT MODAL -->
        <div class="modal fade" id="DeleteDepartmentModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #E9ECEF;">
                        <h4 class="modal-title">Delete Department</h4>
                        <button type="button" class="close" onClick="hideDeleteDepartmentModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: #E9ECEF;">
                        Are you sure you want to delete this department?
                    </div>
                    <div class="modal-footer" style="background: #E9ECEF;">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" onClick="hideDeleteDepartmentModal()"
                                href="javascript:void(0)" style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="button" class="btn btn-danger" id="DeleteDepartment"><i
                                    class="fas fa-trash"></i>&nbsp;&nbsp;Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE DEPARTMENT MODAL -->
    </div>
    <script>
    function showAddDepartmentModal() {
        $('#AddDepartmentModal').modal('show');
    }
    function hideAddDepartmentModal() {
        $('#AddDepartmentModal').modal('hide');
    }
    function showEditDepartmentModal(departmentId) {
        $.ajax({
            url: "{{ route('departments.edit', ':id') }}".replace(':id', departmentId),
            type: 'GET',
            dataType: 'json',
            success: function(department) {
                $('#DepartmentId').val(department.id);
                $('#EditCode').val(department.code);
                $('#EditDepartmentName').val(department.name);
                $('#EditDepartmentModal').modal('show');
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideEditDepartmentModal() {
        $('#EditDepartmentModal').modal('hide');
    }
    function showDeleteDepartmentModal() {
        $('#DeleteDepartmentModal').modal('show');
    }
    function hideDeleteDepartmentModal() {
        $('#DeleteDepartmentModal').modal('hide');
    }
    $('#AddDepartmentForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('departments.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideAddDepartmentModal();
                toastr.success(successMessage);
                refreshDepartmentsTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#EditDepartmentForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var departmentId = $('#DepartmentId').val();
        $.ajax({
            url: "{{ route('departments.update', ':id') }}".replace(':id', departmentId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditDepartmentModal();
                toastr.success(successMessage);
                refreshDepartmentsTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#DepartmentsTable').on('click', '.delete', function(event) {
        event.preventDefault();
        var departmentId = $(this).data('id');
        showDeleteDepartmentModal();
        $('#DeleteDepartment').off().on('click', function() {
            $.ajax({
                url: "{{ route('departments.destroy', ':id') }}".replace(':id', departmentId),
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideDeleteDepartmentModal();
                    toastr.success(successMessage);
                    refreshDepartmentsTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        });
    });
    function refreshDepartmentsTable() {
        $.ajax({
            url: "{{ route('departments.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#DepartmentsTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(department) {
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        department.id + '" onclick="showEditDepartmentModal(' + department
                        .id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '<a href="#" class="delete" title="Delete" data-toggle="tooltip" data-id="' +
                        department.id + '"><i class="material-icons">&#xE872;</i></a>' +
                        '</div>',
                        department.code,
                        department.name
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
        $('#DepartmentsTable').DataTable({
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
            "pageLength": 10
        }).buttons().container().appendTo('#DepartmentsTable_wrapper .col-md-6:eq(0)');
        refreshDepartmentsTable();
        setInterval(refreshDepartmentsTable, 60000);
        $('#AddDepartmentModal').on('hidden.bs.modal', function(e) {
            $('#AddDepartmentForm')[0].reset();
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshDepartmentsTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection