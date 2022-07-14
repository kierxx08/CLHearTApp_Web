<?php

//include('../assets/db_conn.php');
//include('scripts/get.php');
include('../assets/auth.php');

$title = "Dashboard";
$index = true;

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');

$SettingFile = file_get_contents('../app/assets/app_settings.json');
$SettingFileData = json_decode($SettingFile);


$DLFile = file_get_contents('../assets/download_logs.json');
$DLFileData = json_decode($DLFile);

?>

<style>
  .rating-color {
    color: #fbc634 !important;
  }

  .small-ratings i {
    color: #cecece;
  }
</style>
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
            <li class="breadcrumb-item active">Home</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo get_TotalResources($conn); ?></h3>

              <p>Resources</p>
            </div>
            <div class="icon">
              <i class="fas fa-map-marked-alt"></i>
            </div>
            <a href="cultural_resources.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?php echo get_TotalUSer($conn); ?></h3>

              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <a href="users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo $DLFileData->count_download; ?></h3>

              <p>App Total Download</p>
            </div>
            <div class="icon">
              <i class="fas fa-cloud-download-alt"></i>
            </div>
            <a href="setting.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $SettingFileData->latest_version; ?></h3>

              <p>App Latest Version</p>
            </div>
            <div class="icon">
              <i class="fab fa-android"></i>
            </div>
            <a href="setting.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Most Visited Place</h3>

              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#visited-chart" data-toggle="tab">Chart</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#visited-ranking" data-toggle="tab">Ranking</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="visited-chart" style="position: relative; height: 300px;">
                  <canvas id="visited-pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <div class="chart tab-pane" id="visited-ranking" style="position: relative; height: 300px;">
                  <table id="visited-chart-table" class="table table-striped">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th style="width: 20%">Total Visit</th>
                    </tr>
                  </table>
                </div>
              </div>

            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Top Rated</h3>

              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#rated-chart" data-toggle="tab">Chart</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#rated-ranking" data-toggle="tab">Ranking</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="rated-chart" style="position: relative; height: 300px;">
                  <canvas id="rated-pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <div class="chart tab-pane" id="rated-ranking" style="position: relative; height: 300px;">
                  <table id="rated-chart-table" class="table table-striped">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th style="width: 150px">Rating</th>
                    </tr>
                  </table>
                </div>
              </div>

            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Left col -->
        <div class="col-md-9">


          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">User Interest</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>


        </div>
        <!-- /.col -->

        <div class="col-md-3">

          <!-- PRODUCT LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Last Registered User</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">

                <?php
                $query = mysqli_query($conn, "SELECT * FROM `user_info` ORDER BY since DESC LIMIT 5");
                while ($fetch = mysqli_fetch_array($query)) {
                  $since = $fetch['since'];
                ?>

                  <li class="item">
                    <a href="#" class="product-title"><?php echo $fetch['fname'] . " " . $fetch['lname']; ?>
                      <?php
                      $since_date = new DateTime($since);
                      $since_ts = $since_date->getTimestamp();
                      $today_ts = time();
                      $dif = $today_ts - $since_ts;

                      if ($dif <= 86400) {
                        echo '<span class="badge badge-success float-right">New</span>';
                      }
                      ?>
                    </a>
                    <span class="product-description">
                      <i class="far fa-clock mr-1"></i> <?php echo time_elapsed_string($since); ?>
                    </span>
                  </li>

                <?php
                }
                ?>
                <!-- /.item -->

              </ul>
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </div><!-- /.container-fluid -->
  </section>

</div>
<?php
include('includes/footer.php');
?>

<!-- ChartJS -->
<script src="assets/plugins/chart.js/Chart.min.js"></script>

<script>
  $(function() {

    $.ajax({
      url: "scripts/ajax_read.php",
      type: "POST",
      data: {
        'action': 'interest_data'
      },
      cache: false,
      success: function(dataResult) {
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
          labels: dataResult.data.label,
          datasets: [{
            data: dataResult.data.value,
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#f9d1d1', '#f765a3', '#a155b9', '#355070', '#6d6875'],
          }]
        }
        var donutOptions = {
          maintainAspectRatio: false,
          responsive: true,
        }

        new Chart(donutChartCanvas, {
          type: 'doughnut',
          data: donutData,
          options: donutOptions
        })

      }
    });

    $.ajax({
      url: "scripts/ajax_read.php",
      type: "POST",
      data: {
        'action': 'most_visited_data'
      },
      cache: false,
      success: function(dataResult) {
        var pieChartCanvas = $('#visited-pieChart').get(0).getContext('2d')
        var pieData = {
          labels: dataResult.data.label,
          datasets: [{
            data: dataResult.data.value,
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#f9d1d1', '#f765a3', '#a155b9', '#355070', '#6d6875'],
          }]
        }
        var pieOptions = {
          maintainAspectRatio: false,
          responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas, {
          type: 'pie',
          data: pieData,
          options: pieOptions
        })

        for (let i = 0; i < dataResult.data.label.length; i++) {

          $('#visited-chart-table tr:last').after('<tr><td>' + (i + 1) + '.</td><td>' + dataResult.data.label[i] + '</td><td>' + dataResult.data.value[i] + '</td></tr>');

        }

      }
    });

    $.ajax({
      url: "scripts/ajax_read.php",
      type: "POST",
      data: {
        'action': 'top_rated_data'
      },
      cache: false,
      success: function(dataResult) {
        var pieChartCanvas = $('#rated-pieChart').get(0).getContext('2d')
        var pieData = {
          labels: dataResult.data.label,
          datasets: [{
            data: dataResult.data.value,
            backgroundColor: ['#d2d6de', '#f9d1d1', '#f765a3', '#a155b9', '#355070', '#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#6d6875'],
          }]
        }
        var pieOptions = {
          maintainAspectRatio: false,
          responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        new Chart(pieChartCanvas, {
          type: 'pie',
          data: pieData,
          options: pieOptions
        })

        for (let i = 0; i < dataResult.data.label.length; i++) {
          text = ' <div class="small-ratings">';

          //text += '['+rating+'] ';
          star = dataResult.data.value[i];
          rating = dataResult.data.user[i];
          for (let i = 1; i <= 5; i++) {
            if (1 <= star) {
              text += '<i class="fa fa-star rating-color"></i>';
              star -= 1;
            } else if (0 < star && star < 1) {
              text += '<i class="fa fa-star-half-alt rating-color"></i>';
              star -= star;
            } else {
              text += '<i class="fa fa-star"></i>';
            }
          }
          text += ' (' + rating + ')';
          text += '</div>';

          $('#rated-chart-table tr:last').after('<tr><td>' + (i + 1) + '.</td><td>' + dataResult.data.label[i] + '</td><td>' + text + '</td></tr>');

        }

      }
    });


  });
</script>