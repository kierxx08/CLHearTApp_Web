<?php
$title = "Add Cultural Resources";
$cultural_resources = true;

include('includes/header.php');
?>

<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
<link rel="stylesheet" href="css/image-uploader.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<!-- summernote -->
<link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">

<!-- bootstrap-tagsinput -->
<link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

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

  .alert-success {
    display: none;
  }
</style>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

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
            <li class="breadcrumb-item"><a href="cultural_resources.php">Cultural Resources</a></li>
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
      <!-- Alert Success 
      <div id="alert-success" class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Alert!</h5>
        Success alert preview. This alert is dismissable.
      </div>
      -->
      <div class="row">
        <div class="col-12">

          <div class="card card-primary">

            <!-- /.card-header -->
            <div class="card-header">
              <h3 class="card-title">Photos</h3>
            </div>
            <div class="card-body">
              <!-- <form method="POST" name="form-example-1" id="form-example-1" enctype="multipart/form-data">-->
              <form id="cculres_form">
                <div class="input-images-1" id="input-images-1-id" style="padding-top: .5rem;"></div>

                <!-- <button id="btn_submit" type="submit" class="btn btn-primary">Submit</button>

              </form>-->

                <span class="text-danger"><small id="image-error" style="display: none;">*</small></span>
            </div>
            <!-- /.card-body -->

            <div class="overlay">
              <i class="spinner-border"></i>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Information</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="input_name">Name</label>
                <input type="text" id="input_name" class="form-control">
                <span class="text-danger"><small id="name-error" style="display: none;">*</small></span>
              </div>
              <div class="form-group">
                <label for="input_description">Description</label>
                <textarea id="input_description"></textarea>
                <span class="text-danger"><small id="description-error" style="display: none;">*</small></span>
              </div>
              <div class="form-group">
                <label for="input_type">Type</label>
                <select id="input_type" class="form-control custom-select">
                  <option selected>Choose...</option>
                  <option value="cultural_place">Cultural Place</option>
                </select>
                <span class="text-danger"><small id="type-error" style="display: none;">*</small></span>
              </div>

              <div class="form-group">
                <label for="input_tag">Tag</label>
                <input data-role="tagsinput" type="text" id="input_tag" class="form-control">
                <span class="text-danger"><small id="tag-error" style="display: none;">*</small></span>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="overlay">
              <i class="spinner-border"></i>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Location</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <div id="map"></div>
              </div>

              <div class="form-row">
                <div class="form-group col-sm-6">
                  <label for="input_latitude">Latitude</label>
                  <input type="text" id="input_latitude" class="form-control" readonly>
                  <span class="text-danger"><small id="latitude-error" style="display: none;">*</small></span>
                </div>

                <div class="form-group col-sm-6">
                  <label for="input_longitude">Longitude</label>
                  <input type="text" id="input_longitude" class="form-control" readonly>
                  <span class="text-danger"><small id="longitude-error" style="display: none;">*</small></span>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="overlay">
              <i class="spinner-border"></i>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <a id="btn_cancel" class="btn btn-secondary">Cancel</a>
          <input id="btn_submit" type="submit" value="Create new Porject" class="btn btn-success float-right">
          </form>
        </div>
      </div>

      <br>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->


</div>

<?php
include('includes/footer.php');
?>

<script type="text/javascript" src="css/image-uploader.min.js"></script>

<script type="text/javascript" src="assets/plugins/google-map/map.js"></script>



