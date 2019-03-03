<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_owner_utility.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$type = 'Owner';
$floor_no = '';
$unit_no = '';
$month_id = '';
$xyear = date('Y');
$rent = '0.00';
$water_bill = '0.00';
$electric_bill = '0.00';
$gas_bill = '0.00';
$security_bill = '0.00';
$utility_bill = '0.00';
$other_bill = '0.00';
$total_rent = '0.00';
$issue_date = '';
$branch_id = '';
$title = $_data['add_new_owner_utility_title'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['added_owner_utility_successfully'];
$form_url = WEB_URL . "owner_utility/add_owner_utility.php";
$id="";
$hdnid="0";

//
$owner_name = '';
$ownid = 0;
//

if(isset($_POST['ddlFloorNo'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){

	$sql = "INSERT INTO tbl_add_fair(type,floor_no,unit_no,rid,month_id,xyear,water_bill,electric_bill,gas_bill,security_bill,utility_bill,other_bill,total_rent,issue_date,branch_id) values('$type','$_POST[ddlFloorNo]','$_POST[ddlUnitNo]','$_POST[hdnOwnerdId]','$_POST[ddlMonth]','$xyear','$_POST[txtWaterBill]','$_POST[txtElectricBill]','$_POST[txtGasBill]','$_POST[txtSecurityBill]','$_POST[txtUtilityBill]','$_POST[txtOtherBill]','$_POST[txtTotalRent]','$_POST[txtIssueDate]','" . $_SESSION['objLogin']['branch_id'] . "')";
	mysqli_query($link,$sql);
	mysqli_close($link);
	$url = WEB_URL . 'owner_utility/owner_utility_list.php?m=add';
	header("Location: $url");
	
}
else{
	
	$sql = "UPDATE `tbl_add_fair` SET `floor_no`='".$_POST['ddlFloorNo']."',`unit_no`='".$_POST['ddlUnitNo']."',`rid`='".$_POST['hdnOwnerdId']."',`month_id`='".$_POST['ddlMonth']."',`water_bill`='".$_POST['txtWaterBill']."',`electric_bill`='".$_POST['txtElectricBill']."',`gas_bill`='".$_POST['txtGasBill']."',`security_bill`='".$_POST['txtSecurityBill']."',`utility_bill`='".$_POST['txtUtilityBill']."',`other_bill`='".$_POST['txtOtherBill']."',`total_rent`='".$_POST['txtTotalRent']."',`issue_date`='".$_POST['txtIssueDate']."' WHERE f_id='".$_GET['id']."'";
	mysqli_query($link,$sql);
	$url = WEB_URL . 'owner_utility/owner_utility_list.php?m=up';
	header("Location: $url");
}

$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($link,"SELECT *,o.o_name,o.ownid FROM tbl_add_fair af inner join tbl_add_owner o on o.ownid = af.rid where af.f_id = '" . $_GET['id'] . "' and af.type='Owner'");
	while($row = mysqli_fetch_array($result)){
	
		$floor_no = $row['floor_no'];
		$unit_no = $row['unit_no'];
		$month_id = $row['month_id'];
		$water_bill = $row['water_bill'];
		$electric_bill = $row['electric_bill'];
		$gas_bill = $row['gas_bill'];
		$security_bill = $row['security_bill'];
		$utility_bill = $row['utility_bill'];
		$other_bill = $row['other_bill'];
		$total_rent = $row['total_rent'];
		$issue_date = $row['issue_date'];
		$hdnid = $_GET['id'];
		$owner_name = $row['o_name'];
		$ownid = $row['ownid'];
		$title = $_data['update_owner_utility'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_owner_utility_successfully'];
		$form_url = WEB_URL . "owner_utility/add_owner_utility.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);
}
else{
	//
	$total_rent = (float)$gas_bill + (float)$security_bill;
	$total_rent = number_format($total_rent, 2, '.', ' ');
}
//	
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['owner_utility'];?></li>
    <li class="active"><?php echo $_data['add_owner_utility'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>owner_utility/owner_utility_list.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_owner_utility_entry_form'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
        <div class="form-group">
            <label for="ddlFloorNo"><?php echo $_data['add_new_form_field_text_1'];?> :</label>
            <select onchange="getActiveUnit(this.value)" name="ddlFloorNo" id="ddlFloorNo" class="form-control">
              <option value="">--<?php echo $_data['add_new_form_field_text_2'];?>--</option>
              <?php 
				  	$result_floor = mysqli_query($link,"SELECT * FROM tbl_add_floor order by fid ASC");
					while($row_floor = mysqli_fetch_array($result_floor)){?>
              <option <?php if($floor_no == $row_floor['fid']){echo 'selected';}?> value="<?php echo $row_floor['fid'];?>"><?php echo $row_floor['floor_no'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlUnitNo"><?php echo $_data['add_new_form_field_text_3'];?> :</label>
            <select name="ddlUnitNo" id="ddlUnitNo" onchange="getOwnerInfo(this.value);" class="form-control">
              <option value="">--<?php echo $_data['add_new_form_field_text_4'];?>--</option>
              <?php 
				  	$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_unit where floor_no = '".(int)$floor_no."' order by uid ASC");
					while($row_unit = mysqli_fetch_array($result_unit)){?>
              <option <?php if($unit_no == $row_unit['uid']){echo 'selected';}?> value="<?php echo $row_unit['uid'];?>"><?php echo $row_unit['unit_no'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="txtOwnerName"><?php echo $_data['add_new_form_field_text_6'];?> :</label>
            <input readonly="readonly" type="text" name="txtOwnerName" style="font-weight:bold;color:red;" value="<?php echo $owner_name;?>" id="txtOwnerName" class="form-control" />
            <input type="hidden" id="hdnOwnerdId" name="hdnOwnerdId" value="<?php echo $ownid;?>" />
          </div>
           <div class="form-group">
            <label for="ddlMonth"><?php echo $_data['add_new_form_field_text_5'];?> :</label>
            <select name="ddlMonth" id="ddlMonth" class="form-control">
              <option value="">--<?php echo $_data['add_new_form_field_text_5'];?>--</option>
              <?php 
				  	$result_month = mysqli_query($link,"SELECT * FROM tbl_add_month_setup order by m_id ASC");
					while($row_month = mysqli_fetch_array($result_month)){?>
              <option <?php if($month_id == $row_month['m_id']){echo 'selected';}?> value="<?php echo $row_month['m_id'];?>"><?php echo $row_month['month_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="txtWaterBill"><?php echo $_data['add_new_form_field_text_8'];?> :</label>
            <div class="input-group">
            <input type="text" name="txtWaterBill" onkeyup="calculateFairTotal1();" value="<?php echo $water_bill;?>" id="txtWaterBill" class="form-control" />
            <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtElectricBill"><?php echo $_data['add_new_form_field_text_9'];?> :</label>
            <div class="input-group">
            <input type="text" name="txtElectricBill" onkeyup="calculateFairTotal1();" value="<?php echo $electric_bill;?>" id="txtElectricBill" class="form-control" />
            <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtGasBill"><?php echo $_data['add_new_form_field_text_10'];?> :</label>
            <div class="input-group">
            <input type="hidden" id="hdnGasBill" name="hdnGasBill" value="<?php echo $gas_bill;?>" />
            <input type="text" name="txtGasBill" onkeyup="calculateFairTotal1();" value="<?php echo $gas_bill;?>" id="txtGasBill" class="form-control" />
            <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
           <div class="form-group">
            <label for="txtSecurityBill"><?php echo $_data['add_new_form_field_text_11'];?> :</label>
            <div class="input-group">
            <input type="hidden" id="hdnSecurityBill" name="hdnSecurityBill" value="<?php echo $security_bill;?>" />
            <input type="text" name="txtSecurityBill" onkeyup="calculateFairTotal1();" value="<?php echo $security_bill;?>" id="txtSecurityBill" class="form-control" />
            <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
           <div class="form-group">
            <label for="txtUtilityBill"><?php echo $_data['add_new_form_field_text_12'];?> :</label>
            <div class="input-group">
            <input type="text" name="txtUtilityBill" onkeyup="calculateFairTotal1();" value="<?php echo $utility_bill;?>" id="txtUtilityBill" class="form-control" />
            <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
           <div class="form-group">
            <label for="txtOtherBill"><?php echo $_data['add_new_form_field_text_13'];?> :</label>
            <div class="input-group">
            <input type="text" name="txtOtherBill" onkeyup="calculateFairTotal1();" value="<?php echo $other_bill;?>" id="txtOtherBill" class="form-control" />
            <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtTotalRent"><?php echo $_data['add_new_form_field_text_14'];?> :</label>
            <div class="input-group">
              <input type="hidden" id="hdnTotal" name="hdnTotal" value="0.00" />
              <input type="text" readonly="readonly" name="txtTotalRent" value="<?php echo $total_rent;?>" id="txtTotalRent" class="form-control" />
              <div class="input-group-addon"> <?php echo CURRENCY;?> </div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtIssueDate"><?php echo $_data['add_new_form_field_text_15'];?> :</label>
            <input type="text" name="txtIssueDate" value="<?php echo $issue_date;?>" id="txtIssueDate" class="form-control datepicker"/>
          </div>
          <div class="form-group pull-right">
            <input type="submit" name="submit" class="btn btn-primary" value="<?php echo $button_text; ?>"/>
          </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
