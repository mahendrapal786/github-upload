<!DOCTYPE html>
<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=demo", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  /*echo "Connected successfully";*/
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
<?php
/*$query = "SELECT * FROM team";
if(isset($_POST['submit']) && (trim($_POST['specialties'])!='') && (trim($_POST['specialties'])!='ALL')) {
$query.= " WHERE specialties_en='".trim($_POST['specialties'])."'";
 }*/
 if(isset($_POST['submit']))
 {
  $room_type=$_POST['room_type'];
 $price=$_POST['price'];

 $price_arr=explode("-",$price);

 $price_start=$price_arr[0];
 $price_end=$price_arr[1]; 
  
 if(isset($room_type) && $room_type==0)
  {
  $sql = "SELECT pm_room.title,pm_room.price,pm_room_type.name FROM pm_room INNER JOIN pm_room_meta  ON pm_room.id=pm_room_meta.room_id INNER JOIN pm_room_type  ON pm_room_type.id = pm_room_meta.room_type_id";
  }
  else if(isset($room_type) && $room_type!=0)
  {
    $sql = "SELECT pm_room.title,pm_room.price,pm_room_type.name FROM pm_room INNER JOIN pm_room_meta  ON pm_room.id=pm_room_meta.room_id INNER JOIN pm_room_type  ON pm_room_type.id = pm_room_meta.room_type_id WHERE pm_room_type.id='".$room_type."'";
  }


  $room_lists=$conn->query($sql);
  if(!empty($room_lists)) :

    while( $room_list = $room_lists->fetch(PDO::FETCH_OBJ) ){ 

 echo '<div class="room_list">'.$room_list->title.' '.$room_list->price.'</div>';
 echo '<br>';
 echo '<hr>';
}

  endif;


 }
 else {
  $Rooms = $conn->query('SELECT * FROM `pm_room`');
        if(!empty($Rooms)) :
while( $room = $Rooms->fetch(PDO::FETCH_OBJ) ){ 

 echo '<div class="room">'.$room->title.' '.$room->price.'</div>';
 echo '<br>';
 echo '<hr>';
}
endif;

 }
 ?>
 <?php echo '-----------------Below Search form area-------------------'; ?>
<form id="form-filter" name="search" method="post">
              <div class="form-group col-md-2">
              <label>Room Type</label>               
                <select class="form-control select select2-hidden-accessible" style="width: 100%;" name="room_type" tabindex="-1" aria-hidden="true">
                 <?php  $Room_types = $conn->query('SELECT * FROM `pm_room_type`');
        if(!empty($Room_types)) :
          echo '<option value="0">ALL</option>';
        while( $room_type = $Room_types->fetch(PDO::FETCH_OBJ) ){ ?>
                  <option value="<?php echo $room_type->id; ?>"><?php echo $room_type->name; ?></option>

                <?php   } 
              endif; ?>
                 </select>
                <span class="select2 select2-container select2-container--default select2-container--focus" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-floor-1c-container"><span class="select2-selection__rendered" id="select2-floor-1c-container" title="All">All</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
              </div>
              
          <div class="form-group col-md-2">
           <label>Price Range</label>
                <select class="form-control select select2-hidden-accessible" name="price" style="width: 100%;" tabindex="-1" aria-hidden="true">                
                 <option value="0-10000">All</option>
                  <option value="0-3000">Under 3000</option>
                  <option value="3000-5000">3000-5000</option>
                  <option value="5000-10000">5000-10000</option>
                  
                </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-price-ao-container"><span class="select2-selection__rendered" id="select2-price-ao-container" title="All">All</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
              </div>        
              <div class="form-group col-md-2">
                <label>Check in:</label>
                <div class="input-group">                  
                  <input type="text" name="checkinDate" value="" class="form-control pull-right">
                </div>
              </div>
              <div class="form-group col-md-2">
                <label>Check out:</label>
                <div class="input-group">                  
                  <input type="text" name="checkoutDate" value="" class="form-control pull-right">
                </div>
              </div>              
        <div class="form-group col-md-2">
       <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="input-group">                  
                  <input type="submit" name="submit" class="form-control" value="Search">
                </div>
              </div>
      </form>
</body>
</html>