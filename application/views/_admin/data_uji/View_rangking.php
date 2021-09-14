<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $page_name ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- alert  -->
  <?php
  if ($this->session->flashdata('info')) {
    if ($this->session->flashdata('info')['from']) {
      echo "
            <div class=' alert alert-success alert-dismissible'>
            <h4><i class='icon fa fa-globe'></i> Information!</h4>" .
        $this->session->flashdata('info')["message"] .
        "</div>
            ";
    } else {
      echo "
            <div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h4><i class='icon fa fa-ban'></i> Alert!</h4>" .
        $this->session->flashdata('info')["message"] .
        "</div>
            ";
    }
  }
  ?>
  <!-- alert  -->
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $page_name ?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table id="tableDocument" class="table table-striped table-bordered table-hover">
            <thead class="thin-border-bottom">
              <tr>
                <th style="width:50px">No</th>
                <th>id_uji</th>
                <th>Area</th>
                <th>Perimeter</th>
                <th>Metric</th>
                <th>Eccentricity</th>
                <th>Major_axis</th>
                <th>Minor_axis</th>
                <th>Diameter</th>
                <th>Jenis</th>
                <th>X</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($files as $file) :
              ?>
                <tr>
                  <td>
                    <?php echo $no ?>
                  </td>
                  <td>
                    <?php echo $file->id_uji  ?>
                  </td>
                  <td>
                    <?php echo $file->area ?>
                  </td>
                  <td>
                    <?php echo $file->perimeter ?>
                  </td>
                  <td>
                    <?php echo $file->metric ?>
                  </td>
                  <td>
                    <?php echo $file->eccentricity ?>
                  </td>
                  <td>
                    <?php echo $file->major_axis ?>
                  </td>
                  <td>
                    <?php echo $file->minor_axis ?>
                  </td>
                  <td>
                    <?php echo $file->diameter ?>
                  </td>
                  <td>
                    <!-- $file->data_label == 1) ? "LULUS" : (($file->data_label == 0) ? "TIDAK LULUS" : "BELUM DI UJI") -->
                    <?php
                                        if ($file['jenis'] == 0) {
                                            echo "Apel";
                                        } elseif ($file['jenis'] == 1) {
                                            echo "Gadung";
                                        } elseif ($file['jenis'] == 2) {
                                            echo "Gincu";
                                        } elseif ($file['jenis'] == 3) {
                                            echo "Golek";
                                        } elseif ($file['jenis'] == 4) {
                                            echo "Manalagi";
                                        } else {
                                            echo "BELUM DIUJI";
                                        }
                                        ?>
                  </td>
                  <td>
                    <?php echo ($file->tetangga_terdekat)  ?>
                  </td>
                </tr>
              <?php
                $no++;
              endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>


  </section>
</div>