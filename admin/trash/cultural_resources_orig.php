<?php

$title = "Cultural Resources";
$cultural_resources = true;

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
              <div class="card-header">
                <a href="cultural_resources_add.php"><button type="button" class="btn btn-primary float-right"><i
                                    class="fas fa-plus"></i> Add Cultural Resources</button></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabledata" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Date</th>
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
  

  $(function () {
    var t = $('#tabledata').DataTable({
      "autoWidth": false,
      "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "scripts/server_processing.php?action=resources",
        "rowId":0,
        "columns": [
            {
              "data": 0,
              render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
              }
            },
            { 
              "data": 1,
              "width": "40%" 
            },
            { "data": 2 },
            { "data": 3 },
            { "data": 0 }
        ],
        "columnDefs": [
            {
                "data": "Entry",
                "render": function(data) {
                    if(data==='cultural_place'){
                        return 'Cultural Place';
                    }else{
                        return 'Other';
                    };
                },
                "className": "text-center",
                "targets": 2
            },
            {
                "data": "Entry",
                "render": function(data) {
                    return '<button type="button" class="btn btn-outline-primary btn-block  btn-sm"><i class="fa fa-edit"></i> Edit</button>';
                },
                "className": "text-center",
                "targets": 4,
                "orderable": false
            }
        ],
        "order": [[ 1, "asc" ]]
    });

  
 
$('#example1').on( 'click', 'tr', function () {
    var id = t.row( this ).id();
    if (id != undefined){
      //alert( 'Clicked row id '+id );
    }
});
});
</script>