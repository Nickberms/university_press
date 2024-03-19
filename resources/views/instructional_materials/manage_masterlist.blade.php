@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Instructional Materials</title>
    <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
    <script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="admin/plugins/toastr/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <a class="btn btn-primary" onClick="showAddInstructionalMaterialModal()" href="javascript:void(0)" style="background-color: #00491E;">
                <i class="fas fa-plus"></i> Add Instructional Material
            </a>
            <br><br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Instructional Materials</h3>
                </div>
                <div class="card-body">
                    <!-- INSTRUCTIONAL MATERIALS TABLE -->
                    <table class="table table-bordered table-striped" id="InstructionalMaterialsTable">
                        <thead class="text-center">
                            <tr>
                                <th>Actions</th>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Authors</th>
                                <th>Category</th>
                                <th>College</th>
                                <th>Publisher</th>
                                <th>Edition</th>
                                <th>ISBN</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- INSTRUCTIONAL MATERIALS TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD INSTRUCTIONAL MATERIAL MODAL -->
        <div class="modal fade" id="AddInstructionalMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Instructional Material</h4>
                    </div>
                    <div class="modal-body">
                        <!-- ADD INSTRUCTIONAL MATERIAL FORM -->
                        <form id="AddInstructionalMaterialForm" method="POST">
                            @csrf
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="code">Code</label>
                                                    <input type="text" class="form-control" name="code"
                                                        placeholder="Enter Code" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" name="title"
                                                        placeholder="Enter Title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="authors">Authors</label>
                                                    <select multiple="multiple" class="select2 form-control"
                                                        id="ChooseAuthors" name="authors[]"
                                                        data-placeholder="Select Authors" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select class="select2 form-control" id="ChooseCategory"
                                                        name="category" data-placeholder="Select Category"
                                                        style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="college">College</label>
                                                    <select class="select2 form-control" name="college"
                                                        data-placeholder="Select College" style="width: 100%;">
                                                        <option value="" disabled selected>Select College</option>
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
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="publisher">Publisher</label>
                                                    <select class="select2 form-control" name="publisher"
                                                        data-placeholder="Select Publisher" style="width: 100%;">
                                                        <option value="" disabled selected>Select Publisher</option>
                                                        <option value=" "></option>
                                                        <option>University Press</option>
                                                        <option>Consigned Material</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edition">Edition</label>
                                                    <input type="text" class="form-control" name="edition"
                                                        placeholder="Enter Edition">
                                                </div>
                                                <div class="form-group">
                                                    <label for="isbn">ISBN</label>
                                                    <input type="text" class="form-control" name="isbn"
                                                        placeholder="Enter ISBN">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea type="text" class="form-control" name="description"
                                                        placeholder="Enter Description"
                                                        style="height: 124px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger"
                                        onClick="hideAddInstructionalMaterialModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary" style="background-color: #00491E;">Add</button>
                                </div>
                            </div>
                        </form>
                        <!-- ADD INSTRUCTIONAL MATERIAL FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD INSTRUCTIONAL MATERIAL MODAL -->
        <!-- EDIT INSTRUCTIONAL MATERIAL MODAL -->
        <div class="modal fade" id="EditInstructionalMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Instructional Material</h4>
                    </div>
                    <div class="modal-body">
                        <!-- EDIT INSTRUCTIONAL MATERIAL FORM -->
                        <form id="EditInstructionalMaterialForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="InstructionalMaterialId" name="instructional_material_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="code">Code</label>
                                                    <input type="text" class="form-control" id="EditCode" name="code"
                                                        placeholder="Enter Code" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" id="EditTitle" name="title"
                                                        placeholder="Enter Title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="authors">Authors</label>
                                                    <select multiple="multiple" class="select2 form-control"
                                                        id="EditAuthors" name="authors[]"
                                                        data-placeholder="Select Authors" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="category">Category</label>
                                                    <select class="select2 form-control" id="EditCategory"
                                                        name="category" data-placeholder="Select Category"
                                                        style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="college">College</label>
                                                    <select class="select2 form-control" id="EditCollege" name="college"
                                                        data-placeholder="Select College" style="width: 100%;">
                                                        <option value="" disabled selected>Select College</option>
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
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="publisher">Publisher</label>
                                                    <select class="select2 form-control" id="EditPublisher"
                                                        name="publisher" data-placeholder="Select Publisher"
                                                        style="width: 100%;">
                                                        <option value="" disabled selected>Select Publisher</option>
                                                        <option value=" "></option>
                                                        <option>University Press</option>
                                                        <option>Consigned Material</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edition">Edition</label>
                                                    <input type="text" class="form-control" id="EditEdition"
                                                        name="edition" placeholder="Enter Edition">
                                                </div>
                                                <div class="form-group">
                                                    <label for="isbn">ISBN</label>
                                                    <input type="text" class="form-control" id="EditIsbn" name="isbn"
                                                        placeholder="Enter ISBN">
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea type="text" class="form-control" id="EditDescription"
                                                        name="description" placeholder="Enter Description"
                                                        style="height: 124px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RIGHT SIDE -->
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger"
                                        onClick="hideEditInstructionalMaterialModal()"
                                        href="javascript:void(0)">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                        <!-- EDIT INSTRUCTIONAL MATERIAL FORM -->
                    </div>
                </div>
            </div>
        </div>
        <!-- EDIT INSTRUCTIONAL MATERIAL MODAL -->
        <!-- DELETE INSTRUCTIONAL MATERIAL MODAL -->
        <div class="modal fade" id="DeleteInstructionalMaterialModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Instructional Material</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this instructional material?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onClick="hideDeleteInstructionalMaterialModal()"
                            href="javascript:void(0)">Cancel</button>
                        <button type="button" class="btn btn-danger" id="DeleteInstructionalMaterial">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE INSTRUCTIONAL MATERIAL MODAL -->
    </div>
    <script>
    function showAddInstructionalMaterialModal() {
        $.ajax({
            url: "{{ route('instructional_materials.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectAuthors = $('#ChooseAuthors');
                selectAuthors.empty();
                response.authors.forEach(function(author) {
                    selectAuthors.append('<option value="' + author.id + '">' + author
                        .first_name + ' ' + author.last_name + '</option>');
                });
                selectAuthors.val(null).trigger('change');
                selectAuthors.select2();
                var selectCategory = $('#ChooseCategory');
                selectCategory.empty();
                response.categories.forEach(function(category) {
                    selectCategory.append('<option value="' + category.id + '">' + category
                        .name + '</option>');
                });
                selectCategory.val(null).trigger('change');
                selectCategory.select2();
                $('#AddInstructionalMaterialModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function hideAddInstructionalMaterialModal() {
        $('#AddInstructionalMaterialModal').modal('hide');
    }
    function showEditInstructionalMaterialModal(instructionalMaterialId) {
        $.ajax({
            url: "{{ route('instructional_materials.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectAuthors = $('#EditAuthors');
                selectAuthors.empty();
                response.authors.forEach(function(author) {
                    selectAuthors.append('<option value="' + author.id + '">' + author
                        .first_name + ' ' + author.last_name + '</option>');
                });
                selectAuthors.select2();
                var selectCategory = $('#EditCategory');
                selectCategory.empty();
                response.categories.forEach(function(category) {
                    selectCategory.append('<option value="' + category.id + '">' + category
                        .name + '</option>');
                });
                selectCategory.select2();
                $.ajax({
                    url: "{{ route('instructional_materials.edit', ':id') }}".replace(':id',
                        instructionalMaterialId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(instructionalMaterial) {
                        $('#InstructionalMaterialId').val(
                            instructionalMaterial.id);
                        $('#EditCode').val(instructionalMaterial
                            .code);
                        $('#EditTitle').val(instructionalMaterial
                            .title);
                        $('#EditCategory').val(instructionalMaterial
                                .category_id)
                            .trigger('change');
                        $('#EditCollege').val(instructionalMaterial
                            .college).trigger(
                            'change');
                        $('#EditPublisher').val(
                                instructionalMaterial.publisher)
                            .trigger('change');
                        $('#EditEdition').val(instructionalMaterial
                            .edition);
                        $('#EditIsbn').val(instructionalMaterial
                            .isbn);
                        $('#EditDescription').val(
                            instructionalMaterial.description);
                        var selectAuthors = $('#EditAuthors');
                        selectAuthors.find('option').each(function() {
                            var authorId = $(this).val();
                            $(this).prop('selected', instructionalMaterial.authors.some(
                                function(author) {
                                    return author.id == authorId;
                                }));
                        });
                        selectAuthors.trigger('change');
                        $('#EditInstructionalMaterialModal').modal('show');
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
    function hideEditInstructionalMaterialModal() {
        $('#EditInstructionalMaterialModal').modal('hide');
    }
    function showDeleteInstructionalMaterialModal() {
        $('#DeleteInstructionalMaterialModal').modal('show');
    }
    function hideDeleteInstructionalMaterialModal() {
        $('#DeleteInstructionalMaterialModal').modal('hide');
    }
    $('#AddInstructionalMaterialForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('instructional_materials.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideAddInstructionalMaterialModal();
                toastr.success(successMessage);
                refreshInstructionalMaterialsTable();
            },
            error: function(xhr, status, error) {
                location.reload();
                console.error(xhr.responseText);
            }
        });
    });
    $('#EditInstructionalMaterialForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var instructionalMaterialId = $('#InstructionalMaterialId').val();
        $.ajax({
            url: "{{ route('instructional_materials.update', ':id') }}".replace(':id',
                instructionalMaterialId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditInstructionalMaterialModal();
                toastr.success(successMessage);
                refreshInstructionalMaterialsTable();
            },
            error: function(xhr, status, error) {
                location.reload();
                console.error(xhr.responseText);
            }
        });
    });
    $('#InstructionalMaterialsTable').on('click', '.delete', function(event) {
        event.preventDefault();
        var instructionalMaterialId = $(this).data('id');
        showDeleteInstructionalMaterialModal();
        $('#DeleteInstructionalMaterial').off().on('click', function() {
            $.ajax({
                url: "{{ route('instructional_materials.destroy', ':id') }}".replace(':id',
                    instructionalMaterialId),
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var successMessage = response.success;
                    console.log(successMessage);
                    hideDeleteInstructionalMaterialModal();
                    toastr.success(successMessage);
                    refreshInstructionalMaterialsTable();
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText).error;
                    console.error(errorMessage);
                    toastr.error(errorMessage);
                }
            });
        });
    });
    function refreshInstructionalMaterialsTable() {
        $.ajax({
            url: "{{ route('instructional_materials.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#InstructionalMaterialsTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(im) {
                    var authors = '';
                    if (im.authors.length > 1) {
                        authors += im.authors[0].last_name + ' et al.<br>';
                    } else {
                        authors += im.authors[0].last_name + '<br>';
                    }
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        im.id + '" onclick="showEditInstructionalMaterialModal(' + im.id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '<a href="#" class="delete" title="Delete" data-toggle="tooltip" data-id="' +
                        im.id + '"><i class="material-icons">&#xE872;</i></a>' +
                        '</div>',
                        im.code,
                        im.title,
                        authors,
                        im.category.name,
                        im.college,
                        im.publisher,
                        im.edition,
                        im.isbn,
                        im.description
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
        $('#InstructionalMaterialsTable').DataTable({
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
        }).buttons().container().appendTo('#InstructionalMaterialsTable_wrapper .col-md-6:eq(0)');
        refreshInstructionalMaterialsTable();
        setInterval(refreshInstructionalMaterialsTable, 60000);
        $('#AddInstructionalMaterialModal').on('hidden.bs.modal', function(e) {
            $('#AddInstructionalMaterialForm')[0].reset();
            $('#AddInstructionalMaterialModal select').val(null).trigger('change');
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshInstructionalMaterialsTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection