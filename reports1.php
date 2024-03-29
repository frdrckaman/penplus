<?php
require 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        $site_data = $override->getData('site');
        $Total = $override->getCount('clients', 'status', 1);
        $data_enrolled = $override->getCount1('clients', 'status', 1, 'enrolled', 1);

        $successMessage = 'Report Successful Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include 'headBar.php'; ?>

<style>
    /* Define a class for the table */
    .table {
        width: 100%;
        /* Initially, set the width to 100% */
        margin-bottom: 1rem;
        background-color: transparent;
        border-collapse: collapse;
        border-spacing: 0;
    }

    /* Define styles for table header cells */
    .table th {
        font-weight: bold;
        background-color: #f2f2f2;
        color: #333;
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    /* Define styles for table data cells */
    .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    /* Small screens (sm) */
    @media only screen and (max-width: 100px) {
        .table-sm {
            font-size: 12px;
            /* Decrease font size for small screens */
        }
    }

    /* Medium screens (md) */
    @media only screen and (min-width: 200px) and (max-width: 300px) {
        .table-md {
            font-size: 14px;
            /* Set font size for medium screens */
        }
    }

    /* Large screens (lg) */
    @media only screen and (min-width: 500px) {
        .table-lg {
            font-size: 16px;
            /* Set font size for large screens */
        }
    }
</style>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>RECRUITMENTS STATUS</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index1.php">Home</a></li>
                                <li class="breadcrumb-item active">RECRUITMENTS STATUS</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <?php
            $test_list = $override->get('test_list', 'delete_flag', 0);
            ?>

            <style>
                .img-thumb-path {
                    width: 100px;
                    height: 80px;
                    object-fit: scale-down;
                    object-position: center center;
                }
            </style>

            <!-- Main content -->
            <div class="card card-outline card-primary rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">PENPLUS RECRUITMENTS STATUS AS OF <?= date('Y-m-d') ?></h3>
                    <div class="card-tools">
                        <a class="btn btn-default border btn-flat btn-sm" href="index1.php"><i class="fa fa-angle-left"></i> Back</a>
                        <a class="btn btn-flat btn-sm btn-primary" href="reports1_1.php"><span class="fas fa-download text-default">&nbsp;&nbsp;</span>Download Report</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="container-fluid">
                            <table class="table table-bordered table-hover table-striped table-sm table-md table-lg">
                                <colgroup>
                                    <col width="5%">
                                    <col width="20%">
                                    <col width="25%">
                                    <col width="20%">
                                    <col width="15%">
                                    <col width="15%">
                                </colgroup>
                                <thead>
                                    <!-- <tr class="bg-gradient-primary text-light">
                                        <th>#</th>
                                        <th>Site</th>
                                        <th>Registered</th>
                                        <th>Screened</th>
                                        <th>Cardiac</th>
                                        <th>Diabetes</th>
                                        <th>Sickle cell</th>
                                        <th>Other Diagnosis</th>
                                        <th>Eligible</th>
                                        <th>Enrolled</th>
                                        <th>End</th>
                                    </tr> -->
                                    <tr>
                                        <th rowspan="2">No.</th>
                                        <th rowspan="2">SITE</th>
                                        <th rowspan="2">REGISTERED</th>
                                        <th rowspan="2">SCREENED.</th>
                                        <th rowspan="2">ELIGIBLE</th>
                                        <th colspan="5"> Category ( INCLUSION )</th>
                                        <th rowspan="2">ENROLLED</th>
                                        <th rowspan="2">END</th>
                                    </tr>
                                    <tr>
                                        <th>Cardiac</th>
                                        <th>Diabetes(Type 1)</th>
                                        <th>Diabetes(Type 2)</th>
                                        <th>Sickle cell </th>
                                        <th>Sickle cell( Other ) </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $i = 1;
                                    foreach ($site_data as $row) {
                                        $registered = $override->countData('clients', 'status', 1, 'site_id', $row['id']);
                                        $registered_Total = $override->getCount('clients', 'status', 1);
                                        $screened = $override->countData2('clients', 'status', 1, 'screened', 1, 'site_id', $row['id']);
                                        $screened_Total = $override->countData('clients', 'status', 1, 'screened', 1);
                                        $sickle_cell1 = $override->countData2('sickle_cell', 'status', 1, 'diagnosis', 1, 'site_id', $row['id']);
                                        $sickle_cell_Total1 = $override->countData('sickle_cell', 'status', 1, 'diagnosis', 1);
                                        $sickle_cell2 = $override->countData2('sickle_cell', 'status', 1, 'diagnosis', 96, 'site_id', $row['id']);
                                        $sickle_cell_Total2 = $override->countData('sickle_cell', 'status', 1, 'diagnosis', 96);
                                        $sickle_cell = $override->countData2('clients', 'status', 1, 'sickle_cell', 1, 'site_id', $row['id']);
                                        $sickle_cell_Total = $override->countData('clients', 'status', 1, 'sickle_cell', 1);
                                        $cardiac = $override->countData2('clients', 'status', 1, 'cardiac', 1, 'site_id', $row['id']);
                                        $cardiac_Total = $override->countData('clients', 'status', 1, 'cardiac', 1);
                                        $diabetes1 = $override->countData2('diabetic', 'status', 1, 'diagnosis', 1, 'site_id', $row['id']);
                                        $diabetes_Total1 = $override->countData('diabetic', 'status', 1, 'diagnosis', 1);
                                        $diabetes2 = $override->countData2('diabetic', 'status', 1, 'diagnosis', 2, 'site_id', $row['id']);
                                        $diabetes_Total2 = $override->countData('diabetic', 'status', 1, 'diagnosis', 2);
                                        $diabetes = $override->countData2('clients', 'status', 1, 'diabetes', 1, 'site_id', $row['id']);
                                        $diabetes_Total = $override->countData('clients', 'status', 1, 'diabetes', 1);
                                        $eligible = $override->countData2('clients', 'status', 1, 'eligible', 1, 'site_id', $row['id']);
                                        $eligible_Total = $override->countData('clients', 'status', 1, 'eligible', 1);
                                        $enrolled = $override->countData2('clients', 'status', 1, 'enrolled', 1, 'site_id', $row['id']);
                                        $enrolled_Total = $override->countData('clients', 'status', 1, 'enrolled', 1);
                                        $end_study = $override->countData2('clients', 'status', 1, 'end_study', 1, 'site_id', $row['id']);
                                        $end_study_Total = $override->countData('clients', 'status', 1, 'end_study', 1);
                                    ?>
                                        <!-- <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td class=""><?php echo $row['name'] ?></td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $registered ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $screened ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $cardiac ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $diabetes ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $sickle_cell ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $other ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $eligible ?></p>
                                            </td>
                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $enrolled ?></p>
                                            </td>

                                            <td class="">
                                                <p class="m-0 truncate-1"><?php echo $end_study ?></p>
                                            </td>
                                        </tr> -->

                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td align="right"><?= $registered ?></td>
                                            <td align="right"><?= $screened ?></td>
                                            <td align="right"><?= $eligible ?></td>
                                            <td align="right"><?= $cardiac ?></td>
                                            <td align="right"><?= $diabetes1 ?></td>
                                            <td align="right"><?= $diabetes2 ?></td>
                                            <td align="right"><?= $sickle_cell1 ?></td>
                                            <td align="right"><?= $sickle_cell2 ?></td>
                                            <td align="right"><?= $enrolled ?></td>
                                            <td align="right"><?= $end_study ?></td>
                                        </tr>


                                    <?php
                                        $i++;
                                    } ?>

                                    <tr>
                                        <td align="right" colspan="2"><b>Total</b></td>
                                        <td align="right"><b><?= $registered_Total ?></b></td>
                                        <td align="right"><b><?= $screened_Total ?></b></td>
                                        <td align="right"><b><?= $eligible_Total ?></b></td>
                                        <td align="right"><b><?= $cardiac_Total ?></b></td>
                                        <td align="right"><b><?= $diabetes_Total1 ?></b></td>
                                        <td align="right"><b><?= $diabetes_Total2 ?></b></td>
                                        <td align="right"><b><?= $sickle_cell_Total1 ?></b></td>
                                        <td align="right"><b><?= $sickle_cell_Total2 ?></b></td>
                                        <td align="right"><b><?= $enrolled_Total ?></b></td>
                                        <td align="right"><b><?= $end_study_Total ?></b></td>
                                    </tr>

                                    <!-- <tr>
                                        <td class="text-center"></td>
                                        <td class="">TOTAL</td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $registered_Total ?></p>
                                        </td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $screened_Total ?></p>
                                        </td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $cardiac_Total ?></p>
                                        </td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $diabetes_Total ?></p>
                                        </td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $sickle_cell_Total ?></p>
                                        </td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $other_Total ?></p>
                                        </td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $eligible_Total ?></p>
                                        </td>
                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $enrolled_Total ?></p>
                                        </td>

                                        <td class="">
                                            <p class="m-0 truncate-1"><?php echo $end_study_Total ?></p>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->
        <?php include 'footerBar.php'; ?>

        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="dist/js/demo.js"></script> -->
    <!-- Page specific script -->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
</body>

</html>