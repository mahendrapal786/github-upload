<?php
/**
 * Template of the module form
 */
debug_backtrace() || die ('Direct access not permitted');
 
// Item ID
if(isset($_GET['id']) && is_numeric($_GET['id'])) $id = $_GET['id'];
elseif(isset($_POST['id']) && is_numeric($_POST['id'])) $id = $_POST['id'];
else{
    header('Location: index.php?view=list');
    exit();
}

$guestid = "";
if(isset($_REQUEST['submit_booking'])) {
    $name = $_REQUEST['name'];
    $lastname = $_REQUEST['lastname'];
    $father_name = $_REQUEST['father_name'];
    $email = $_REQUEST['email'];
    $mobile = $_REQUEST['mobile'];
    $address = $_REQUEST['address'];
    $nationality = $_REQUEST['nationality'];
    $country = $_REQUEST['country'];
    $state = $_REQUEST['state'];
    $city = $_REQUEST['city'];
    $gender = $_REQUEST['gender'];
    $age = $_REQUEST['age'];
    $created = date('Y-m-d H:i:s');

    if($_REQUEST['guest_type'] == "new") {
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $sql = "INSERT INTO pm_guests VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt= $db->prepare($sql);
        $query = $stmt->execute(['',$name,$lastname,$email,$mobile,$father_name,$address,$country,$nationality,$state,$city,$gender,$age,$created,'1']);
        if($query)
          $guestid = $db->lastInsertId();
    } else if ($_REQUEST['guest_type'] == "existing") {
        $guestid = $_REQUEST['selected_guest_id'];

        $Guestdetail = $db->query('SELECT * FROM pm_guests WHERE id='.$guestid );
         $Guestdetail = $Guestdetail->fetch();
        
        $name = $Guestdetail['fullname'];
        $lastname = $Guestdetail['lastname'];
        $father_name = $Guestdetail['father_name'];
        $email = $Guestdetail['email'];
        $mobile = $Guestdetail['mobile'];
        $address = $Guestdetail['address'];
        $nationality = $Guestdetail['nationality'];
        $country = $Guestdetail['country'];
        $state = $Guestdetail['state'];
        $city = $Guestdetail['city'];
        $gender = $Guestdetail['gender'];
        $age = $Guestdetail['age'];
        $created = date('Y-m-d H:i:s');
    }
    $roomid = $_REQUEST['room_id'];
    if($guestid != "" ) : 
      $Roomdetail = $db->query('SELECT * FROM pm_room WHERE id='.$roomid );
      $Roomdetail = $Roomdetail->fetch();

      $price = $Roomdetail['price'];

      $add_date           = strtotime(date("Y-m-d H:i:s"));
      $from_date          = strtotime($_REQUEST['check_in_date']);
      $to_date            = strtotime($_REQUEST['check_out_date']);
      $nights             = $_REQUEST['duration_of_stay'];
      $adult              = $_REQUEST['adult'];
      $kids               = $_REQUEST['kids'];
      $booked_by          = $_REQUEST['booked_by'];
      $vehicle_number     = $_REQUEST['vehicle_number'];
      $referred_by        = $_REQUEST['referred_by'];
      $referred_by_name   = $_REQUEST['referred_by_name'];
      $reason_visit_stay  = $_REQUEST['reason_visit_stay'];
      $remark_amount      = $_REQUEST['remark_amount'];
      $remark             = $_REQUEST['remark'];
      $persons_info       = $_REQUEST['persons_info'];
      $paid               = $_REQUEST['advance_payment'];

      $total   = $price * $nights;
      $balance = $total-$advance_payment;
      $payment_date = strtotime(date("Y-m-d H:i:s"));
      $payment_option = 'arrival';

      $sql = "INSERT INTO pm_booking (`add_date`,`from_date`,`to_date`,`nights`,`adults`,`children`,`total`,`down_payment`,`paid`,`balance`,`firstname`,`lastname`,`email`,`address`,`city`,`phone`,`mobile`,`country`,`status`,`payment_date`,`payment_option`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
      $stmt= $db->prepare($sql);
      $stmt->execute([$add_date,$from_date,$to_date,$nights,$adult,$kids,$total,0,$paid,$balance,$name,$lastname,$email,$address,$city,$mobile,$mobile,$country,$status,$payment_date,$payment_option]);

      $bookingid = $db->lastInsertId();
      $sql = "INSERT INTO pm_booking_payment (`id_booking`,`method`,`amount`,`date`) VALUES (?,?,?,?)";
      $stmt= $db->prepare($sql);
      $stmt->execute([$bookingid,'cash',$paid,$payment_date]);

      
      $sql = "INSERT INTO pm_booking_room (`id_booking`,`id_room`,`num`,`children`,`adults`,`amount`) VALUES (?,?,?,?,?,?)";
      $stmt= $db->prepare($sql);
      $stmt->execute([$bookingid,$roomid,1,$kids,$adult,$paid]);
      $_SESSION['msg_success'][] = "Booking Successfully Added";
      header('Location: index.php?view=list');
    else :
      $_SESSION['msg_error'][] = "Guest id can not be null";
      header('Location: '.$_SERVER['PHP_SELF']);
    endif;
    exit();
}
 ?>
