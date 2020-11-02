<?php
define("ADMIN", true);
require_once("../common/lib.php");
require_once("../common/define.php");
define("TITLE_ELEMENT", $texts['DASHBOARD']);

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}elseif($_SESSION['user']['type'] == "registered"){
    unset($_SESSION['user']);
    $_SESSION['msg_error'][] = "Access denied.";
    header("Location: login.php");
    exit();
}
function checkRoomAvailability($roomid) {
    global $db;
    $result  = $db->query("SELECT count(*) AS bookingcount FROM pm_booking INNER JOIN pm_booking_room ON 
                        pm_booking_room.id_booking = pm_booking.id  WHERE to_date > '". time()."' AND from_date < '".time()."' 
                        AND pm_booking_room.id_room = ".$roomid);
    $result  = $result->fetch();

    if($result['bookingcount'] == 0)
        return true;
    else
        return false;
}
require_once("includes/fn_module.php"); ?>
<!DOCTYPE html>
<head>
    <?php include("includes/inc_header_common.php"); ?>
    <style>
/*.panel-primary {
    background:  !important;
}*/
.panel-success {
   background: #1BBA97 !important;
}
.panel-danger {
   background: #F36A59 !important;
}
</style>
</head>
<body>
    <div id="wrapper">
        <?php include("includes/inc_top.php"); ?>
        <div id="page-wrapper">
            <div class="page-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h1><i class="fas fa-fw fa-tachometer-alt"></i> <?php echo $texts['DASHBOARD']; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="alert-container">
                    <div class="alert alert-success alert-dismissable"></div>
                    <div class="alert alert-warning alert-dismissable"></div>
                    <div class="alert alert-danger alert-dismissable"></div>
                </div>
<?php if($_SESSION['user']['type']=='manager'){?>
<div class="row roomfilter">
    <div class="col-md-12">
        <form action="">
            <?php   
            $Allroomtypes = $db->query('SELECT * FROM pm_room_type' );
            $Allroomtypes = $Allroomtypes->fetchAll(); ?>
            <div class="col-md-3">
                <select name="r_type" class="form-control">
                    <option value="">Select Room Type</option>
                <?php foreach($Allroomtypes as $singleroom) : ?>
                        <option <?php if(isset($_REQUEST['r_type'])&& $_REQUEST['r_type'] == $singleroom['rid']) echo "selected=selected"; ?> value="<?php echo $singleroom['rid']; ?>"><?php echo $singleroom['rname']; ?></option>        
                <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="price_range" class="form-control">
                    <option value="">Price Range</option>
                    <option <?php if(isset($_REQUEST['price_range'])&& $_REQUEST['price_range'] == '0-1000') echo "selected=selected"; ?> value="0-1000">0-1000</option>
                    <option <?php if(isset($_REQUEST['price_range'])&& $_REQUEST['price_range'] == '1001-2000') echo "selected=selected"; ?> value="1001-2000">1001-2000</option>
                    <option <?php if(isset($_REQUEST['price_range'])&& $_REQUEST['price_range'] == '2001-3000') echo "selected=selected"; ?> value="2001-3000">2001-3000</option>
                    <option <?php if(isset($_REQUEST['price_range'])&& $_REQUEST['price_range'] == '3000') echo "selected=selected"; ?> value="3000">above 3000</option>
                </select>
            </div>
            <div class="col-md-2">
                <input value="<?php if(isset($_REQUEST['check_in_date'])) echo $_REQUEST['check_in_date']; ?>" class="form-control col-md-6 col-xs-12 datepicker" id="check_in_date" placeholder="Check In" name="check_in_date" autocomplete="off" type="text"/>
            </div>
            <div class="col-md-2">
                        <input value="<?php if(isset($_REQUEST['check_out_date'])) echo $_REQUEST['check_out_date']; ?>" class="form-control col-md-6 col-xs-12 datepicker" id="check_out_date" placeholder="Check Out" name="check_out_date" autocomplete="off" type="text"/>
            </div>
            <div class="col-md-2">
                        <input id="searchsubmit" value="Search" class="btn btn-primary" name="search_rooms" type="submit"/>
            </div>
        </form>
    </div>
</div>        
<hr/>
                      
<div class="row" id="dashboard">
            <?php 
                $where = "1=1 ";

                if(isset($_REQUEST['r_type']) && $_REQUEST['r_type']!="") {
                   $where .= " AND pm_room_meta.room_type=".$_REQUEST['r_type'];
                }
                if(isset($_REQUEST['price_range']) && $_REQUEST['price_range']!="") {
                    if($_REQUEST['price_range'] != "3000") {
                        $pricearr = explode("-",$_REQUEST['price_range']);
                        $where .= " AND pm_room.price BETWEEN ".$pricearr[0]." AND ".$pricearr[1];
                    } else {
                        $where .= " AND pm_room.price > ".$_REQUEST['price_range'];
                    }
                        
                }
                if(isset($_REQUEST['check_in_date']) && $_REQUEST['check_in_date']!="") {
                    $check_in_date = strtotime($_REQUEST['check_in_date']);
                    $check_out_date = strtotime($_REQUEST['check_out_date']);
                    $where .= " AND (pm_booking.from_date NOT BETWEEN ".$check_in_date." AND ".$check_out_date.") AND (pm_booking.to_date NOT BETWEEN ".$check_in_date." AND ".$check_out_date.")";
                   
                }
               /* echo 'SELECT pm_room.* FROM pm_room LEFT JOIN pm_room_meta ON pm_room.id = pm_room_meta.room_id 
                                            LEFT JOIN pm_booking_room ON pm_room.id =  pm_booking_room.id_room 
                                            LEFT JOIN pm_booking ON pm_booking_room.id_booking = pm_booking.id WHERE '.$where.' GROUP BY  pm_room.id';*/

                $result_user = $db->query('SELECT pm_room.* FROM pm_room LEFT JOIN pm_room_meta ON pm_room.id = pm_room_meta.room_id 
                                            LEFT JOIN pm_booking_room ON pm_room.id =  pm_booking_room.id_room 
                                            LEFT JOIN pm_booking ON pm_booking_room.id_booking = pm_booking.id WHERE '.$where.' GROUP BY  pm_room.id'); 
            
            foreach($result_user as $i => $row){
                  $RoomAvailable = checkRoomAvailability($row['id']); 

                  if($RoomAvailable) {
                      $panelColor = 'success';
                  } else {
                      $panelColor = 'danger';
                  }

                  ?>
                    <div class="dashboard-entry col-lg-3 col-md-4 col-sm-6">
                                        <div class="panel panel-<?php echo $panelColor; ?>">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <div class="huge"><svg class="svg-inline--fa fa-bed fa-w-18 fa-fw" aria-hidden="true" data-fa-processed="" data-prefix="fas" data-icon="bed" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M552 288c13.255 0 24 10.745 24 24v136h-96v-64H96v64H0V88c0-13.255 10.745-24 24-24h48c13.255 0 24 10.745 24 24v200h456zM192 96c-44.183 0-80 35.817-80 80s35.817 80 80 80 80-35.817 80-80-35.817-80-80-80zm384 128c0-53.019-42.981-96-96-96H312c-13.255 0-24 10.745-24 24v104h288v-32z"></path></svg><!-- <i class="fas fa-fw fa-bed"></i> --></div>
                                                    </div>
                                                    <div class="col-xs-9 text-right">
                                                        <div class="huge"><?php echo $row['stock']; ?></div>
                                                        <h3 class="mt0"><?php echo $row['title']; ?></h3>
                                                        <small>&nbsp;</small>                                                    </div>
                                                </div>
                                            </div>
                                            <a href="/admin/modules/booking/room/index.php?view=list">
                                                <div class="panel-footer">
                                                    <!--<span class="pull-left">Show</span>-->
                                                   
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                            <?php  if($RoomAvailable) : ?>
                                            <!--<a href="/admin/modules/booking/room/index.php?view=form&amp;id=0">-->
                                            <a href="<?php echo DOCBASE.ADMIN_FOLDER; ?>/modules/booking/booking/index.php?view=bookingform&id=<?php echo $row['id']; ?>">
                                                <div class="panel-footer">
                                                    <span class="pull-left">Add</span>
                                                    <span class="pull-right"><i class="fas fa-fw fa-plus-circle"></i> </span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                            <?php else : ?>
                                                <div class="panel-footer">
                                                    <span class="pull-left">Booked</span>
                                                    <span class="pull-right"><!-- <i class="fas fa-fw fa-plus-circle"></i> --></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php }?>
                </div>
                                    
                                    <?php } else{?>
                <div class="row" id="dashboard">
                    <?php
                    if($db !== false){
                        // print_r($modules);
                        // die;
                        foreach($modules as $module){

                            $title = $module->getTitle();
                            $name = $module->getName();
                            $dir = $module->getDir();
                            $dates = $module->isDates();
                            $count = 0;
                            $last_date = "";
                            $rights = $module->getPermissions($_SESSION['user']['type']);
                            
                            if($module->isDashboard() && !in_array("no_access", $rights) && !empty($rights)){
                                $query = "SELECT count(id) AS nb";
                                if($dates) $query .= ", MAX(add_date) AS last_add_date, MAX(edit_date) AS last_add_date";
                                $query .= " FROM pm_".$name." WHERE 1";
                                if($module->isMultilingual()) $query .= " AND lang = ".DEFAULT_LANG;
                                
                                if(!in_array($_SESSION['user']['type'], array("administrator", "manager", "editor")) && db_column_exists($db, "pm_".$name, "users"))
                                    $query .= " AND users REGEXP '(^|,)".$_SESSION['user']['id']."(,|$)'";
                                    
                                    
                                
                                $result = @$db->query($query);
                                
                                if($result !== false && $db->last_row_count() > 0){
                                    $row = $result->fetch();
                                    $count = $row[0];
                                    if($dates){
                                        $last_add_date = (!is_null($row[1])) ? $row[1] : 0;
                                        $last_edit_date = (!is_null($row[2])) ? $row[2] : 0;
                                        
                                        $last_date = max($last_edit_date, $last_add_date);
                                        $last_date = ($last_date == 0) ? "" : date("Y-m-d g:ia", $last_date);
                                    } ?>
                                    
                                    <div class="dashboard-entry col-lg-3 col-md-4 col-sm-6">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <div class="huge"><i class="fas fa-fw fa-<?php echo $module->getIcon(); ?>"></i></div>
                                                    </div>
                                                    <div class="col-xs-9 text-right">
                                                        <div class="huge"><?php echo $count; ?></div>
                                                        <h3 class="mt0"><?php echo $title; ?></h3>
                                                        <?php
                                                        if($last_date != ""){
                                                            echo "<i class=\"fas fa-fw fa-clock\"></i> <small>".$last_date."</small>";
                                                        }else echo "<small>&nbsp;</small>"; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="<?php echo $dir; ?>/index.php?view=list">
                                                <div class="panel-footer">
                                                    <span class="pull-left"><?php echo $texts['SHOW']; ?></span>
                                                    <span class="pull-right"><i class="fas fa-fw fa-chevron-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                            <a href="<?php echo $dir; ?>/index.php?view=form&id=0">
                                                <div class="panel-footer">
                                                    <span class="pull-left"><?php echo $texts['ADD']; ?></span>
                                                    <span class="pull-right"><i class="fas fa-fw fa-plus-circle"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    } ?>
                </div>
                <?php } ?>

              <?php  if($_SESSION['user']['type']=='administrator'){ ?>
                <div class="dashboard-entry col-lg-3 col-md-4 col-sm-6">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <div class="huge"><i class="fas fa-fw fa-<?php echo $module->getIcon(); ?>"></i></div>
                                                    </div>
                                                    <?php 
                                                    $typecount='';
                                                    $Room_types = $db->query('SELECT count(*) As typeCount FROM pm_room_type' ); 
                                                    if(!empty($Room_types)) : 
                                                    while( $room_type = $Room_types->fetch(PDO::FETCH_OBJ) ){
                                                          $typecount .=$room_type->typeCount;
                                                    $typecount++;
                                                 }
                                                 endif; ?>
                                                    <div class="col-xs-9 text-right">
                                                        <div class="huge"><?php echo $typecount; ?></div>
                                                        <h3 class="mt0">Room Type</h3>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                       <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
                                        function removeFilename($actual_link)
                                            {
                                                $file_info = pathinfo($actual_link);
                                                return isset($file_info['extension'])
                                                    ? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $actual_link)
                                                    : $actual_link;
                                            }
                                       ?>
                                          <a href="<?php echo removeFilename($actual_link); ?>modules/room_type/list.php">
                                                <div class="panel-footer">
                                                    <span class="pull-left">Show</span>
                                                    <span class="pull-right"><i class="fas fa-fw fa-chevron-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                            <a href="<?php echo removeFilename($actual_link); ?>modules/room_type/list.php?add">
                                                <div class="panel-footer">
                                                    <span class="pull-left">Add</span>
                                                    <span class="pull-right"><i class="fas fa-fw fa-plus-circle"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
            </div>
        </div>
    </div>
<script>
    $( function() {
        $( ".datepicker" ).datepicker({ minDate: 0});
      } );
</script>
</body>
</html>
<?php
$_SESSION['msg_error'] = array();
$_SESSION['msg_success'] = array();
$_SESSION['msg_notice'] = array(); ?>
