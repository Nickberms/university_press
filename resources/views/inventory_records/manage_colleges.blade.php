@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Colleges</title>
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
    #CollegesTable th,
    #CollegesTable td {
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
                    <h3 class="card-title">Manage Colleges</h3>
                    <div class="text-right">
                        <a class="btn btn-primary" onClick="showAddCollegeModal()" href="javascript:void(0)"
                            style="background-color: #00491E; border-color: #00491E;">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp;Add
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- COLLEGES TABLE -->
                    <table class="table table-bordered table-striped" id="CollegesTable" style="font-size: 14px;">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Code</th>
                                <th>College Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <!-- COLLEGES TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD COLLEGE MODAL -->
        <div class="modal fade" id="AddCollegeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- ADD COLLEGE FORM -->
                    <form id="AddCollegeForm" method="POST">
                        @csrf
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Add College</h4>
                            <button type="button" class="close" onClick="hideAddCollegeModal()">
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
                                                    <label>College Name</label>
                                                    <input type="text" class="form-control" name="name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideAddCollegeModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-plus"></i>&nbsp;&nbsp;Add</button>
                        </div>
                    </form>
                    <!-- ADD COLLEGE FORM -->
                </div>
            </div>
        </div>
        <!-- ADD COLLEGE MODAL -->
        <!-- EDIT COLLEGE MODAL -->
        <div class="modal fade" id="EditCollegeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- EDIT COLLEGE FORM -->
                    <form id="EditCollegeForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Edit College</h4>
                            <button type="button" class="close" onClick="hideEditCollegeModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <input type="hidden" id="CollegeId" name="college_id">
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
                                                    <label>College Name</label>
                                                    <input type="text" class="form-control" id="EditCollegeName"
                                                        name="name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background: #E9ECEF;">
                            <button type="button" class="btn btn-danger" onClick="hideEditCollegeModal()"
                                href="javascript:void(0)"><i class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-check"></i>&nbsp;&nbsp;Update</button>
                        </div>
                    </form>
                    <!-- EDIT COLLEGE FORM -->
                </div>
            </div>
        </div>
        <!-- EDIT COLLEGE MODAL -->
        <!-- DELETE COLLEGE MODAL -->
        <div class="modal fade" id="DeleteCollegeModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #E9ECEF;">
                        <h4 class="modal-title">Delete College</h4>
                        <button type="button" class="close" onClick="hideDeleteCollegeModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: #E9ECEF;">
                        Are you sure you want to delete this college?
                    </div>
                    <div class="modal-footer" style="background: #E9ECEF;">
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" onClick="hideDeleteCollegeModal()"
                                href="javascript:void(0)" style="background-color: #00491E; border-color: #00491E;"><i
                                    class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                            <button type="button" class="btn btn-danger" id="DeleteCollege"><i
                                    class="fas fa-trash"></i>&nbsp;&nbsp;Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE COLLEGE MODAL -->
    </div>
    <script>
    function showAddCollegeModal() {
        $('#AddCollegeModal').modal('show');
    }
    function hideAddCollegeModal() {
        $('#AddCollegeModal').modal('hide');
    }
    function showEditCollegeModal(collegeId) {
        $.ajax({
            url: "{{ route('colleges.edit', ':id') }}".replace(':id', collegeId),
            type: 'GET',
            dataType: 'json',
            success: function(college) {
                $('#CollegeId').val(college.id);
                $('#EditCode').val(college.code);
                $('#EditCollegeName').val(college.name);
                $('#EditCollegeModal').modal('show');
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideEditCollegeModal() {
        $('#EditCollegeModal').modal('hide');
    }
    function showDeleteCollegeModal() {
        $('#DeleteCollegeModal').modal('show');
    }
    function hideDeleteCollegeModal() {
        $('#DeleteCollegeModal').modal('hide');
    }
    $('#AddCollegeForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('colleges.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideAddCollegeModal();
                toastr.success(successMessage);
                refreshCollegesTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#EditCollegeForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var collegeId = $('#CollegeId').val();
        $.ajax({
            url: "{{ route('colleges.update', ':id') }}".replace(':id', collegeId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditCollegeModal();
                toastr.success(successMessage);
                refreshCollegesTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#CollegesTable').on('click', '.delete', function(event) {
        event.preventDefault();
        var collegeId = $(this).data('id');
        showDeleteCollegeModal();
        $('#DeleteCollege').off().on('click', function() {
            $.ajax({
                url: "{{ route('colleges.destroy', ':id') }}".replace(':id', collegeId),
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideDeleteCollegeModal();
                    toastr.success(successMessage);
                    refreshCollegesTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        });
    });
    function refreshCollegesTable() {
        $.ajax({
            url: "{{ route('colleges.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#CollegesTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(college) {
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        college.id + '" onclick="showEditCollegeModal(' + college.id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '<a href="#" class="delete" title="Delete" data-toggle="tooltip" data-id="' +
                        college.id + '"><i class="material-icons">&#xE872;</i></a>' +
                        '</div>',
                        college.code,
                        college.name
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
        $('#CollegesTable').DataTable({
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
        }).buttons().container().appendTo('#CollegesTable_wrapper .col-md-6:eq(0)');
        refreshCollegesTable();
        setInterval(refreshCollegesTable, 60000);
        $('#AddCollegeModal').on('hidden.bs.modal', function(e) {
            $('#AddCollegeForm')[0].reset();
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshCollegesTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection