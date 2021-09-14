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

<!-- Main content -->
  <section class="content">
    <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo $page_name ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php echo form_open_multipart('admin/data_latih/updatelatih');?>
            <div class="row">
                <div class="col-xs-12">
                <?php
                            foreach($latihedit as $edit) :
                        ?>
                      <div class="row  ">
                          
                              <div class="form-group has-feedback">
                              <input type="hidden" name="id_latih" id="id_latih" class="form-control" value="<?= $edit->id_latih;?>" required>
                              </div>

                              <div class="form-group has-feedback">
                              <input type="hidden" name="jenis" id="jenis" class="form-control" value="<?= $edit->jenis;?>" required >
                              </div>
                          
                          <div class="col-xs-2 ">
                              <div class="form-group has-feedback">
                              <input type="number" name="area" id="area" class="form-control" value="<?= $edit->area;?>" required>
                              </div>
                          </div> 
                          <div class="col-xs-2 ">
                              <div class="form-group has-feedback">
                              <input type="number" name="perimeter" id="perimeter" class="form-control" value="<?= $edit->perimeter;?>" required>
                              </div>
                          </div> 
                          <div class="col-xs-2 ">
                              <div class="form-group has-feedback">
                              <input type="number" name="metric" id="metric" class="form-control" value="<?= $edit->metric;?>" required>
                              </div>
                          </div> 
                          <div class="col-xs-2 ">
                              <div class="form-group has-feedback">
                              <input type="number" name="eccentricity" id="eccentricity" class="form-control" value="<?= $edit->eccentricity;?>" required>
                              </div>
                          </div> 
                          <div class="col-xs-2 ">
                              <div class="form-group has-feedback">
                              <input type="number" name="major_axis" id="major_axis" class="form-control" value="<?= $edit->major_axis;?>" required>
                              </div>
                          </div> 
                          <div class="col-xs-2 ">
                              <div class="form-group has-feedback">
                              <input type="number" name="minor_axis" id="minor_axis" class="form-control" value="<?= $edit->minor_axis;?>" required>
                              </div>
                          </div> 
                          <div class="col-xs-2 ">
                              <div class="form-group has-feedback">
                              <input type="number" name="diameter" id="diameter" class="form-control" value="<?= $edit->diameter;?>" required>
                              </div>
                          </div> 
                      </div>
                    <?php 
                      endforeach;
                    ?>
                    <br>
                    <div class="row">
                        <div class="col-xs-12">
                            <input id="" type="text" name="id_latih" value="<?php echo $edit->id_latih ?>"  hidden readonly />
                            <button type="submit" class="pull-right btn btn-sm btn-primary ">
                                <i class="ace-icon fa fa-paper-plane"></i>
                                <span class="bigger-110">Submit</span>
                            </button>  
                        </div>
                    </div>
                </div>
            </div>
                <?php echo form_close()?>
            </div>
      </div>
    </div>
  </section>
</div>