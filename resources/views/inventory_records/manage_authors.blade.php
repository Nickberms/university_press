@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Authors</title>
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

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <a class="btn btn-primary" onClick="showAddAuthorModal()" href="javascript:void(0)"
                style="background-color: #00491E; border-color: #00491E;">
                <i class="fas fa-plus"></i> Add Author
            </a>
            <br><br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Authors</h3>
                </div>
                <div class="card-body">
                    <!-- AUTHORS TABLE -->
                    <table class="table table-bordered table-striped" id="AuthorsTable">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Author Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- AUTHORS TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD AUTHOR MODAL -->
        <div class="modal fade" id="AddAuthorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Author</h4>
                    </div>
                    <div class="modal-body">
                        <!-- ADD AUTHOR FORM -->
                        <form id="AddAuthorForm" method="POST">
                            @csrf
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="first_name">First Name</label>
                                                    <input type="text" class="form-control" name="first_name"
                                                        placeholder="Enter First Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="middle_name">Middle Name</label>
                                                    <input type="text" class="form-control" name="middle_name"
                                                        placeholder="Enter Middle Name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last_name">Last Name</label>
                                                    <input type="text" class="form-control" name="last_name"
                                                        placeholder="Enter Last Name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" onClick="hideAddAuthorModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #00491E; border-color: #00491E;">Add Author</button>
                                </div>
                            </div>
                        </form>
                        <!-- ADD AUTHOR FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD AUTHOR MODAL -->
        <!-- EDIT AUTHOR MODAL -->
        <div class="modal fade" id="EditAuthorModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Author</h4>
                    </div>
                    <div class="modal-body">
                        <!-- EDIT AUTHOR FORM -->
                        <form id="EditAuthorForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="AuthorId" name="author_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="first_name">First Name</label>
                                                    <input type="text" class="form-control" id="EditFirstName"
                                                        name="first_name" placeholder="Enter First Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="middle_name">Middle Name</label>
                                                    <input type="text" class="form-control" id="EditMiddleName"
                                                        name="middle_name" placeholder="Enter Middle Name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="last_name">Last Name</label>
                                                    <input type="text" class="form-control" id="EditLastName"
                                                        name="last_name" placeholder="Enter Last Name" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" onClick="hideEditAuthorModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #00491E; border-color: #00491E;">Update Author</button>
                                </div>
                            </div>
                        </form>
                        <!-- EDIT AUTHOR FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- EDIT AUTHOR MODAL -->
        <!-- DELETE AUTHOR MODAL -->
        <div class="modal fade" id="DeleteAuthorModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Author</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this author?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onClick="hideDeleteAuthorModal()"
                            href="javascript:void(0)"
                            style="background-color: #00491E; border-color: #00491E;">Cancel</button>
                        <button type="button" class="btn btn-danger" id="DeleteAuthor">Delete Author</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE AUTHOR MODAL -->
    </div>
    <script>
    function showAddAuthorModal() {
        $('#AddAuthorModal').modal('show');
    }
    function hideAddAuthorModal() {
        $('#AddAuthorModal').modal('hide');
    }
    function showEditAuthorModal(authorId) {
        $.ajax({
            url: "{{ route('authors.edit', ':id') }}".replace(':id', authorId),
            type: 'GET',
            dataType: 'json',
            success: function(author) {
                $('#AuthorId').val(author.id);
                $('#EditFirstName').val(author.first_name);
                $('#EditMiddleName').val(author.middle_name);
                $('#EditLastName').val(author.last_name);
                $('#EditAuthorModal').modal('show');
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideEditAuthorModal() {
        $('#EditAuthorModal').modal('hide');
    }
    function showDeleteAuthorModal() {
        $('#DeleteAuthorModal').modal('show');
    }
    function hideDeleteAuthorModal() {
        $('#DeleteAuthorModal').modal('hide');
    }
    $('#AddAuthorForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('authors.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideAddAuthorModal();
                toastr.success(successMessage);
                refreshAuthorsTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#EditAuthorForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var authorId = $('#AuthorId').val();
        $.ajax({
            url: "{{ route('authors.update', ':id') }}".replace(':id', authorId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditAuthorModal();
                toastr.success(successMessage);
                refreshAuthorsTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#AuthorsTable').on('click', '.delete', function(event) {
        event.preventDefault();
        var authorId = $(this).data('id');
        showDeleteAuthorModal();
        $('#DeleteAuthor').off().on('click', function() {
            $.ajax({
                url: "{{ route('authors.destroy', ':id') }}".replace(':id', authorId),
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideDeleteAuthorModal();
                    toastr.success(successMessage);
                    refreshAuthorsTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        });
    });
    function refreshAuthorsTable() {
        $.ajax({
            url: "{{ route('authors.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#AuthorsTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(author) {
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        author.id + '" onclick="showEditAuthorModal(' + author.id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '<a href="#" class="delete" title="Delete" data-toggle="tooltip" data-id="' +
                        author.id + '"><i class="material-icons">&#xE872;</i></a>' +
                        '</div>',
                        author.first_name + ' ' + (author.middle_name ? author
                            .middle_name +
                            ' ' : '') + author.last_name
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
        $('#AuthorsTable').DataTable({
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
        }).buttons().container().appendTo('#AuthorsTable_wrapper .col-md-6:eq(0)');
        refreshAuthorsTable();
        setInterval(refreshAuthorsTable, 60000);
        $('#AddAuthorModal').on('hidden.bs.modal', function(e) {
            $('#AddAuthorForm')[0].reset();
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshAuthorsTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection