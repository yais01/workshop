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
        <?php echo form_open_multipart(); ?>
        <?php
        $a = array(1, 1, 1, 1, 1);
        $ind = 0;
        foreach ($a as $d) :
        ?>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> Data Ke-<?php echo $ind + 1 ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-4 ">
                                    <div class="form-group ">
                                        <input type="text" class="form-control" placeholder="Area" name="area[<?php echo $ind ?>]" value="<?php echo set_value("area[$ind]"); ?>" />
                                        <span style="color:red"><?php echo form_error("area[$ind]"); ?></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group has-feedback">
                                        <input type="number" step="any" class="form-control" placeholder="Perimeter" name="perimeter[<?php echo $ind ?>]" value="<?php echo set_value("perimeter[$ind]"); ?>" />
                                        <span style="color:red"><?php echo form_error("perimeter[$ind]"); ?></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group has-feedback">
                                        <input type="number" step="any" class="form-control" placeholder="Metric" name="metric[<?php echo $ind ?>]" value="<?php echo set_value('metric[' . $ind . ']'); ?>" />
                                        <span style="color:red"><?php echo form_error('metric[' . $ind . ']'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group has-feedback">
                                        <input type="number" step="any" class="form-control" placeholder="Eccentricity" name="eccentricity[<?php echo $ind ?>]" value="<?php echo set_value('eccentricity[' . $ind . ']'); ?>" />
                                        <span style="color:red"><?php echo form_error('eccentricity[' . $ind . ']'); ?></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group has-feedback">
                                        <input type="number" step="any" class="form-control" placeholder="Major_axis" name="major_axis[<?php echo $ind ?>]" value="<?php echo set_value('major_axis[' . $ind . ']'); ?>" />
                                        <span style="color:red"><?php echo form_error('major_axis[' . $ind . ']'); ?></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group has-feedback">
                                        <input type="number" step="any" class="form-control" placeholder="Minor_axis" name="minor_axis[<?php echo $ind ?>]" value="<?php echo set_value('minor_axis[' . $ind . ']'); ?>" />
                                        <span style="color:red"><?php echo form_error('minor_axis[' . $ind . ']'); ?></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group has-feedback">
                                        <input type="number" step="any" class="form-control" placeholder="Diameter" name="diameter[<?php echo $ind ?>]" value="<?php echo set_value('diameter[' . $ind . ']'); ?>" />
                                        <span style="color:red"><?php echo form_error('diameter[' . $ind . ']'); ?></span>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                <div class="form-group has-feedback">
                                <select step="any" class="form-control" name="jenis[<?php echo $ind ?>]">
                                <option> Pilih Jenis</option>
                                    <option value="0">Apel</option>
                                    <option value="1">Gadung</option>
                                    <option value="2">Gincu</option>
                                    <option value="3">Golek</option>
                                    <option value="4">Manalagi</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
            $ind++;
        endforeach;
        ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="pull-right btn btn-sm btn-primary ">
                            <i class="ace-icon fa fa-paper-plane"></i>
                            <span class="bigger-110">Submit</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close() ?>
    </section>
</div>