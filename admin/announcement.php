<?php

include('../assets/auth.php');

$title = "Announcement";
$announcement = true;

include('includes/header.php');
?>

<!-- DataTables -->
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<!-- summernote -->
<link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">

<?php
include('includes/topbar.php');
include('includes/sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $title ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">

                        <div class="card-header">
                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#cannouncement_modal" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus"></i> Create</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tabledata" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->

    </section>
    <!-- /.content -->

</div>

<div class="modal fade" id="cannouncement_modal">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal-title" class="modal-title">Add Announcement</h4>
                <button id="modal_hclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="content"></div>
                <form id="cannouncement_form">
                    <div class="card-body">
                        <div class="form-group row" style="display: none;">
                            <label class="col-sm-2 col-form-label" for="input_announceid">Announcement ID</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="input_announceid" placeholder="Announcement ID" readonly>
                                <span class="text-danger"><small id="announce-error" style="display: none;">*</small></span>
                            </div>
                        </div>

                        <div class="form-group row">

                            <!--<div class="form-group col-sm-6">
                                <div class="row">-->
                            <label class="col-sm-2 col-form-label" for="input_image">Image</label>
                            <div class="col-sm-10 d-flex flex-column">
                                <div class="d-flex justify-content-center">
                                    <img id="image_preview" style="padding: 10px; width: 100%" src="../image/announcement/no_announcement.png" alt="Announcement Image">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <label for="input_image"><a type="button" class="btn btn-outline-primary btn-block  btn-sm">Select Image</a></label>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input style="display:none" type="file" id="input_image" name="input_image" accept="image/png" onchange="showPreview(event);">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <span class="text-danger"><small id="image-error" style="display: none;">*</small></span>
                                </div>
                            </div>
                            <!--</div>
                            </div>-->

                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="input_title">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="input_title" placeholder="Announcement Title">
                                <span class="text-danger"><small id="title-error" style="display: none;">*</small></span>
                            </div>
                        </div>

                        <div class="form-group row" style="display: none;">
                            <label class="col-sm-2 col-form-label" for="input_description">Description</label>
                            <div class="col-sm-10">
                                <textarea id="input_description"></textarea>
                                <span class="text-danger"><small id="description-error" style="display: none;">*</small></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Column One -->
                            <div class="form-group col-sm-6" style="display: none;">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="input_type">Type</label>
                                        <div class="col-sm-8">
                                            <select id="input_type" class="form-control">
                                                <option selected>Choose...</option>
                                            </select>
                                            <span class="text-danger"><small id="type-error" style="display: none;">*</small></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column Two -->
                            <div class="form-group col-sm-6">

                                <div class="form">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label" for="input_status">Status</label>
                                        <div class="col-sm-8">
                                            <select id="input_status" class="form-control">
                                                <option selected>Choose...</option>
                                                <option value="true">Posted</option>
                                                <option value="false">Not Posted</option>
                                            </select>
                                            <span class="text-danger"><small id="status-error" style="display: none;">*</small></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button id="modal_fclose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn_save" type="submit" class="btn btn-primary">Add Announcement</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="dannouncement_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Announcement</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete this Announcement?</p>
                <div class="overlay" style="visibility: hidden;">
                    <i class="spinner-border"></i>
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button id='btn_delete' type="button" class="btn btn-danger">Yes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php
include('includes/footer.php');
?>

<!-- DataTables  & Plugins -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jszip/jszip.min.js"></script>
<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- SweetAlert2 -->
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Summernote -->
<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>

<script>
    $(function() {
        $("#input_title").keydown(function() {
            $("#input_title").removeClass("is-invalid");
            $('#title-error').hide();
            $('#title-error').html("");
            $("#btn_save").removeAttr("disabled");
        });
        $("#input_status").change(function() {
            $("#input_status").removeClass("is-invalid");
            $('#status-error').hide();
            $('#status-error').html("");
            $("#btn_save").removeAttr("disabled");
        });

        $('#btn_save').on('click', function() {
            $("#input_title").removeClass("is-invalid");
            $("#input_status").removeClass("is-invalid");
            $("#btn_save").attr("disabled", "disabled");

            $('#title-error').hide();
            $('#status-error').hide();

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            var input_announceid = $('#input_announceid').val();
            var myFile = document.getElementById('input_image');
            var input_image = myFile.files;
            var input_title = $('#input_title').val();
            var input_status = $('#input_status').val();
            var error = 0;

            if (input_title == "") {
                $("#input_title").addClass("is-invalid");
                $('#title-error').html("Enter Announcement Title");
                $('#title-error').show();
                error += 1;
            }
            if (input_status == "Choose...") {
                $("#input_status").addClass("is-invalid");
                $('#status-error').html("Choose Status");
                $('#status-error').show();
                error += 1;
            }

            if (error == 0) {
                var fd = new FormData();
                var files = $('#input_image')[0].files;
                fd.append('action', "create_announcement");
                fd.append('announce_id', input_announceid);
                fd.append('title', input_title);
                fd.append('status', input_status);
                fd.append('image', files[0]);
                $.ajax({
                    url: "scripts/ajax_creup.php",
                    type: "POST",
                    data: fd,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(dataResult) {
                        if (dataResult.response == "create_success") {
                            $('#tabledata').DataTable().ajax.reload(null, false);
                            $('#cannouncement_modal').modal('hide');
                            cannouncement_default();
                            Toast.fire({
                                icon: 'success',
                                title: "New Announcement Created"
                            });
                        } else if (dataResult.response == "edit_success") {
                            $('#tabledata').DataTable().ajax.reload(null, false);
                            $('#cannouncement_modal').modal('hide');
                            cannouncement_default();
                            Toast.fire({
                                icon: 'success',
                                title: "Success Editing Announcement"
                            });
                        } else if (dataResult.response == "denied") {
                            $("#btn_save").removeAttr("disabled");

                            if (dataResult.image !== undefined) {
                                $('#image-error').html(dataResult.image);
                                $('#image-error').show();
                            }
                            if (dataResult.title !== undefined) {
                                $("#input_title").addClass("is-invalid");
                                $('#title-error').html(dataResult.title);
                                $('#title-error').show();
                            }
                            if (dataResult.status !== undefined) {
                                $("#input_status").addClass("is-invalid");
                                $('#status-error').html(dataResult.status);
                                $('#status-error').show();
                            }
                            if (dataResult.error_desc !== undefined) {
                                alert(dataResult.error_desc);
                            }

                        } else if (dataResult.response == "duplicate") {
                            alert('Duplicate Announcement');
                            cannouncement_default();
                        } else {
                            alert('Encounter an Error');
                        }

                    }
                });
            }

        });



        $(document).on('click', '#edit_announcement', function(e) {
            e.preventDefault();
            var uid = $(this).data('id');
            $.ajax({
                url: 'scripts/ajax_read.php',
                type: 'POST',
                data: {
                    'action': 'announcement_details',
                    'id': uid
                },
                beforeSend: function() {
                    $("#content").show();
                    $("#content").html('Working on Please wait ..');
                    $('#cannouncement_form').hide();
                },
                success: function(dataResult) {
                    if (dataResult.response == "success") {
                        $("#content").hide();
                        $('#cannouncement_form').show();
                        $("#modal-title").html('Edit Product');
                        $("#btn_save").html('Save Changes');
                        $("#input_announceid").val(dataResult.id);
                        $("#input_title").val(dataResult.title);
                        $("#input_status").val(dataResult.status);

                        document.getElementById("image_preview").src = dataResult.image + "?id=" + Math.random();

                    } else {
                        $("#content").html(dataResult.error_desc);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $("#content").html('Sorry Error Occured');
                }
            })

        });

        $(document).on('click', '#delete_announcement', function(e) {
            var uid = $(this).data('id');
            $('#btn_delete').attr('data-id', uid);
        });

        $(document).on('click', '#btn_delete', function(e) {
            var uid = document.getElementById('btn_delete').getAttribute('data-id');

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $.ajax({
                url: 'scripts/ajax_delete.php',
                type: 'POST',
                data: {
                    'action': 'delete_announcement',
                    'id': uid
                },
                beforeSend: function() {
                    document.querySelectorAll('.overlay').forEach(function(el) {
                        el.style.visibility = 'visible';
                    });
                },
                success: function(dataResult) {
                    document.querySelectorAll('.overlay').forEach(function(el) {
                        el.style.visibility = 'hidden';
                    });
                    if (dataResult.response == "success") {
                        Toast.fire({
                            icon: 'success',
                            title: "Delete Announcement Successful"
                        });


                        $('#tabledata').DataTable().ajax.reload(null, false);
                        $('#dannouncement_modal').modal('hide');

                    } else {
                        alert(dataResult.error_desc)
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Sorry Error Occured')
                }
            })
        });

        var t = $('#tabledata').DataTable({
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "scripts/server_processing.php?action=announcement",
            "lengthMenu": [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            "rowId": 0,
            "columns": [{
                    "data": 0,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": 0,
                    "width": "20%"
                },
                {
                    "data": 1,
                    "width": "40%"
                },
                {
                    "data": 2
                },
                {
                    "data": 0
                }
            ],
            "columnDefs": [{
                    "data": "Entry",
                    "render": function(data) {
                        return '<img style="padding: 2px; width: 100%" src="../image/announcement/' + data + '.png?id=' + Math.random() + '" alt="Announcement Image">';
                    },
                    "className": "text-center",
                    "targets": 1
                },
                {
                    "data": "Entry",
                    "render": function(data) {
                        if (data === 'true') {
                            return '<span class="badge badge-success">Posted</span>';
                        } else {
                            return '<span class="badge badge-danger">Not Posted</span>';
                        };
                    },
                    "className": "text-center",
                    "targets": 3
                },
                {
                    "data": "Entry",
                    "render": function(data) {
                        return '<a type="button" class="btn btn-outline-primary btn-block  btn-sm" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cannouncement_modal" data-id="' +
                            data +
                            '" id="edit_announcement"><i class="fa fa-edit"></i> Edit</a><button type="button" class="btn btn-outline-danger btn-block  btn-sm"  data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#dannouncement_modal" data-id="' +
                            data +
                            '" id="delete_announcement"><i class="fa fa-trash"></i> Delete</button>';
                    },
                    "className": "text-center",
                    "targets": 4,
                    "orderable": false
                }
            ],
            "order": [
                [1, "asc"]
            ]
        });

    });

    $('#modal_hclose').on('click', function() {
        cannouncement_default();
    });
    $('#modal_fclose').on('click', function() {
        cannouncement_default();
    });

    $('#tabledata').on('click', 'tr', function() {
        var id = t.row(this).id();
        if (id != undefined) {
            //alert( 'Clicked row id '+id );
        }
    });


    function showPreview(event) {
        if (event.target.files.length > 0) {
            var src = URL.createObjectURL(event.target.files[0]);
            var preview = document.getElementById("image_preview");
            preview.src = src;
            preview.style.display = "block";
        }
    }

    $('#input_description').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol']],
            ['view', ['codeview']],
        ],
        height: 150
    });

    function cannouncement_default() {
        document.getElementById("image_preview").src = "../image/announcement/no_announcement.png";

        $("#cannouncement_form")[0].reset();
        $("#modal-title").html('Add Announcement');
        $("#btn_save").html('Add Announcement');
        $("#content").hide();
        $("#input_title").removeClass("is-invalid");
        $('#title-error').hide();
        $("#input_status").removeClass("is-invalid");
        $('#status-error').hide();
        $("#btn_save").removeAttr("disabled");
    }
</script>