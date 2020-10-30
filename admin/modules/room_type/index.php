<?php
define("ADMIN", true);
error_reporting(0);
require_once("../../../common/lib.php");
require_once("../../../common/define.php");
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

require_once("../../includes/fn_module.php"); ?>
<!DOCTYPE html>
<head>
    <?php include("../../includes/inc_header_common.php"); ?>
</head>
<body>
    <div id="wrapper">
   <?php include("../../includes/inc_top.php"); ?>
   <div id="page-wrapper">
      <div class="page-header">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12 clearfix">
                  <h1 class="pull-left">
                     <svg class="svg-inline--fa fa-thumbs-up fa-w-16 fa-fw" aria-hidden="true" data-fa-processed="" data-prefix="fas" data-icon="thumbs-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z"></path>
                     </svg>
                     <!-- <i class="fas fa-fw fa-thumbs-up"></i> --> Room Type
                  </h1>
                  <div class="pull-left text-right">
                     &nbsp;&nbsp;
                     <a href="index.php?view=form&amp;id=0" class="btn btn-primary mt15 mb15">
                        <svg class="svg-inline--fa fa-plus-circle fa-w-16 fa-fw" aria-hidden="true" data-fa-processed="" data-prefix="fas" data-icon="plus-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm144 276c0 6.6-5.4 12-12 12h-92v92c0 6.6-5.4 12-12 12h-56c-6.6 0-12-5.4-12-12v-92h-92c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h92v-92c0-6.6 5.4-12 12-12h56c6.6 0 12 5.4 12 12v92h92c6.6 0 12 5.4 12 12v56z"></path>
                        </svg>
                        <!-- <i class="fas fa-fw fa-plus-circle"></i> --> Add										
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="panel-body">
         <div class="table-responsive">
         	<?php 
         	$Room_types = $db->query('SELECT * FROM `pm_room_type`');
      $Room_types = $Room_types->fetch(); 

/*  echo '<pre>';
  print_r($Room_types);*/
      ?>

  <?php if(!empty($Room_types)) : ?>
 <table class="table table-hover table-striped" id="listing_base">
  <tr>
    <th>Id</th>
    <th>Room Type</th>
  </tr>
  <?php foreach($Room_types as $Room_type): 

  echo '<pre>';
  print_r($Room_type);
  	?>
  <tr>
    <td><?php //echo $Room_type->id; ?></td>
    <td><?php //echo $Room_type->name; ?></td>
  </tr>
  <?php  endforeach;  ?>
</table>
<?php endif; ?>
         </div>
      </div>
   </div>
</div>
</body>
</html>