<!-- SweetAlert2 -->
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Summernote -->
<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- bootstrap-tagsinput -->
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<script>
  $(function() {
    $('.input-images-1').imageUploader();
    $('#input_description').summernote();
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

    /*
    $("#input_latitude").focus(function() {
      $("#input_latitude").removeClass("is-invalid");
      $('#latitude-error').hide();
      $('#latitude-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_longitude").focus(function() {
      $("#input_longitude").removeClass("is-invalid");
      $('#longitude-error').hide();
      $('#longitude-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });
    */

    $('#btn_submit').on('click', function() {
      $("#input_name").removeClass("is-invalid");
      $("#input_description").removeClass("is-invalid");
      $("#input_type").removeClass("is-invalid");
      $("#input_tag").removeClass("is-invalid");
      $("#input_latitude").removeClass("is-invalid");
      $("#input_longitude").removeClass("is-invalid");
      $("#btn_submit").attr("disabled", "disabled");

      var totalfiles = document.getElementById('input_image').files.length;
      var input_name = $('#input_name').val();
      var input_description = $('#input_description').summernote('code');
      var input_type = $('#input_type').val();
      var input_tag = $('#input_tag').tagsinput('items');
      var input_latitude = $('#input_latitude').val();
      var input_longitude = $('#input_longitude').val();
      var error = 0;

      console.log("Total Images: " + totalfiles);
      console.log("Total Tags: " + input_tag);

      const upload = [];
      for (var index = 0; index < totalfiles; index++) {
        var fn = document.getElementById('input_image').files[index];
        upload.push(fn.name);
      }
      console.log("Upload Images: " + upload);

      const preload = [];
      var inps = document.getElementsByName('old_image[]');
      for (var i = 0; i < inps.length; i++) {
        var inp = inps[i];
        preload.push(inp.value);
      }
      console.log("Old Images: " + preload);


      //form_default();

      if (totalfiles == 0) {
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
        $('#type-error').html("Choose Status");
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


      if (error == 0) {

        document.querySelectorAll('.overlay').forEach(function(el) {
          el.style.visibility = 'visible';
        });
        var fd = new FormData();
        fd.append('action', "create_culres");
        for (var index = 0; index < totalfiles; index++) {
          fd.append("image[]", document.getElementById('input_image').files[index]);
        }
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
              Toast.fire({
                icon: 'success',
                title: "Added New Resources"
              });
              /*
              document.getElementById("alert-success").style.display = "block";
              setTimeout(function() {
                $('.alert-success').fadeOut('fast');
              }, 3000);
              setTimeout(function() {
                location.reload();
              }, 3000);
              */
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
            } else if (dataResult.response == "create_error") {

            }


          }
        });
      }
    });

  });

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

  $('#btn_cancel').on('click', function() {
    form_default();
  });

  function form_default() {
    //Scroll to top
    jQuery('html,body').animate({
      scrollTop: 0
    }, 500);

    $("#cculres_form")[0].reset();
    //$('.uploaded div').remove();
    document.getElementById("image-uploader-border").classList.remove("has-files");

    document.getElementById("image-uploader-border").style.borderColor = "#d9d9d9";
    //document.getElementById('input_image').value = null;
    //$('#input_image').val('');
    $('#input-images-1-id').empty();

    /*
    let preloaded = [{
        id: 1,
        src: 'http://192.168.254.2/tanauan/image/announcement/A-077844.png'
      },
      {
        id: 2,
        src: 'https://picsum.photos/500/500?random=2'
      },
      {
        id: 3,
        src: 'https://picsum.photos/500/500?random=3'
      },
      {
        id: 4,
        src: 'https://picsum.photos/500/500?random=4'
      },
      {
        id: 5,
        src: 'https://picsum.photos/500/500?random=5'
      },
      {
        id: 6,
        src: 'https://picsum.photos/500/500?random=6'
      },
    ];
    

    $('.input-images-1').imageUploader({
      preloaded: preloaded,
      imagesInputName: 'input_image',
      preloadedInputName: 'old_image',
      maxSize: 2 * 1024 * 1024,
      maxFiles: 10
    });

    */
   
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
    $("#input_description").removeClass("is-invalid");
    $('#description-error').hide();
    $("#input_type").removeClass("is-invalid");
    $('#type-error').hide();

    document.getElementById("bootstrap-tagsinput-border").style.borderColor = "#d9d9d9";
    $("#input_tag").tagsinput('removeAll');
    $("#input_tag").removeClass("is-invalid");
    $('#tag-error').hide();

    $("#input_latitude").removeClass("is-invalid");
    $('#latitude-error').hide();
    $("#input_longitude").removeClass("is-invalid");
    $('#longitude-error').hide();

    $("#btn_submit").removeAttr("disabled");
  }
</script>