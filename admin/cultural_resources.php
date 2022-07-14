<?php

include('../assets/auth.php');

$title = "Resources";
$cultural_resources = true;

include('includes/header.php');
?>

<!-- DataTables -->
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- bootstrap-tagsinput -->
<link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

<!-- Image-Uploader -->
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
<link rel="stylesheet" href="css/image-uploader.min.css">

<?php
include('includes/topbar.php');
include('includes/sidebar.php');
?>
<style>
  * {
    margin: 0;
    padding: 0;
    font-weight: normal;
  }

  #map {
    width: 100%;
    height: 300px;
  }

  form>button {
    -webkit-appearance: none;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    padding: 1rem 2rem;
    border: none;
    background-color: #50ce7d;
    color: #fff;
    text-transform: uppercase;
    display: block;
    margin: 2rem 0 2rem auto;
    font-size: 1em;
  }

  .input_image {
    background-color: transparent;
    border: none;
    border-radius: 0;
    outline: none;
    width: 100%;
    line-height: normal;
    font-size: 1em;
    padding: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
    margin: 0;
    color: rgba(0, 0, 0, 0.72);
    background-position: center bottom, center calc(100% - 1px);
    background-repeat: no-repeat;
    background-size: 0 2px, 100% 1px;
    -webkit-transition: background 0s ease-out 0s;
    -o-transition: background 0s ease-out 0s;
    transition: background 0s ease-out 0s;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#2196f3), to(#2196f3)), -webkit-gradient(linear, left top, left bottom, from(#d9d9d9), to(#d9d9d9));
    background-image: -webkit-linear-gradient(#2196f3, #2196f3), -webkit-linear-gradient(#d9d9d9, #d9d9d9);
    background-image: -o-linear-gradient(#2196f3, #2196f3), -o-linear-gradient(#d9d9d9, #d9d9d9);
    background-image: linear-gradient(#2196f3, #2196f3), linear-gradient(#d9d9d9, #d9d9d9);
    height: 2.4em;
  }

  .input-field label {
    width: 100%;
    color: #9e9e9e;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    font-size: 1em;
    cursor: text;
    -webkit-transition: -webkit-transform .2s ease-out;
    transition: -webkit-transform .2s ease-out;
    -webkit-transform-origin: 0 100%;
    transform-origin: 0 100%;
    text-align: initial;
    -webkit-transform: translateY(7px);
    transform: translateY(7px);
    pointer-events: none;
  }

  .input-field {
    position: relative;
    margin-top: 2.2rem;
  }

  .input-field label.active {
    -webkit-transform: translateY(-15px) scale(0.8);
    transform: translateY(-15px) scale(0.8);
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
  }

  .bootstrap-tagsinput {
    width: 100%;
  }

  .bootstrap-tagsinput .tag {
    margin-right: 2px;
    color: white;
  }

  .label-info {
    background-color: #5bc0de;
  }

  .label {
    display: inline;
    padding: 0.2em 0.6em 0.2em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25em;
  }

  .overlay {
    visibility: hidden;
  }

  .div_map {
    visibility: hidden;
    transition: visibility 1s, max-height 1s;
    max-height: 0;
    overflow: hidden;
  }

  .open {
    visibility: visible;
    /* Set max-height to something bigger than the box could ever be */
    max-height: 700px;
  }

  .rating-color {
    color: #fbc634 !important;
  }

  .small-ratings i {
    color: #cecece;
  }
</style>

<!-- Google Map -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcJa8_KXfKUPnh6GawMrlaMxpidQe8vrc&callback=initMap"></script>

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
              <div class="card-tools  float-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg" data-backdrop="static" data-keyboard="false"><i class="fas fa-qrcode"></i> Print QR</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cresources_modal" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus"></i> Add Resources</button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="tabledata" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Rating</th>
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


<div class="modal fade" id="cresources_modal">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal-title" class="modal-title">Add Resources</h4>
        <button id="modal_hclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="content"></div>
        <div class="card-body">
          <div class="form-group row" style="display: none">
            <label class="col-sm-2 col-form-label" for="input_productid">Resources ID</label>
            <div class="col-sm-10">
              <input type="text" name="name" class="form-control" id="input_id" placeholder="Resources ID" readonly>
              <span class="text-danger"><small id="id-error" style="display: none;">*</small></span>
            </div>
          </div>

          <div class="form-group row">

            <!--<div class="form-group col-sm-6">
                                <div class="row">-->
            <label class="col-sm-2 col-form-label" for="input_image">Image</label>
            <div class="col-sm-10 d-flex flex-column">
              <div class="input-images-1" id="input-images-1-id" style="padding-top: .5rem;"></div>

              <!-- <button id="btn_submit" type="submit" class="btn btn-primary">Submit</button>

</form>-->

              <span class="text-danger"><small id="image-error" style="display: none;">*</small></span>
            </div>
            <!--</div>
                            </div>-->

          </div>


          <form id="resources_form">

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="input_name">Name</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="input_name" placeholder="Product Name">
                <span class="text-danger"><small id="name-error" style="display: none;">*</small></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="input_description">Description</label>
              <div class="col-sm-10">
                <textarea id="input_description"></textarea>
                <span class="text-danger"><small id="description-error" style="display: none;">*</small></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="input_type">Type</label>
              <div class="col-sm-10">
                <select id="input_type" class="form-control custom-select">
                  <option selected>Choose...</option>
                  <option value="cultural_place">Cultural Place</option>
                  <option value="commercial_establishment">Commercial Establishment</option>
                  <option value="leisure_park">Leisure Park</option>
                  <option value="exhibit">Exhibit</option>
                </select>
                <span class="text-danger"><small id="type-error" style="display: none;">*</small></span>
              </div>
            </div>

            <div class="div_map" id="div_map">

              <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="input_tag">Map</label>
                <div class="col-sm-10">
                  <div id="map"></div>
                </div>
              </div>


              <div class="form-row">
                <!-- Column One -->
                <div class="form-group col-sm-6">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 col-form-label" for="input_latitude">Latitude</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_latitude" placeholder="Latitude" readonly>
                        <span class="text-danger"><small id="latitude-error" style="display: none;">*</small></span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Column Two -->
                <div class="form-group col-sm-6">
                  <div class="form-group">
                    <div class="row">
                      <label class="col-sm-4 col-form-label" for="input_longitude">Longitude</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="input_longitude" placeholder="Longitude" readonly>
                        <span class="text-danger"><small id="longitude-error" style="display: none;">*</small></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="input_tag">Tag</label>
              <div class="col-sm-10">
                <input data-role="tagsinput" type="text" id="input_tag" class="form-control">
                <span class="text-danger"><small id="tag-error" style="display: none;">*</small></span>
              </div>
            </div>

        </div>
        <div class="overlay">
          <i class="spinner-border"></i>
        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button id="modal_fclose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btn_submit" type="button" class="btn btn-primary">Sumbit</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<div class="modal fade" id="modal-lg">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Print QR</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="content_print">
          <?php include 'resources_qrcode.php' ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id='print'>Print</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php
include('includes/footer.php');
?>


<!-- Map -->
<script src="assets/plugins/google-map/map.js"></script>


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

<!-- Image-Uploader -->
<script type="text/javascript" src="css/image-uploader.min.js"></script>

<!-- bootstrap-tagsinput -->
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<noscript>
  <style>
    img {
      display: block;
      margin-left: auto;
      margin-right: auto;
      height: 200px;
      width: 149px;
    }
  </style>
</noscript>
<script>
  $(function() {
    $('.input-images-1').imageUploader();
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

    //Initialize Google Map
    initMap();

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    $("#input_image").change(function() {
      document.getElementById("image-uploader-border").style.borderColor = "#d9d9d9";
      $("#input_image").removeClass("is-invalid");
      $('#image-error').hide();
      $('#image-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_image").change(function() {
      document.getElementById("image-uploader-border").style.borderColor = "#d9d9d9";
      $("#input_image").removeClass("is-invalid");
      $('#image-error').hide();
      $('#image-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_name").keydown(function() {
      $("#input_name").removeClass("is-invalid");
      $('#name-error').hide();
      $('#name-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_description").on("summernote.keydown", function(e) {
      $("#input_description").removeClass("is-invalid");
      $('#description-error').hide();
      $('#description-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_type").change(function() {
      $("#input_type").removeClass("is-invalid");
      $('#type-error').hide();
      $('#type-error').html("");
      $("#btn_submit").removeAttr("disabled");

      const div = document.getElementById("div_map")
      /*
      if (($('#input_type').val() != "cultural_place") || div.classList.contains('open')) {
        div.classList.remove('open')
        $("#input_latitude").val("");
        $("#input_longitude").val("");
      } else {
        div.classList.add('open')
      }
      */
      if (($('#input_type').val() == "cultural_place") || ($('#input_type').val() == "commercial_establishment") || ($('#input_type').val() == "leisure_park")) {
        if (!div.classList.contains('open')) {
          div.classList.add('open')
        }
      } else {
        div.classList.remove('open');
        $("#input_latitude").val("");
        $("#input_longitude").val("");
      }
    });

    $("#tagsinput-typing").keydown(function() {
      document.getElementById("bootstrap-tagsinput-border").style.borderColor = "#d9d9d9";
      //console.log($("#input_tag").tagsinput('items'));
      $("#input_tag").removeClass("is-invalid");
      $('#tag-error').hide();
      $('#tag-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#map").click(function() {
      $("#input_latitude").removeClass("is-invalid");
      $('#latitude-error').hide();
      $('#latitude-error').html("");
      $("#input_longitude").removeClass("is-invalid");
      $('#longitude-error').hide();
      $('#longitude-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });


    $('#btn_submit').on('click', function() {
      $("#input_name").removeClass("is-invalid");
      $("#input_description").removeClass("is-invalid");
      $("#input_type").removeClass("is-invalid");
      $("#input_tag").removeClass("is-invalid");
      $("#input_latitude").removeClass("is-invalid");
      $("#input_longitude").removeClass("is-invalid");
      $("#btn_submit").attr("disabled", "disabled");

      var input_id = $('#input_id').val();
      var TotalNewFiles = document.getElementById('input_image').files.length;
      var TotalOldFiles = 0;
      var TotalFiles = 0;
      var input_name = $('#input_name').val();
      var input_description = $('#input_description').summernote('code');
      var input_type = $('#input_type').val();
      var input_tag = $('#input_tag').tagsinput('items');
      var input_latitude = $('#input_latitude').val();
      var input_longitude = $('#input_longitude').val();
      var error = 0;

      console.log("Total Images: " + TotalNewFiles);
      console.log("Total Tags: " + input_tag);

      const upload = [];
      for (var index = 0; index < TotalNewFiles; index++) {
        var fn = document.getElementById('input_image').files[index];
        upload.push(fn.name);
        TotalFiles += 1;
      }
      console.log("Upload Images: " + upload);

      const preload = [];
      var inps = document.getElementsByName('old_image[]');
      for (var i = 0; i < inps.length; i++) {
        var inp = inps[i];
        preload.push(inp.value);
        TotalOldFiles += 1;
        TotalFiles += 1;
      }
      console.log("Old Images: " + preload);


      if (TotalFiles == 0) {
        document.getElementById("image-uploader-border").style.borderColor = "#dc3545";
        $("#input_image").addClass("is-invalid");
        $('#image-error').html("Add image");
        $('#image-error').show();
        error += 1;
      }

      if (input_name == "") {
        $("#input_name").addClass("is-invalid");
        $('#name-error').html("Enter a Name");
        $('#name-error').show();
        error += 1;
      }
      if (input_type == "Choose...") {
        $("#input_type").addClass("is-invalid");
        $('#type-error').html("Choose Type");
        $('#type-error').show();
        error += 1;
      }
      if (input_tag == "") {
        document.getElementById("bootstrap-tagsinput-border").style.borderColor = "#dc3545";
        $("#input_tag").addClass("is-invalid");
        $('#tag-error').html("Enter a Tag");
        $('#tag-error').show();
        error += 1;
      }
      if (input_type == "cultural_place" || input_type == "commercial_establishment" || input_type == "leisure_park") {
        if (input_latitude == "") {
          $("#input_latitude").addClass("is-invalid");
          $('#latitude-error').html("Missing Latitude");
          $('#latitude-error').show();
          error += 1;
        }
        if (input_longitude == "") {
          $("#input_longitude").addClass("is-invalid");
          $('#longitude-error').html("Missing Longitude");
          $('#longitude-error').show();
          error += 1;
        }
      }

      if (error == 0) {
        document.querySelectorAll('.overlay').forEach(function(el) {
          el.style.visibility = 'visible';
        });
        var fd = new FormData();
        fd.append('action', "create_culres");
        for (var index = 0; index < TotalNewFiles; index++) {
          fd.append("image[]", document.getElementById('input_image').files[index]);
        }
        for (var index = 0; index < TotalOldFiles; index++) {
          fd.append("oldimage[]", document.getElementsByName('old_image[]')[index].value);
        }
        fd.append('newimagecount', TotalNewFiles);
        fd.append('oldimagecount', TotalOldFiles);
        fd.append('id', input_id);
        fd.append('name', input_name);
        fd.append('description', input_description);
        fd.append('type', input_type);
        fd.append('tag', JSON.stringify(input_tag));
        fd.append('latitude', input_latitude);
        fd.append('longitude', input_longitude);
        $.ajax({
          url: "scripts/ajax_creup.php",
          type: "POST",
          data: fd,
          contentType: false,
          processData: false,
          cache: false,
          success: function(dataResult) {
            document.querySelectorAll('.overlay').forEach(function(el) {
              el.style.visibility = 'hidden';
            });
            if (dataResult.response == "create_success") {
              $('#tabledata').DataTable().ajax.reload(null, false);
              $('#cresources_modal').modal('hide');
              Toast.fire({
                icon: 'success',
                title: "Added New Resources"
              });
              form_default();

            } else if (dataResult.response == "update_success") {
              $('#tabledata').DataTable().ajax.reload(null, false);
              $('#cresources_modal').modal('hide');
              Toast.fire({
                icon: 'success',
                title: "Resources Edit Success"
              });
              form_default();

            } else if (dataResult.response == "found_error") {
              Toast.fire({
                icon: 'error',
                title: "Error Found"
              });
              $("#butsave").removeAttr("disabled");

              if (dataResult.image !== undefined) {
                $('#image-error').html(dataResult.image);
                $('#image-error').show();
              }
              if (dataResult.name !== undefined) {
                $('#name-error').html(dataResult.name);
                $('#name-error').show();
              }
              if (dataResult.type !== undefined) {
                $('#type-error').html(dataResult.type);
                $('#type-error').show();
              }
              if (dataResult.tag !== undefined) {
                $('#tag-error').html(dataResult.tag);
                $('#tag-error').show();
              }
              if (dataResult.latitude !== undefined) {
                $('#latitude-error').html(dataResult.latitude);
                $('#latitude-error').show();
              }
              if (dataResult.longitude !== undefined) {
                $('#longitude-error').html(dataResult.longitude);
                $('#longitude-error').show();
              }

              $("#input_image").click(function() {
                $("#input_image").removeClass("is-invalid");
                $('#image-error').hide();
                $('#image-error').html("");
                $("#btn_submit").removeAttr("disabled");
              });
            } else if (dataResult.response == "create_error") {

            }


          }
        });
      }

    });


    $('#print').click(function() {
      var _c = $('#content_print').clone();
      var ns = $('noscript').clone();
      ns.append(_c)
      var nw = window.open('', '_blank', 'width=900,height=600')
      nw.document.write(ns.html())
      nw.document.close()
      nw.print()
      setTimeout(() => {
        nw.close()
      }, 500);
    });

    $(document).on('click', '#edit_resources', function(e) {
      e.preventDefault();
      var uid = $(this).data('id');
      $.ajax({
        url: 'scripts/ajax_read.php',
        type: 'POST',
        data: {
          'action': 'resources_details',
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

            $("#modal-title").html('Edit Resources');
            $("#btn_submit").html('Save Changes');

            $("#input_id").val(uid);
            $("#input_name").val(dataResult.name);
            $("#input_description").summernote("code", dataResult.desc);
            $("#input_type").val(dataResult.type);
            if (dataResult.type == "cultural_place" || dataResult.type == "commercial_establishment" || dataResult.type == "leisure_park") {
              const div = document.getElementById("div_map");
              div.classList.add('open');
              $("#input_latitude").val(dataResult.lat);
              $("#input_longitude").val(dataResult.long);
              setMap(dataResult.lat, dataResult.long);
            }

            $('#input-images-1-id').empty();
            let preloaded = dataResult.image;
            $('.input-images-1').imageUploader({
              preloaded: preloaded,
              imagesInputName: 'input_image',
              preloadedInputName: 'old_image'
            });
            for (let i = 0; i < dataResult.tag.length; i++) {
              $('#input_tag').tagsinput('add', dataResult.tag[i]);
            }


          }
        },
      })

    });

    var t = $('#tabledata').DataTable({
      "autoWidth": false,
      "responsive": true,
      "processing": true,
      "serverSide": true,
      "ajax": "scripts/server_processing.php?action=resources",
      "rowId": 0,
      "columns": [{
          "data": 0,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {
          "data": 1,
          "width": "40%"
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
          "data": "Entry",
          "render": function(data) {
            if (data === 'cultural_place') {
              return 'Cultural Place';
            } else if (data === 'commercial_establishment') {
              return 'Commercial Establishment';
            } else if (data === 'leisure_park') {
              return 'Leisure Park';
            } else if (data === 'exhibit') {
              return 'Exhibit';
            } else {
              return 'Other';
            };
          },
          "className": "text-center",
          "targets": 2
        },
        {
          "data": "Entry",
          "render": function(data) {
            rating = parseFloat(data).toFixed(1);
            text = ' <div class="small-ratings">';

            //text += '['+rating+'] ';
            for (let i = 1; i <= 5; i++) {
              if (1 <= data) {
                text += '<i class="fa fa-star rating-color"></i>';
                data -= 1;
              } else if (0 < data && data < 1) {
                text += '<i class="fa fa-star-half-alt rating-color"></i>';
                data -= data;
              } else {
                text += '<i class="fa fa-star"></i>';
              }
            }
            text += ' (' + rating + ')';
            text += '</div>';

            return text;
          },
          "className": "text-center",
          "targets": 3,
          "orderable": false
        },
        {
          "data": "Entry",
          "render": function(data) {
            return '<button type="button" class="btn btn-outline-primary btn-block  btn-sm" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cresources_modal" data-id="' +
              data +
              '" id="edit_resources"><i class="fa fa-edit"></i> Edit</button>';
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


    $('#example1').on('click', 'tr', function() {
      var id = t.row(this).id();
      if (id != undefined) {
        //alert( 'Clicked row id '+id );
      }
    });


  });

  $('#modal_hclose').on('click', function() {
    form_default();
  });
  $('#modal_fclose').on('click', function() {
    form_default();
  });

  function form_default() {

    $("#resources_form")[0].reset();


    $("#modal-title").html('Add Resources');
    $("#btn_submit").html('Sumbit');

    $("#input_id").val("");

    //$('.uploaded div').remove();
    document.getElementById("image-uploader-border").classList.remove("has-files");

    document.getElementById("image-uploader-border").style.borderColor = "#d9d9d9";
    //document.getElementById('input_image').value = null;
    //$('#input_image').val('');
    $('#input-images-1-id').empty();


    $('.input-images-1').imageUploader();

    $("#input_image").change(function() {
      document.getElementById("image-uploader-border").style.borderColor = "#d9d9d9";
      $("#input_image").removeClass("is-invalid");
      $('#image-error').hide();
      $('#image-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_image").removeClass("is-invalid");
    $('#image-error').hide();
    $("#input_name").removeClass("is-invalid");
    $('#name-error').hide();

    $("#input_description").summernote("code", "");
    $("#input_description").removeClass("is-invalid");
    $('#description-error').hide();
    $("#input_type").removeClass("is-invalid");
    $('#type-error').hide();

    document.getElementById("bootstrap-tagsinput-border").style.borderColor = "#d9d9d9";
    $("#input_tag").tagsinput('removeAll');
    $("#input_tag").removeClass("is-invalid");
    $('#tag-error').hide();

    if (marker !== false) {
      $('#map').empty();
      marker = false;
    }
    initMap();

    const div = document.getElementById("div_map")
    if (div.classList.contains('open')) {
      div.classList.remove('open')
    }

    $("#input_latitude").removeClass("is-invalid");
    $('#latitude-error').hide();
    $("#input_longitude").removeClass("is-invalid");
    $('#longitude-error').hide();

    $("#btn_submit").removeAttr("disabled");
  }
</script>

<!--
<script>
  $(document).ready(function() {

    $('.input-images-1').imageUploader();
    $('#input_description').summernote();
    initMap();

  });
</script>
 -->