<!DOCTYPE html>
<head>
    <?php include(SYSBASE.ADMIN_FOLDER.'/includes/inc_header_form.php'); ?>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    <div id="overlay"><div id="loading"></div></div>
    <div id="wrapper">
        <?php
        include(SYSBASE.ADMIN_FOLDER.'/includes/inc_top.php');
        
        if(!in_array('no_access', $permissions)){
            include(SYSBASE.ADMIN_FOLDER.'/includes/inc_library.php'); ?>
            
<div class="row">
<div class="container">
   <form style="padding:70px" method="POST" action="?view=bookingform&id=<?php echo $_REQUEST['id']; ?>" accept-charset="UTF-8" id="add-reservation-form" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate="novalidate">
     <input type="hidden" name="room_id" value="<?php echo $_REQUEST['id']; ?>"/>
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Guest Type</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <div class="row">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                           <input class="guest_type" checked="checked" id="new_guest" checked="checked" name="guest_type" type="radio" value="new" />
                           <label for="new_guest" class="">New Guest</label>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12">
                           <input class="guest_type" id="existing_guest" name="guest_type" type="radio" value="existing"/>
                           <label for="existing_guest" class="">Existing Guest</label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php 
        $Allguests = $db->query('SELECT * FROM pm_guests' );
        $Allguests = $Allguests->fetchAll();

        $Countrylist = $db->query('SELECT * FROM pm_country' );
        $Countrylist = $Countrylist->fetchAll();

      ?>
      
      <div class="row guest_section" id="new_guest_section">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Guest Information</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> First Name <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="name" placeholder="Enter First Name" name="name" type="text" />
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Last Name <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="name" placeholder="Enter Last Name" name="lastname" type="text" />
                     </div>


                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Father Name <span class="required">*</span></label>
                        <input class="form-control col-md-6 col-xs-12" id="father_name" placeholder="Enter Father Name" name="father_name" type="text"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Email </label>
                        <input required class="form-control col-md-6 col-xs-12" id="email" placeholder="Enter Email Address" name="email" type="email"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Mobile No. <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="mobile" placeholder="Enter Mobile Number" name="mobile" type="text"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Address <span class="required">*</span></label>
                        <textarea required class="form-control col-md-6 col-xs-12" id="address" placeholder="Enter Address" rows="1" name="address" cols="50"></textarea>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label">Nationality</label>
                        <select  class="form-control col-md-6 col-xs-12" name="nationality">
                           <?php
                            if(!empty($Countrylist)):
                              $selection='India';
                               foreach($Countrylist as $SingleGuest):
                                 $selected=($SingleGuest['name'] == $selection)? "selected" : ""; ?>
                                <option <?php echo $selected; ?> value="<?php echo $SingleGuest['id']; ?>"><?php echo $SingleGuest['name']; ?></option><?php
                              endforeach; 
                            endif; ?>
                        </select>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Country <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="country" placeholder="Enter Country" name="country" type="text" value="India"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> State <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="state" placeholder="Enter State" name="state" type="text"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> City <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="city" placeholder="Enter City" name="city" type="text"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label">Gender <span class="required">*</span></label>
                        <select required class="form-control col-md-6 col-xs-12" name="gender" required>
                           <option selected="selected" value="">--Select--</option>
                           <option value="Male">Male</option>
                           <option value="Female">Female</option>
                           <option value="Other">Other</option>
                        </select>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Age <span class="required">*</span></label>
                        <input  required class="form-control col-md-6 col-xs-12" id="age" placeholder="Enter Age" min="10" name="age" type="number"/>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>



<div class="guest_section" id="existing_guest_section" style="display:none;">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Existing Guest List</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label">Guset</label>
                        <select class="form-control col-md-6 col-xs-12" name="selected_guest_id">
                           <option selected="selected" value="">--Select--</option>
                          <?php if(!empty($Allguests)) : 
                                  foreach($Allguests as $SingleGuest): ?>
                                    <option value="<?php echo $SingleGuest['id']; ?>"><?php echo $SingleGuest['fullname']; ?>(<?php echo $SingleGuest['mobile']; ?>)</option><?php
                                  endforeach; 
                                endif; ?>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>


      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>ID Card Information</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label">Type of Id <span class="required">*</span></label>
                        <select required class="form-control col-md-6 col-xs-12" name="idcard_type">
                           <option selected="selected" value="">--Select--</option>
                           <option value="1">Aadhar Card</option>
                           <option value="2">Driving License</option>
                           <option value="3">Passport</option>
                           <option value="4">Voter Id</option>
                        </select>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> ID No. <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="idcard_no" placeholder="Enter ID Number" name="idcard_no" type="text"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Upload ID Card <sup class="color-ff4">Multiple</sup> </label>
                        <input required class="form-control" id="idcard_image" multiple="" name="id_image[]" type="file"/>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Check In Information</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Check In <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12 datepicker" id="check_in_date" placeholder="Select Date" name="check_in_date" autocomplete="off" type="text"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12 hide_elem">
                        <label class="control-label"> Check Out <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12 datepicker" id="check_out_date" placeholder="Select Date" name="check_out_date" autocomplete="off" type="text"/>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Duration of Stay <span class="required">*</span></label>
                        <input required class="form-control col-md-6 col-xs-12" id="duration_of_stay" placeholder="Enter Number of Days/Night" min="1" name="duration_of_stay" type="number"/>
                     </div>
                     <?php 
                     if(isset($_REQUEST['id']) && $_REQUEST['id']!="") {
                        $result_room = $db->query('SELECT * FROM pm_room WHERE id='.$_REQUEST['id']); 
                        $result_room = $result_room->fetch();
                        if(!empty($result_room)) :
                        ?>
                             <input id="base_price" value="<?php echo $result_room['price'] ?>" name="per_room_price" type="hidden">
    
                             <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label"> Select Rooms<span class="required">*</span></label>
                                <table class="table table-striped table-bordered">
                                   <thead>
                                      <tr>
                                         <th>Title</th>
                                         <th>Room No.</th>
                                         <th>Price</th>
                                         <th>Status</th>
                                      </tr>
                                   </thead>
                                   <tbody id="rooms_list">
                                      <tr style="background:">
                                         <td> <?php echo $result_room['title'] ?></td>
                                         <td> <?php echo $result_room['id'] ?></td>
                                         <td> <?php echo $result_room['price'] ?></td>
                                         <td> <strong style="color:green">Available</strong></td>
                                      </tr>
                                   </tbody>
                                </table>
                             </div> <?php
                        endif; 
                     } ?>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                        <label class="control-label"> Adults <span class="required">*</span></label>
                        <input class="form-control col-md-7 col-xs-12" id="adult" required="required" placeholder="Enter Number of Adults" min="1" name="adult" type="number" value="1"/>
                     </div>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                        <label class="control-label"> Kids </label>
                        <input class="form-control col-md-7 col-xs-12" id="kids" required="required" placeholder="Enter Number of Kids" min="0" name="kids" type="number" value="0"/>
                     </div>

                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Reason of Visit/Stay <span class="required">*</span></label>
                        <textarea class="form-control h34 col-md-6 col-xs-12" id="reason_visit_stay" placeholder="Enter Reason" rows="1" name="reason_visit_stay" cols="50"></textarea>
                     </div>

                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Remark</label>
                        <textarea class="form-control h34 col-md-6 col-xs-12" id="remark" placeholder="Enter Remark" rows="1" name="remark" cols="50"></textarea>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
               <div class="x_title">
                  <h2>Payment Information</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                  <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-12">
                        <label class="control-label"> Advance Payment </label>
                        <input class="form-control col-md-7 col-xs-12" id="advance_payment" placeholder="Enter Advance Payment" min="0" name="advance_payment" type="number"/>
                     </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                     <input name="submit_booking" class="btn btn-success btn-submit-form" type="submit" value="Submit" />
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>
</div>

            <?php
        } else echo '<p>'.$texts['ACCESS_DENIED'].'</p>'; ?>
    </div>
    <script>
        $(".guest_type").change(function(){
            $(".guest_section").hide();
            var radioval = $(this).val();
            $("#"+radioval+"_guest_section").show(); 
        });
      $( function() {
        $( ".datepicker" ).datepicker({ minDate: 0});
      } );
    </script>

</body>
</html>
<?php
if(empty($_SESSION['msg_error'])) recursive_rmdir(SYSBASE.'medias/'.MODULE.'/tmp/'.$_SESSION['token']);
$_SESSION['redirect'] = false;
$_SESSION['msg_error'] = array();
$_SESSION['msg_success'] = array();
$_SESSION['msg_notice'] = array(); ?>
