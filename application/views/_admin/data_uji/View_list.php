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
                <a href="<?php echo site_url('admin/data_uji/create'); ?>" class="btn-sm btn-primary">Tambah Data</a>
                <a href="<?php echo site_url('admin/data_uji/import'); ?>" class="btn-sm btn-success">Import Data Uji</a>
                <a href="<?php echo site_url('admin/data_uji/hapus'); ?>" class="btn-sm btn-danger">Kosongkan Data</a>
            </div>
            <!-- /.box-header -->

        </div>
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
                                <!-- <th>id_uji</th> -->
                                <th>Area</th>
                                <th>Perimeter</th>
                                <th>Metric</th>
                                <th>Eccentricity</th>
                                <th>Major_axis</th>
                                <th>Minor_axis</th>
                                <th>Diameter</th>
                                <th>Jenis</th>
                                <th>Aksi</th>

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
                                    <!-- <td>
                                        <?php echo $file->id_uji  ?>
                                    </td> -->
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
                                    <?php echo ($file->jenis == 1) ? "Gadung" : (($file->jenis == 0) ? "Apel" : (($file->jenis == 2) ? "Gincu" : (($file->jenis == 3) ? "Golek" : (($file->jenis == 4) ? "Manalagi" : "BELUM DI UJI")))) ?>
                                        </td>
                                    <td>
                                        <!-- <a href="<?php echo site_url('admin/data_uji/uji/') . $file->id_uji; ?>" class="btn btn-sm btn-success">Uji</a> -->
                                        <button type="submit" class=" btn btn-sm btn-success" data-toggle="modal" data-target="#uji<?php echo $file->id_uji ?>">
                                            Uji
                                        </button>
                                        <!-- modal -->
                                        <div class="modal fade" id="uji<?php echo $file->id_uji ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title"><b>Uji KNN </b></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo form_open_multipart("admin/data_uji/uji"); ?>
                                                        <div class="form-group">
                                                            <label for="">Nilai K </label>
                                                            <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="number" class="form-control" name="k_value" value="1" min="1" max="<?php echo count($data_latih) ?>" required="required">
                                                                    <input type="hidden" class="form-control" value="<?php echo $file->id_uji ?>" name="id_uji" required="required" readonly>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">UJI</button>
                                                    </div>

                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- modal -->
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

    <!-- modal -->
        <div class="modal fade" id="ujiKnn" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Uji KNN </b></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart("admin/data_uji/uji_batch_2"); ?>
                        <div class="form-group">
                            <label for="">Nilai K </label>
                            <label class="block clearfix">
                                <span class="block input-icon input-icon-right">
                                    <input type="number" class="form-control" name="k_value" value="1" min="1" max="<?php echo count($data_latih) ?>" required="required">
                                </span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">UJI</button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        <!-- modal -->


        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="pull-right btn btn-sm btn-success" data-toggle="modal" data-target="#ujiKnn">
                            Uji Keseluruhan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>