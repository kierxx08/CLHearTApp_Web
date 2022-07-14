<?php

include('../assets/auth.php');
$title = "Setting";
$setting = true;

include('includes/header.php');
?>
<!-- SweetAlert2 -->
<link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<style>
  .version-list {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
</style>
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

    <div class="row">
      <div class="col-md-6">

        <div class="card card-primary">

          <!-- /.card-header -->
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Android App</h3>
              <a href="" data-toggle="modal" data-target="#create_modal" data-backdrop="static" data-keyboard="false">Manage App</a>
            </div>
          </div>
          <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
              <li class="item">
                <div class="product-img" style="height: 110px; width: 110px">
                  <img src="../image/clheartapp_icon_small.png" alt="Product Image" style="height: 100px; width: 100px">
                </div>
                <div class="product-info">
                  <a class="product-title">CLHear TApp</a>
                  <span id="latest_version" class="product-description">
                    Latest Version:
                  </span>
                  <span class="product-description">
                    What's New?
                  </span>
                  <span class="product-description">
                    <ul id="list_newup">

                    </ul>
                  </span>
                </div>
              </li>
              <!-- /.item -->
            </ul>
          </div>
          <!-- /.card-body -->
        </div>


      </div>
      <!-- /.col (left) -->


      <div class="col-md-6">

        <div class="card card-primary">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">App Server</h3>
              <!--<a href="" data-toggle="modal" data-target="#server_modal" data-backdrop="static" data-keyboard="false">Manage Server</a>-->
            </div>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Server Status</b> <a id="group-address" class="float-right"><input id="maintenance_switch" type="checkbox" name="my-checkbox" data-bootstrap-switch></a>
              </li>

            </ul>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col (right) -->
    </div>



  </section>

</div>

<div class="modal fade" id="create_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal-title" class="modal-title">Manage App</h4>
        <button id="modal_hclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="content"></div>
        <div class="card-body">

          <form id="create_form">


            <div class="form-group row">
              <div class="col-sm-12 d-flex flex-column">
                <div id='progress' class="progress" style="visibility: hidden;">
                  <div id="progress_bar" class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    <span class="sr-only">40% Complete (success)</span>
                  </div>
                </div>
              </div>

            </div>
            <div class="form-group row">

              <label class="col-sm-2 col-form-label" for="input_apk">App File</label>
              <div class="col-sm-10 d-flex flex-column">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="input_apk" accept=".apk">
                  <label class="custom-file-label" for="input_apk">Choose file</label>
                </div>

                <span class="text-danger"><small id="apk-error" style="display: none;">*</small></span>
              </div>

            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="input_version">Version</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="input_version" placeholder="App Version">
                <span class="text-danger"><small id="version-error" style="display: none;">*</small></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="userinput">What's New?</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <input id="userinput" type="text" class="form-control" placeholder="Add update item..." aria-label="Add an item" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-outline-primary" id="enter" type="button"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
                <input style="display: none;" type="text" name="name" class="form-control" id="input_newup" placeholder="App Version" value="[]">
                <span class="text-danger"><small id="userinput-error" style="display: none;">*</small></span>
                <div id="version-list"></div>


              </div>
            </div>

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

<div class="modal fade" id="server_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modal-title" class="modal-title">Maintenance Information</h4>
        <button id="modal2_hclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="content"></div>
        <div class="card-body">

          <form id="server_form">


            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="input_maintenance">Details</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="input_maintenance" placeholder="Maintenance Details">
                <span class="text-danger"><small id="maintenance-error" style="display: none;">*</small></span>
              </div>
            </div>

        </div>

      </div>
      <div class="modal-footer justify-content-between">
        <button id="modal2_fclose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id="btn2_submit" type="button" class="btn btn-primary">Sumbit</button>
        </form>
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

<!-- Bootstrap Switch -->
<script src="assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

<!-- bs-custom-file-input -->
<script src="assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- SweetAlert2 -->
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
  $(function() {
    get_app_info();
    get_server_info();
    /*
    $("input[data-bootstrap-switch]").each(function() {
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
    */

    $("#input_apk").change(function() {
      $("#input_apk").removeClass("is-invalid");
      $('#apk-error').hide();
      $('#apk-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_version").keydown(function() {
      $("#input_version").removeClass("is-invalid");
      $('#version-error').hide();
      $('#version-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#userinput").keydown(function() {
      $("#userinput").removeClass("is-invalid");
      $('#userinput-error').hide();
      $('#userinput-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    $("#input_maintenance").keydown(function() {
      $("#input_maintenance").removeClass("is-invalid");
      $('#maintenance-error').hide();
      $('#maintenance-error').html("");
      $("#btn_submit").removeAttr("disabled");
    });

    var button = document.getElementById("enter");
    var input = document.getElementById("userinput");
    var vl = document.querySelector("#version-list");

    var input_newup = document.getElementById("input_newup");
    var property = [];

    button.addEventListener("click", function() {
      if (input.value == "") {
        $("#userinput").addClass("is-invalid");
      } else {
        $("#userinput").removeClass("is-invalid");
        $("#userinput-error").hide();
        $("#btn_submit").removeAttr("disabled");

        var rand = Math.random();
        var property = JSON.parse(input_newup.value);
        //var li = document.createElement("li");
        // Add Bootstrap class to the list element
        //li.classList.add("list-group-item");
        //li.appendChild(document.createTextNode(input.value));
        //ul.appendChild(li);
        var una_div = document.createElement("div");
        una_div.classList.add("input-group");
        una_div.setAttribute("id", rand);

        var dalwa_div = document.createElement("div");
        dalwa_div.classList.add("form-control");
        dalwa_div.classList.add("version-list");
        dalwa_div.setAttribute("id", "value_" + rand);
        dalwa_div.innerHTML = input.value;
        una_div.append(dalwa_div);

        var tatlo_div = document.createElement("div");
        tatlo_div.classList.add("input-group-append");
        una_div.append(tatlo_div);

        var una_btn = document.createElement("button");
        una_btn.classList.add("btn");
        una_btn.classList.add("btn-outline-danger");
        una_btn.setAttribute("type", "button");
        tatlo_div.append(una_btn);

        var una_i = document.createElement("i");
        una_i.classList.add("fa");
        una_i.classList.add("fa-trash");
        una_i.setAttribute("onclick", "remove(" + rand + ")");
        una_btn.append(una_i);

        vl.append(una_div);

        property.push(input.value);
        input_newup.value = JSON.stringify(property);
        //input_newup.value = property;

        // Clear your input 
        input.value = "";
      }
    });


    $('#btn_submit').on('click', function() {
      $("#input_apk").removeClass("is-invalid");
      $("#input_version").removeClass("is-invalid");
      $("#userinput").removeClass("is-invalid");
      $("#btn_submit").attr("disabled", "disabled");

      $('#apk-error').hide();
      $('#version-error').hide();
      $('#userinput-error').hide();

      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      var myFile = document.getElementById('input_apk');
      var input_apk = myFile.files;
      var input_version = $('#input_version').val();
      var input_newup = $('#input_newup').val();
      var error = 0;

      if (input_apk.length == 0) {
        $("#input_apk").addClass("is-invalid");
        $('#apk-error').html("Select APK File");
        $('#apk-error').show();
        error += 1;
      }

      if (input_version == "") {
        $("#input_version").addClass("is-invalid");
        $('#version-error').html("Enter APK Version");
        $('#version-error').show();
        error += 1;
      }
      if (Object.keys(JSON.parse(input_newup)).length == 0) {
        $("#userinput").addClass("is-invalid");
        $('#userinput-error').html("Enter App Changes");
        $('#userinput-error').show();
        error += 1;
      }

      if (error == 0) {

        var fd = new FormData();
        var files = $('#input_apk')[0].files;
        fd.append('action', "update_app");
        fd.append('version', input_version);
        fd.append('json_newup', input_newup);
        fd.append('apk_file', files[0]);
        $.ajax({
          xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                document.getElementById("progress").style.visibility = "visible";
                var percentComplete = (evt.loaded / evt.total) * 100;
                document.getElementById('progress_bar').setAttribute("style", "width: " + percentComplete + "%");
              }
            }, false);
            return xhr;
          },
          url: "scripts/ajax_creup.php",
          type: "POST",
          data: fd,
          contentType: false,
          processData: false,
          cache: false,

          success: function(dataResult) {
            document.getElementById("progress").style.visibility = "hidden";
            document.getElementById('progress_bar').setAttribute("style", "width: 0%");
            if (dataResult.response == "update_success") {
              $('#create_modal').modal('hide');
              form_default();
              Toast.fire({
                icon: 'success',
                title: "New Update Created"
              });

              get_app_info();

            } else if (dataResult.response == "denied") {
              $("#btn_submit").removeAttr("disabled");

              if (dataResult.apk_file !== undefined) {
                $("#input_apk").addClass("is-invalid");
                $('#apk-error').html(dataResult.apk_file);
                $('#apk-error').show();
              }
              if (dataResult.version !== undefined) {
                $("#input_version").addClass("is-invalid");
                $('#version-error').html(dataResult.version);
                $('#version-error').show();
              }
              if (dataResult.newup !== undefined) {
                $("#userinput").addClass("is-invalid");
                $('#userinput-error').html(dataResult.newup);
                $('#userinput-error').show();
              }
              if (dataResult.error_desc !== undefined) {
                alert(dataResult.error_desc);
              }

            } else {
              alert('Encounter an Error');
            }

          }
        });
      }

    });


    $('#btn2_submit').on('click', function() {
      $("#input_maintenance").removeClass("is-invalid");
      $("#btn2_submit").attr("disabled", "disabled");

      $('#maintenance-error').hide();

      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      var input_maintenance = $('#input_maintenance').val();
      var error = 0;

      if (input_maintenance == "") {
        $("#input_maintenance").addClass("is-invalid");
        $('#maintenance-error').html("Enter Maintenance Details");
        $('#maintenance-error').show();
        error += 1;
      }

      if (error == 0) {
        var fd = new FormData();
        fd.append('action', "set_maintenance");
        fd.append('maintenance', input_maintenance);
        $.ajax({
          url: "scripts/ajax_creup.php",
          type: "POST",
          data: fd,
          contentType: false,
          processData: false,
          cache: false,
          success: function(dataResult) {
            if (dataResult.response == "update_success") {
              $('#server_modal').modal('hide');
              form_default();
              Toast.fire({
                icon: 'success',
                title: "App set to Under Maintenance"
              });
              form_server();
            } else if (dataResult.response == "denied") {
              $("#btn2_submit").removeAttr("disabled");

              if (dataResult.maintenance !== undefined) {
                $("#input_maintenance").addClass("is-invalid");
                $('#maintenance-error').html(dataResult.maintenance);
                $('#maintenance-error').show();
              }
              if (dataResult.error_desc !== undefined) {
                alert(dataResult.error_desc);
              }

            } else {
              alert('Encounter an Error');
            }

          }
        });
      }

    });

    $(function() {
      bsCustomFileInput.init();
    });

    $("#maintenance_switch").bootstrapSwitch({
      onSwitchChange: function(e, state) {
        if (state) {

          var fd = new FormData();
          fd.append('action', "set_maintenance");
          fd.append('RunServer', true);
          $.ajax({
            url: "scripts/ajax_creup.php",
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            cache: false,
            success: function(dataResult) {
              if (dataResult.response == "update_success") {
                Toast.fire({
                  icon: 'success',
                  title: "Running App Success"
                });
                form_server();
              } else if (dataResult.response == "denied") {

                alert("Error Occured");

              } else {
                alert('Encounter an Error');
              }

            }
          });
        } else {
          $('#server_modal').modal({
            backdrop: 'static',
            keyboard: false
          })
        }
      }
    });

  });

  function remove(id) {
    $("#btn_submit").removeAttr("disabled");
    var element = document.getElementById(id);
    var input_newup = document.getElementById("input_newup");
    var array = JSON.parse(input_newup.value);
    var item = document.getElementById("value_" + id).innerHTML;

    var index = array.indexOf(item);
    if (index !== -1) {
      array.splice(index, 1);
    }
    //console.log("JSON: " + json);
    console.log("JSON: " + array);

    input_newup.value = JSON.stringify(array);

    element.parentNode.removeChild(element);
  }


  $('#modal2_hclose').on('click', function() {
    $("#maintenance_switch").bootstrapSwitch('state', true);
    form_server();
  });
  $('#modal2_fclose').on('click', function() {
    $("#maintenance_switch").bootstrapSwitch('state', true);
    form_server();
  });


  $('#modal_hclose').on('click', function() {
    form_default();
  });
  $('#modal_fclose').on('click', function() {
    form_default();
  });

  function get_app_info() {

    $.ajax({
      url: 'scripts/ajax_read.php',
      type: 'POST',
      data: {
        'action': 'app_details'
      },
      success: function(dataResult) {
        if (dataResult.response == "success") {
          $("#latest_version").html('Latest Version: ' + dataResult.latest_version);
          $('#list_newup').empty();

          for (let i = 0; i < dataResult.newup.length; i++) {
            var una_li = document.createElement("li");
            una_li.innerHTML = dataResult.newup[i];
            document.getElementById("list_newup").append(una_li);
          }

        } else {
          alert(dataResult.error_desc);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert('Sorry Error Occured');
      }
    })
  }

  function get_server_info() {

    $.ajax({
      url: 'scripts/ajax_read.php',
      type: 'POST',
      data: {
        'action': 'server_info'
      },
      success: function(dataResult) {
        if (dataResult.response == "success") {
          if (!dataResult.state) {
            $("#maintenance_switch").bootstrapSwitch('state', true);
          } else {
            $("#maintenance_switch").bootstrapSwitch('state', false);
          }

        } else {
          alert(dataResult.error_desc);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        alert('Sorry Error Occured');
      }
    })
  }

  function form_default() {
    $("#create_form")[0].reset();
    $("#input_apk").removeClass("is-invalid");
    $("#apk-error").hide();
    $("#input_version").removeClass("is-invalid");
    $("#version-error").hide();
    $("#userinput").removeClass("is-invalid");
    $("#userinput-error").hide();
    $('#version-list').empty();
    $("#btn_submit").removeAttr("disabled");

  }

  function form_server() {
    $("#server_form")[0].reset();
    $("#input_maintenance").removeClass("is-invalid");
    $("#maintenance-error").hide();
    $("#btn2_submit").removeAttr("disabled");

  }
</script>