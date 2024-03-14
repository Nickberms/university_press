@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Manage Users</title>
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
            <a class="btn btn-primary" onClick="showAddUserModal()" href="javascript:void(0)">
                <i class="fas fa-plus"></i> Add User
            </a>
            <br><br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manage Users</h3>
                </div>
                <div class="card-body">
                    <!-- USERS TABLE -->
                    <table class="table table-bordered table-striped" id="UsersTable">
                        <thead>
                            <tr>
                                <th class="text-center">Actions</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>User Type</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- USERS TABLE -->
                </div>
            </div>
        </div>
        <br>




    </div>
    <script>
    function refreshUsersTable() {
        $.ajax({
            url: "{{ route('users.index') }}",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var table = $('#UsersTable').DataTable();
                var existingRows = table.rows().remove().draw(false);
                data.forEach(function(user) {
                    table.row.add([
                        '<div class="text-center">' +
                        '<a href="#" class="edit" title="Edit" data-toggle="tooltip" data-id="' +
                        user.id + '" onclick="showEditUserModal(' + user.id +
                        ')"><i class="material-icons">&#xE254;</i></a>' +
                        '<a href="#" class="delete" title="Delete" data-toggle="tooltip" data-id="' +
                        user.id + '"><i class="material-icons">&#xE872;</i></a>' +
                        '</div>',
                        user.name,
                        user.email,
                        user.user_type
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
        $('#UsersTable').DataTable({
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
        }).buttons().container().appendTo('#UsersTable_wrapper .col-md-6:eq(0)');
        refreshUsersTable();
        setInterval(refreshUsersTable, 60000);
        $('#AddUserModal').on('hidden.bs.modal', function(e) {
            $('#AddUserForm')[0].reset();
            $('#AddUserModal select').val(null).trigger('change');
        });
        var previousWidth = $(window).width();
        $(window).on('resize', function() {
            var currentWidth = $(window).width();
            if (currentWidth !== previousWidth) {
                refreshUsersTable();
                previousWidth = currentWidth;
            }
        });
    });
    </script>
</body>


</html>

@endsection