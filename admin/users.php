<?php

include('../assets/auth.php');

$title = "Users";
$users = true;

include('includes/header.php');
?>

<!-- DataTables -->
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


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

            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabledata" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>Fullname</th>
                    <th>Lastname</th>
                    <th>Last Active</th>
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
</div>

<div class="modal fade" id="cresources_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal-title" class="modal-title">User Information</h4>
        <button id="modal_hclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="content"></div>
        <div class="card-body box-profile">

          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="../image/no_img.png" alt="User profile picture">
          </div>

          <h3 id="group-fullname" class="profile-username text-center"></h3>

          <p class="text-muted text-center" id="group-username"></p>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
              <b>Address</b> <a id="group-address" class="float-right"></a>
            </li>
            <li class="list-group-item">
              <b>Phone Number</b> <a id="group-phonenumber" class="float-right"></a>
            </li>
            <li class="list-group-item">
              <b>Email</b> <a id="group-email" class="float-right"></a>
            </li>
            <li class="list-group-item">
              <b>Interest</b> <a id="group-interest" class="float-right"></a>
            </li>

          </ul>


        </div>
        <div class="overlay">
          <i class="spinner-border"></i>
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <!--<button id="modal_fclose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
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


<script>
  $(function() {

    var t = $('#tabledata').DataTable({
      "autoWidth": false,
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": "scripts/server_processing_customized.php?action=users_list",
      "rowId": 0,
      "columns": [{
          "data": 0,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": 1,
          "width": "60%"
        },
        {
          "data": 2
        },
        {
          "data": 3
        },
        {
          "data": 0
        }
      ],
      "columnDefs": [{
          // The `data` parameter refers to the data for the cell (defined by the
          // `data` option, which defaults to the column being worked with, in
          // this case `data: 0`.
          "render": function(data, type, row) {
            //return '<a href="user_info.php?id=' + row[0] + '">' + data + ' ' + row[2] + '</a>';
            return data + ' ' + row[2];
          },
          "targets": 1
        },
        {
          "visible": false,
          "targets": [2]
        },
        {
          "data": "Entry",
          "render": function(data) {
            return '<button type="button" class="btn btn-outline-success btn-block  btn-sm" data-toggle="modal" data-target="#cresources_modal" id="user_info" data-id="' + data + '" data-backdrop="static" data-keyboard="false"><i class="fa fa-eye"></i> View</button>';
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

    $(document).on('click', '#user_info', function(e) {
      e.preventDefault();
      var uid = $(this).data('id');
      $.ajax({
        url: 'scripts/ajax_read.php',
        type: 'POST',
        data: {
          'action': 'users_details',
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
            //$("#content").hide();
            //$('#cannouncement_form').show();
            $("#group-username").html(dataResult.username);
            $("#group-fullname").html(dataResult.fullname);
            $("#group-address").html(dataResult.address);
            $("#group-phonenumber").html(dataResult.phone_number);
            $("#group-email").html(dataResult.email);

            $('#group-interest').empty();

            for (let i = 0; i < dataResult.interest.length; i++) {
              var num = Math.round(0xffffff * Math.random());
              var r = num >> 16;
              var g = num >> 8 & 255;
              var b = num & 255;
              //$("#group-interest").append('<small class="badge" style="background-color: rgb(' + r + ', ' + g + ', ' + b + '); color: #23adfa">' + dataResult.interest[i] + '<small>');
              $("#group-interest").append('<small class="badge badge-primary">' + dataResult.interest[i] + '</small>'+' ');

            }

            document.getElementById("image_preview").src = dataResult.image + "?id=" + Math.random();

          }
        },
      })

    });

  });
</script>