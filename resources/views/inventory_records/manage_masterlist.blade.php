@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Masterlist</title>
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
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
</head>

<body class="hold-transition sidebar-mini" style="font-family: Roboto, sans-serif;">
    <div class="wrapper">
        <div class="container-fluid">
            <br>
            <a class="btn btn-primary" onClick="showAddInstructionalMaterialModal()" href="javascript:void(0)"
                style="background-color: #00491E; border-color: #00491E;">
                <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Instructional Material
            </a>
            <br><br>
            <div class="card">
                <div class="card-header" style="background: #E9ECEF;">
                    <h3 class="card-title">Masterlist Filters</h3>
                </div>
                <div class="card-body" style="font-size: 14px;">
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label>Select Author</label>
                            <select class="select2 form-control" id="SelectAuthor" name="select_author"
                                style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Select Category</label>
                            <select class="select2 form-control" id="SelectCategory1" name="select_category"
                                style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Select College</label>
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
                            <label>Select Publisher</label>
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
                    <h3 class="card-title">Manage Masterlist</h3>
                </div>
                <div class="card-body">
                    <!-- MASTERLIST TABLE -->
                    <table class="table table-bordered table-striped" id="MasterlistTable" style="font-size: 14px;">
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
                                <th>Unit Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                    <!-- MASTERLIST TABLE -->
                </div>
            </div>
        </div>
        <br>
        <!-- ADD INSTRUCTIONAL MATERIAL MODAL -->
        <div class="modal fade" id="AddInstructionalMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- ADD INSTRUCTIONAL MATERIAL FORM -->
                    <form id="AddInstructionalMaterialForm" method="POST">
                        @csrf
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Add Instructional Material</h4>
                            <button type="button" class="close" onClick="hideAddInstructionalMaterialModal()">
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
                                                    <label>Code</label>
                                                    <input type="text" class="form-control" name="code" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" name="title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Authors</label>
                                                    <select multiple="multiple" class="select2 form-control"
                                                        id="SelectAuthors" name="authors[]" style="width: 100%;"
                                                        required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Category</label>
                                                    <select class="select2 form-control" id="SelectCategory2"
                                                        name="category_id" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>College</label>
                                                    <select class="select2 form-control" name="college"
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
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Publisher</label>
                                                    <select class="select2 form-control" name="publisher"
                                                        style="width: 100%;">
                                                        <option value="">&nbsp;</option>
                                                        <option>University Press</option>
                                                        <option>Consigned Material</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Edition</label>
                                                    <input type="text" class="form-control" name="edition">
                                                </div>
                                                <div class="form-group">
                                                    <label>ISBN</label>
                                                    <input type="text" class="form-control" name="isbn">
                                                </div>
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea type="text" class="form-control" name="description"
                                                        style="height: 124px;"></textarea>
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
                                <button type="button" class="btn btn-danger"
                                    onClick="hideAddInstructionalMaterialModal()" href="javascript:void(0)"><i
                                        class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #00491E; border-color: #00491E;"><i
                                        class="fas fa-plus"></i>&nbsp;&nbsp;Add Instructional Material</button>
                            </div>
                        </div>
                    </form>
                    <!-- ADD INSTRUCTIONAL MATERIAL FORM -->
                </div>
            </div>
        </div>
        <!-- ADD INSTRUCTIONAL MATERIAL MODAL -->
        <!-- EDIT INSTRUCTIONAL MATERIAL MODAL -->
        <div class="modal fade" id="EditInstructionalMaterialModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- EDIT INSTRUCTIONAL MATERIAL FORM -->
                    <form id="EditInstructionalMaterialForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header" style="background: #E9ECEF;">
                            <h4 class="modal-title">Edit Instructional Material</h4>
                            <button type="button" class="close" onClick="hideEditInstructionalMaterialModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background: #02681E;">
                            <input type="hidden" id="InstructionalMaterialId" name="instructional_material_id">
                            <div class="container-fluid">
                                <div class="card card-default">
                                    <div class="row">
                                        <!-- LEFT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Code</label>
                                                    <input type="text" class="form-control" id="EditCode" name="code"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" id="EditTitle" name="title"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Authors</label>
                                                    <select multiple="multiple" class="select2 form-control"
                                                        id="EditAuthors" name="authors[]" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Category</label>
                                                    <select class="select2 form-control" id="EditCategory"
                                                        name="category_id" style="width: 100%;" required>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>College</label>
                                                    <select class="select2 form-control" id="EditCollege" name="college"
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
                                            </div>
                                        </div>
                                        <!-- LEFT SIDE -->
                                        <!-- RIGHT SIDE -->
                                        <div class="col-md-6">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Publisher</label>
                                                    <select class="select2 form-control" id="EditPublisher"
                                                        name="publisher" style="width: 100%;">
                                                        <option value="">&nbsp;</option>
                                                        <option>University Press</option>
                                                        <option>Consigned Material</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Edition</label>
                                                    <input type="text" class="form-control" id="EditEdition"
                                                        name="edition">
                                                </div>
                                                <div class="form-group">
                                                    <label>ISBN</label>
                                                    <input type="text" class="form-control" id="EditIsbn" name="isbn">
                                                </div>
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea type="text" class="form-control" id="EditDescription"
                                                        name="description" style="height: 124px;"></textarea>
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
                                <button type="button" class="btn btn-danger"
                                    onClick="hideEditInstructionalMaterialModal()" href="javascript:void(0)"><i
                                        class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                                <button type="submit" class="btn btn-primary"
                                    style="background-color: #00491E; border-color: #00491E;"><i
                                        class="fas fa-check"></i>&nbsp;&nbsp;Update Instructional Material</button>
                            </div>
                        </div>
                    </form>
                    <!-- EDIT INSTRUCTIONAL MATERIAL FORM -->
                </div>
            </div>
        </div>
        <!-- EDIT INSTRUCTIONAL MATERIAL MODAL -->
        <!-- DELETE INSTRUCTIONAL MATERIAL MODAL -->
        <div class="modal fade" id="DeleteInstructionalMaterialModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #E9ECEF;">
                        <h4 class="modal-title">Delete Instructional Material</h4>
                        <button type="button" class="close" onClick="hideDeleteInstructionalMaterialModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background: #E9ECEF;">
                        Are you sure you want to delete this instructional material?
                    </div>
                    <div class="modal-footer" style="background: #E9ECEF;">
                        <button type="button" class="btn btn-primary" onClick="hideDeleteInstructionalMaterialModal()"
                            href="javascript:void(0)" style="background-color: #00491E; border-color: #00491E;"><i
                                class="fas fa-times"></i>&nbsp;&nbsp;Cancel</button>
                        <button type="button" class="btn btn-danger" id="DeleteInstructionalMaterial"><i
                                class="fas fa-trash"></i>&nbsp;&nbsp;Delete Instructional Material</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- DELETE INSTRUCTIONAL MATERIAL MODAL -->
    </div>
    <script>
    function showAddInstructionalMaterialModal() {
        $.ajax({
            url: "{{ route('ims.create') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var selectAuthors = $('#SelectAuthors');
                selectAuthors.empty();
                response.authors.forEach(function(author) {
                    selectAuthors.append('<option value="' + author.id + '">' + author
                        .first_name + ' ' + author.last_name + '</option>');
                });
                selectAuthors.val(null).trigger('change');
                selectAuthors.select2();
                var selectCategory = $('#SelectCategory2');
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
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    }
    function hideAddInstructionalMaterialModal() {
        $('#AddInstructionalMaterialModal').modal('hide');
    }
    function showEditInstructionalMaterialModal(instructionalMaterialId) {
        $.ajax({
            url: "{{ route('ims.create') }}",
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
                    url: "{{ route('ims.edit', ':id') }}".replace(':id',
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
    function hideEditInstructionalMaterialModal() {
        $('#EditInstructionalMaterialModal').modal('hide');
    }
    function showDeleteInstructionalMaterialModal() {
        $('#DeleteInstructionalMaterialModal').modal('show');
    }
    function hideDeleteInstructionalMaterialModal() {
        $('#DeleteInstructionalMaterialModal').modal('hide');
    }
    function populateMasterlistFilters() {
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
                var selectCategory = $('#SelectCategory1');
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
    function refreshMasterlistTable() {
        var selectAuthor = $('#SelectAuthor').val();
        var selectCategory = $('#SelectCategory1').val();
        var selectCollege = $('#SelectCollege').val();
        var selectPublisher = $('#SelectPublisher').val();
        $.ajax({
            url: "{{ route('ims.index') }}",
            type: 'GET',
            dataType: 'json',
            data: {
                select_author: selectAuthor,
                select_category: selectCategory,
                select_college: selectCollege,
                select_publisher: selectPublisher
            },
            success: function(data) {
                var table = $('#MasterlistTable').DataTable();
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
                        im.description,
                        '<span style="float: right;">' + im.unit_sold + '</span>'
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
    $('#AddInstructionalMaterialForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('ims.store') }}",
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideAddInstructionalMaterialModal();
                toastr.success(successMessage);
                refreshMasterlistTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#EditInstructionalMaterialForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var instructionalMaterialId = $('#InstructionalMaterialId').val();
        $.ajax({
            url: "{{ route('ims.update', ':id') }}".replace(':id',
                instructionalMaterialId),
            type: 'POST',
            data: formData,
            success: function(response) {
                var successMessage = response.success;
                console.log(successMessage);
                hideEditInstructionalMaterialModal();
                toastr.success(successMessage);
                refreshMasterlistTable();
            },
            error: function(xhr, status, error) {
                var errorMessage = JSON.parse(xhr.responseText).error;
                console.error(errorMessage);
                toastr.error(errorMessage);
            }
        });
    });
    $('#MasterlistTable').on('click', '.delete', function(event) {
        event.preventDefault();
        var instructionalMaterialId = $(this).data('id');
        showDeleteInstructionalMaterialModal();
        $('#DeleteInstructionalMaterial').off().on('click', function() {
            $.ajax({
                url: "{{ route('ims.destroy', ':id') }}".replace(':id',
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
                    refreshMasterlistTable();
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
        $('#AddInstructionalMaterialModal').on('hidden.bs.modal', function(e) {
            $('#AddInstructionalMaterialForm')[0].reset();
            $('#AddInstructionalMaterialModal select').val(null).trigger('change');
        });
        populateMasterlistFilters();
        $('.select2').change(function() {
            refreshMasterlistTable();
        });
        $('#MasterlistTable').DataTable({
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
        }).buttons().container().appendTo('#MasterlistTable_wrapper .col-md-6:eq(0)');
        refreshMasterlistTable();
        setInterval(refreshMasterlistTable, 60000);
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshMasterlistTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>

</html>
@endsection