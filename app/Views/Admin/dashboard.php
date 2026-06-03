<?php echo $this->extend('Common/header_main'); ?>
<?php echo $this->section('content'); ?>
    
    <?php if (session()->get('user_role') == SUPER_ADMIN) { ?>

        <div class="page-wrapper">

                    <div class="content container-fluid pb-0">

                        <div class="row">
                            <div class="col-xxl-12 col-lg-12 col-md-12">
                                <div class="row">

                                
                                    <div class="col-lg-2 col-md-12">
                                        <div class="card employee-welcome-card flex-fill">
                                            <div class="card-body">
                                                <div class="welcome-info">
                                                    <div class="welcome-content">
                                                        <h4><?php if (isset($data['clients'])) {
                                                            echo $data['clients'];
                                                        } ?></h4>
                                                        <p>Total <br> Clients</p>
                                                    </div>
                                                    <div class="welcome-img">
                                                        <i class="la la-dashboard" style="font-size: 40px;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
            
                                </div>



                            </div>
                        </div>

                    </div>

        </div>
    <?php } ?>      


</body>
</html>
<?php echo $this->include('Common/footer'); ?>
<?php echo $this->endSection(); ?>   
