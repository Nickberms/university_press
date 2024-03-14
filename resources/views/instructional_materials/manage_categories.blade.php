@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Categories</title>
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
            <a class="btn btn-primary" onClick="showAddCategoryModal()" href="javascript:void(0)">
                <i class="fas fa-plus"></i> Add Category
            </a>
            <br><br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Categories</h3>
                </div>
                <div class="card-body">
                    <!-- CATEGORIES TABLE -->
                    <table class="table table-bordered table-striped" id="CategoriesTable">
                        <thead>
                            <tr>
                                <th class="text-center">Actions</th>
                                <th>Category Name</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- CATEGORIES TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD CATEGORY MODAL -->
        <div class="modal fade" id="AddCategoryModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Category</h4>
                    </div>
                    <div class="modal-body">
                        <!-- ADD CATEGORY FORM -->
                        <form id="AddCategoryForm" method="POST">
                            @csrf
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="name">Category Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Enter Category Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea type="text" class="form-control" name="description"
                                                        placeholder="Enter Description"
                                                        style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" onClick="hideAddCategoryModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                        <!-- ADD CATEGORY FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD CATEGORY MODAL -->
        <!-- EDIT CATEGORY MODAL -->
        <div class="modal fade" id="EditCategoryModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category</h4>
                    </div>
                    <div class="modal-body">
                        <!-- EDIT CATEGORY FORM -->
                        <form id="EditCategoryForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="CategoryId" name="category_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="name">Category Name</label>
                                                    <input type="text" class="form-control" id="EditName" name="name"
                                                        placeholder="Enter Category Name" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea type="text" class="form-control" id="EditDescription"
                                                        name="description" placeholder="Enter Description"
                                                        style="height: 100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger" onClick="hideEditCategoryModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                        <!-- EDIT CATEGORY FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- EDIT CATEGORY MODAL -->
        <!-- DELETE CATEGORY MODAL -->
        <div class="modal fade" id="DeleteCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Category</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this category?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onClick="hideDeleteCategoryModal()"
                            href="javascript:void(0)">Cancel</button>
                        <button type="button" class="btn btn-danger" id="DeleteCategory">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE CATEGORY MODAL -->
    </div>
    <script>
    function showAddCategoryModal() {
        $('#AddCategoryModal').modal('show');
    }
    function hideAddCategoryModal() {
        $('#AddCategoryModal').modal('hide');
    }
    function showEditCategoryModal(categoryId) {
        $.ajax({
            url: "{{ route('categories.edit', ':id') }}".replace(':id', categoryId),
            type: 'GET',
            dataType: 'json',
            success: function(category) {
                $('#CategoryId').val(category.id);
                $('#EditName').val(category.name);
                $('#EditDescription').val(category.description);
                $('#EditCategoryModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function hideEditCategoryModal() {
        $('#EditCategoryModal').modal('hide');
    }
    function showDeleteCategoryModal() {
        $('#DeleteCategoryModal').modal('show');
    }
    function hideDeleteCategoryModal() {
        $('#DeleteCategoryModal').modal('hide');
    }
    $('#AddCategoryForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('categories.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideAddCategoryModal();
                toastr.success(successMessage);
                refreshCategoriesTable();
            },
            error: function(xhr, status, error) {
                location.reload();
                console.error(xhr.responseText);
            }
        });
    });
    $('#EditCategoryForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var categoryId = $('#CategoryId').val();
        $.ajax({
            url: "{{ route('categories.update', ':id') }}".replace(':id', categoryId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditCategoryModal();
                toastr.success(successMessage);
                refreshCategoriesTable();
            },
            error: function(xhr, status, error) {
                location.reload();
                console.error(xhr.responseText);
            }
        });
    });
    $('#CategoriesTable').on('click', '.delete', function(event) {
        event.preventDefault();
        var categoryId = $(this).data('id');
        showDeleteCategoryModal();
        $('#DeleteCategory').off().on('click', function() {
            $.ajax({
                url: "{{ route('categories.destroy', ':id') }}".replace(':id', categoryId),
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideDeleteCategoryModal();
                    toastr.success(successMessage);
                    refreshCategoriesTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        });
    });
    function refreshCategoriesTable() {
        $.ajax({
            url: "{{ route('categories.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#CategoriesTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(category) {
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        category.id + '" onclick="showEditCategoryModal(' + category.id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '<a href="#" class="delete" title="Delete" data-toggle="tooltip" data-id="' +
                        category.id + '"><i class="material-icons">&#xE872;</i></a>' +
                        '</div>',
                        category.name,
                        category.description
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
        $('#CategoriesTable').DataTable({
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
        }).buttons().container().appendTo('#CategoriesTable_wrapper .col-md-6:eq(0)');
        refreshCategoriesTable();
        setInterval(refreshCategoriesTable, 60000);
        $('#AddCategoryModal').on('hidden.bs.modal', function(e) {
            $('#AddCategoryForm')[0].reset();
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshCategoriesTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection