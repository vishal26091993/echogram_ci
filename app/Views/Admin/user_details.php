<?= $this->extend('Common/header'); ?>
<?= $this->section('content'); ?>
<style type="text/css">
    label {
    margin-bottom: 2px;
    font-weight: 500;
    margin-top: 10px;
}
</style>
<div class="content-wrapper">

    <div class="page-header page-header-default">

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><i class="icon-home2 position-left"></i>Home
                <li class="active"><?= $data['title'] ?></li>
            </ul>
        </div>
    </div>

    <div class="content">
         <div class="panel panel-default">

                <div class="panel-heading">
                    <div class="row">
                        
                        <div class="col-md-10">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapsePanel1" aria-expanded="true" style="font-size: 16px;">
                                    <span class="glyphicon glyphicon-plus" style="color: #0042c3;"></span> <?= $data['title'] ?>
                                </a>
                            </h4>
                        </div>  

                    </div>
                </div>
            <div id="collapsePanel1" class="panel-collapse collapse in">
                
                <div class="panel-body table-responsive">
                    <div class="row">
                        
                        <div class="col-md-3">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php
                            if (isset($data['userData'][0]['first_name']) && isset($data['userData'][0]['middle_name']) && isset($data['userData'][0]['last_name'])) {
    
                                    echo $data['userData'][0]['first_name']." ".$data['userData'][0]['middle_name']." ".$data['userData'][0]['last_name'];
                                } elseif (isset($data['userData'][0]['first_name']) && isset($data['userData'][0]['middle_name'])) {
                                    
                                     echo $data['userData'][0]['first_name']." ".$data['userData'][0]['middle_name'];

                                } elseif (isset($data['userData'][0]['first_name']) && isset($data['userData'][0]['last_name'])) {
                                    
                                   echo $data['userData'][0]['first_name']." ".$data['userData'][0]['last_name'];

                                } elseif (isset($data['userData'][0]['first_name'])) {
                                    echo $data['userData'][0]['first_name'];
                                } elseif (isset($data['userData'][0]['last_name'])) {
                                    echo $data['userData'][0]['last_name'];
                                } else {
                                     echo "-";
                                }
                                 ?>" readonly>  
                        </div>
                        <div class="col-md-3">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php 
                            if(isset($data['userData'][0]['email']))
                            {
                                echo $data['userData'][0]['email']; 
                            }else
                            {
                                echo  "-";
                            }
                            ?>" readonly>  
                        </div>
                        <div class="col-md-2">
                            <label>Date Of Birth</label>
                            <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php 
                            if(isset($data['userData'][0]['date_of_birth']))
                            {
                                echo date("m-d-Y", strtotime($data['userData'][0]['date_of_birth'])); 
                            }else
                            {
                                echo  "-";
                            } 
                        ?>" readonly>  
                        </div>
                        <div class="col-md-2">
                            <label>Is Verified</label>
                            <input type="text" class="form-control" id="is_verified" name="is_verified" value="<?php 
                            if($data['userData'][0]['is_verified']==1)
                            {
                                echo "Yes";
                            }else{
                                echo "No";
                            }
                             ?>" readonly>  
                       </div> 
                        <div class="col-md-2">
                            <label>Is Active</label>
                            <input type="text" class="form-control" id="is_active" name="is_active" value="<?php 
                            if($data['userData'][0]['is_active']==1)
                            {
                                echo "Yes";
                            }else{
                                echo "No";
                            }
                             ?>" readonly>  
                       </div>   

                       <div class="col-md-3">
                            <label>Department</label>
                            <input type="text" class="form-control" id="department" name="department" value="<?php 
                            if(isset($data['userdetails']->department))
                            {
                                echo $data['userdetails']->department;
                            }else{
                                echo "-";
                            }
                             ?>" readonly>  
                       </div>

                       <div class="col-md-3">
                            <label>Attorney Registration Number</label>
                            <input type="text" class="form-control" id="attorny_registration_number" name="attorny_registration_number" value="<?php 
                            if(isset($data['userdetails']->attorny_registration_number))
                            {
                                echo $data['userdetails']->attorny_registration_number;
                            }else{
                                echo "-";
                            }
                             ?>" readonly>  
                       </div>

                       <div class="col-md-2">
                            <label>Admission Year</label>
                            <input type="text" class="form-control" id="new_york_state_admission_date_year" name="new_york_state_admission_date_year" value="<?php 
                            if(isset($data['userdetails']->new_york_state_admission_date_year)){

                                echo $data['userdetails']->new_york_state_admission_date_year;
                            }else{
                                echo "-";                       
                            }
                             ?>" readonly>  
                            
                       </div>
                       <div class="col-md-2">
                            <label>Admission Month</label>
                            <input type="text" class="form-control" id="new_york_state_admission_date_month" name="new_york_state_admission_date_month" value="<?php 
                            if(isset($data['userdetails']->new_york_state_admission_date_month))
                            {
                                echo $data['userdetails']->new_york_state_admission_date_month;

                            }else{
                                echo "-"; 
                            }
                             ?>" readonly>  
                       </div>
                       <div class="col-md-2">
                            <label>Admission Day</label>
                            <input type="text" class="form-control" id="new_york_state_admission_date_day" name="new_york_state_admission_date_day" value="<?php 
                            if(isset($data['userdetails']->new_york_state_admission_date_day))
                            {
                                echo $data['userdetails']->new_york_state_admission_date_day;

                            }else{
                                 echo "-";
                            }
                             ?>" readonly>  
                       </div>  
                       <div class="col-md-3">
                            <label>Biennial Reporting Date</label>
                            <input type="text" class="form-control" id="biennial_reporting_date" name="biennial_reporting_date" value="<?php 
                            if(isset($data['userdetails']->biennial_reporting_date))
                            {
                                echo date('m-d-Y',strtotime($data['userdetails']->biennial_reporting_date));
                            }else{
                                 echo "-";
                            }
                             ?>" readonly>  
                       </div>
                       <div class="col-md-3">
                            <label>Is Experienced</label>
                            <input type="text" class="form-control" id="is_experienced" name="is_experienced" value="<?php 
                            if($data['userdetails']->is_experienced == 1)
                            {
                                echo "Yes";
                            }else{
                                 echo "No";
                            }
                             ?>" readonly>  
                       </div>
                       <div class="col-md-3">
                            <label>profile</label>
                            <?php if(isset($data['userData'][0]['profile']))
                            { ?>

                                 <a class="media-left"><img title="No Image" src="<?php echo USER_IMAGE ?><?php echo $data['userData'][0]['profile']; ?>" class="img-circle img-lg" alt=""></a>

                            <?php }else{ ?>      

                                 <a class="media-left"><img title="No Image" src="<?php echo base_url(); ?>public/assets/images/OIP.jfif" class="img-circle img-lg" alt=""></a>
                            <?php } ?>
                       </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapsePanel4" aria-expanded="false" style="font-size: 16px;">
                        <span class="glyphicon glyphicon-plus" style="color: #0042c3;"></span> CLE Tracker
                    </a>
                </h4>
            </div>
            <div id="collapsePanel4" class="panel-collapse collapse in">
                <div class="panel-body table-responsive">
                    <div class="row">        
                            <div class="col-md-12">
                             <table class="table datatable-selection-single" id="order_list" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>   
                                        <th>Cle Name</th>
                                        <th>Cle Date</th>
                                        <th>Category</th>
                                        <th>Credits Earned</th>
                                        <th>Document</th>
                                    </tr>
                                </thead>
                                     
                                <tbody>  
                                <?php if($data['currentcledata']){
                                    $i=1;
                                    foreach($data['currentcledata'] as $orders){      ?>   
                                    <tr>             
                                        <td><?php echo $i; ?></td>
                                        <td><?php
                                        if(isset($orders['cle_name'])) {
                                            echo $orders['cle_name'];
                                        }
                                        ?></td>
                                         <td><?php
                                        if(isset($orders['cle_date'])) {
                                            echo date('m-d-Y',strtotime($orders['cle_date']));
                                        }
                                        ?></td>
                                        <td><?php
                                        if(isset($orders['cat_name'])) {
                                            echo $orders['cat_name'];
                                        }
                                        ?></td>
                                        <td><?php
                                        if(isset($orders['creditsEarned'])) {
                                            echo $orders['creditsEarned'];
                                        }
                                        ?></td>
                                        <td><?php
                                        if(isset($orders['document'])) 
                                        {
                                            echo '<a href="'.DOCUMENTS.$orders['document'].'" target="_blank">'.$orders['document'].'</a>';
                                        }else{
                                            echo "-";
                                        }
                                        ?></td>  
                                     </tr>
                                <?php $i++; }  } ?>        
                                </tbody>
                              </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        
        
        <div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" href="#collapsePanel3" aria-expanded="false" style="font-size: 16px;">
                <span class="glyphicon glyphicon-plus" style="color: #0042c3;"></span>
                Archive CLE Tracker History
            </a>
        </h4>
    </div>
    <div id="collapsePanel3" class="panel-collapse collapse in">
        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-12">
                     <!-- Year filter dropdown -->
                     <div class="row" style="margin-left:32%;">
                        <label>Select Archive Year :</label>
                      <select id="yearFilter" class="form-control" style="width: 30%;display: inline-block;border: 2px solid #0042c3;">
                            <option value="">Select Year</option>
                            <?php
                            $currentYear = date("Y");
                            $startYear = 2024; // Starting year
                            $endYear = $currentYear;

                            for ($i = $endYear; $i >= $startYear; $i--) {
                                if ($i == $currentYear) {
                                    echo "<option value='$i' selected>$i</option>";
                                } else {
                                    echo "<option value='$i'>$i</option>";
                                }
                                if ($i == $currentYear && $i != $startYear) {
                                    // Include the previous year when the current year is reached (excluding the start year)
                                    echo "<option value='" . ($i - 1) . "'>" . ($i - 1) . "</option>";
                                }
                            }
                            ?>
                        </select>


                    </div>

                    <!-- Table to display data -->
                    <table class="table datatable-selection-single" id="clehistory_list" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>   
                                <th>Cle Name</th>
                                <th>Cle Date</th>
                                <th>Category</th>
                                <th>Credits Earned</th>
                                <th>Document</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<div id="modal_order_details" class="modal fade">
            <div class="modal-dialog modal-lg"> <!-- Add modal-lg for a larger modal if needed -->
                <div class="modal-content login-form">
                    <form id="category_form" class="modal-body">
                     
                    </form>
                </div>
            </div>
 </div>
<style type="text/css">
select {
    padding: 6px;
}
.nav-tabs > li > a {
    background: #b8b8b8;
    color: black;
    border: 1px solid #b8b8b8;
    border-radius: 5px;
    margin: 5px;
    margin-left: 20px;
}

/* Styles for the active tab */
.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
    background: darkcyan;
    border-color: darkcyan;
    color: white;
    margin-left: 20px;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<script type="text/javascript">
    var dataTable; 
$(document).ready(function() {
    $(".product_category").addClass("active");

    
    $(document).ready(function() {
    $(".product_category").addClass("active");

            // Event handler for year filter change
            $("#yearFilter").change(function() {
                var year = $("#yearFilter").val();
                loadData(year); // Reload data when year filter changes
            });

            // Load data initially
            var year = new Date().getFullYear(); // Get current year
            loadData(year); // Load data initially with current year
        });

   // Load data initially
    var year = new Date().getFullYear(); // Get current year

    //alert(year);

    loadData(year); // Load data initially with current year

    function loadData(year) 
    {
        var selectedUserId = "<?php echo $data['user_id']; ?>";
        var selectedYear = year;

        // Destroy existing DataTable instance if it exists
        if ($.fn.DataTable.isDataTable('#clehistory_list')) {
            $('#clehistory_list').DataTable().destroy();
        }

        // Initialize DataTable
        dataTable = $('#clehistory_list').DataTable({
            'processing': false,
            'serverSide': true,
            "oLanguage": {
                "sZeroRecords": "No Data Found"
            },
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url(route_to('getCleHistoryArchiveList')) ?>',
                'data': {
                    'user_id': selectedUserId,
                    'year': selectedYear 
                }
            },
            "order": [
                ['0', 'desc']
            ],
            'columns': [
                {
                    data: 'id',
                    visible: false
                },
                {
                    data: 'cle_name',
                    width: '100px'
                },
                {
                    data: 'cle_date',  
                    width: '300px'
                },
                {
                    data: 'cat_name',
                    orderable: false,
                    searchable: false,
                    width: '100px'
                },
                {
                    data: 'creditsEarned',
                    width: '200px'
                },
                {
                    data: 'doc',
                    orderable: false,
                    searchable: false,
                    width: '200px'
                }
            ],
            initComplete: function () {
                $('.dataTables_length select').select2({
                    minimumResultsForSearch: Infinity
                });
                $('.dataTables_length .select2').addClass('w-auto');
            }
        });
    }
});
</script>




    <?= $this->endSection(); ?>