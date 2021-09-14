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
                <br>
                <br>
                <a href="<?php echo site_url('landing/add_biodata'); ?>" class="btn-sm btn-primary">Tambah Data</a>
                <a href="<?php echo site_url('admin/data_uji/import'); ?>" class="btn-sm btn-success">Import Data Uji</a>
                <a href="<?php echo site_url('admin/data_uji/hapus'); ?>" class="btn-sm btn-danger">Kosongkan Data</a>
            </div>
            <!-- /.box-header -->

        </div>




    </section>
</div>