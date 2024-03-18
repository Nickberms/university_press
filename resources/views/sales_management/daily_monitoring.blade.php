@extends('layouts.app')
@section('content')
<html>

<head>
    <title>Daily Monitoring</title>
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

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <br>
           
                <div class="card card-primary col-md-2">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Select Month:</label>
                            <div class="input-group">
                                <input type="month" id="month" name="month" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            
            <br>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daily Monitoring</h3>
                </div>
                <div class="card-body">
                    <!-- MONITORING TABLE -->
                    <table class="table table-bordered table-striped" id="MonitoringTable" style="font-size: 12px">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Title</th>
                                <th>Batch</th>
                                <th>Unit Price</th>
                                <th>Quantity Available</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                                <th>7</th>
                                <th>8</th>
                                <th>9</th>
                                <th>10</th>
                                <th>11</th>
                                <th>12</th>
                                <th>13</th>
                                <th>14</th>
                                <th>15</th>
                                <th>16</th>
                                <th>17</th>
                                <th>18</th>
                                <th>19</th>
                                <th>20</th>
                                <th>21</th>
                                <th>22</th>
                                <th>23</th>
                                <th>24</th>
                                <th>25</th>
                                <th>26</th>
                                <th>27</th>
                                <th>28</th>
                                <th>29</th>
                                <th>30</th>
                                <th>31</th>
                                <th>Unit Sold</th>
                                <th>Sales</th>
                                <th>Available Stocks</th>
                                <th>Inventory Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- MONITORING TABLE -->
                </div>
            </div>
        </div>
        <br>
    </div>
    <script>
    $(document).ready(function() {
        $('#MonitoringTable').DataTable({
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
        }).buttons().container().appendTo('#MonitoringTable_wrapper .col-md-6:eq(0)');
    });
    </script>

</body>


</html>
@endsection