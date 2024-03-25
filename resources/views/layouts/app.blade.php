<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="admin/https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="admin/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="admin/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="admin/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="admin/plugins/bs-stepper/css/bs-stepper.min.css">
    <link rel="stylesheet" href="admin/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    @yield('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
    table.table td a.view {
        color: #03A9F4;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    </style>
    <script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
        var searchInput = $(".search-box input");
        var inputGroup = $(".search-box .input-group");
        var boxWidth = inputGroup.width();
        searchInput.focus(function() {
            inputGroup.animate({
                width: "300"
            });
        }).blur(function() {
            inputGroup.animate({
                width: boxWidth
            });
        });
    });
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-yellow">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="mr-2 fas fa-user-circle"></i>
                            {{ __('My Profile') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="mr-2 fas fa-sign-out-alt"></i>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a class="brand-link">
                <span class="brand-text font-weight-light" style="text-align:center;color:white;">University
                    Press</span>
            </a>
            @if(Auth::check())
            @if(Auth::user()->account_type == 'Admin' || Auth::user()->account_type == 'Super Admin')
            @include('admin_dashboard.admin_navigation')
            @elseif(Auth::user()->account_type == 'Employee')
            @include('employee_dashboard.employee_navigation')
            @endif
            @endif
        </aside>
        <div class="content-wrapper">
            @yield('content')
        </div>
        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
    </div>
    @yield('scripts')
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <script src="admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="admin/plugins/chart.js/Chart.min.js"></script>
    <script src="admin/plugins/sparklines/sparkline.js"></script>
    <script src="admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="admin/plugins/moment/moment.min.js"></script>
    <script src="admin/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="admin/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="admin/dist/js/pages/dashboard.js"></script>
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <script src="admin/plugins/jquery/jquery.min.js"></script>
    <script src="admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="admin/plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="admin/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="admin/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="admin/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="admin/plugins/jszip/jszip.min.js"></script>
    <script src="admin/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="admin/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="admin/plugins/daterangepicker/daterangepicker.js"></script>
    <script>
    $(function() {
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        $('[data-mask]').inputmask()
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
        $('#reservation').daterangepicker()
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            }
        )
        $('#timepicker').datetimepicker({
            format: 'LT'
        })
        $('.duallistbox').bootstrapDualListbox()
        $('.my-colorpicker1').colorpicker()
        $('.my-colorpicker2').colorpicker()
        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    })
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    })
    Dropzone.autoDiscover = false
    var previewNode = document.querySelector("#template")
    previewNode.id = ""
    var previewTemplate = previewNode.parentNode.innerHTML
    previewNode.parentNode.removeChild(previewNode)
    var myDropzone = new Dropzone(document.body, {
        url: "/target-url",
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false,
        previewsContainer: "#previews",
        clickable: ".fileinput-button"
    })
    myDropzone.on("addedfile", function(file) {
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file)
        }
    })
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    })
    myDropzone.on("sending", function(file) {
        document.querySelector("#total-progress").style.opacity = "1"
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    })
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
    })
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    }
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
    }
    </script>
</body>

</html>