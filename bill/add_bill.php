<?php

include('../header.php');
include('../utility/common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_bill.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$bill_type = '';
$bill_date = '';
$bill_month = '';
$bill_year = '';
$total_amount = '';
$deposit_bank_name = '';
$bill_details = '';
$branch_id = '';
$title = $_data['text_1'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['text_15'];
$form_url = WEB_URL . "bill/add_bill.php";
$id="";
$hdnid="0";

if(isset($_POST['ddlBillType'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
		$sql = "INSERT INTO tbl_add_bill(bill_type,bill_date,bill_month,bill_year,total_amount,deposit_bank_name,bill_details,branch_id) values('$_POST[ddlBillType]','$_POST[txtBillDate]','$_POST[ddlBillMonth]','$_POST[ddlBillYear]','$_POST[txtTotalAmount]','$_POST[txtDepositBankName]','$_POST[txtBillDetails]','" . $_SESSION['objLogin']['branch_id'] . "')";
		mysqli_query($link,$sql);
		//mysql_close($link);
		$url = WEB_URL . 'bill/bill_list.php?m=add';
		header("Location: $url");
		
	}
	else{
		$sql = "UPDATE `tbl_add_bill` SET `bill_type`='".$_POST['ddlBillType']."',`bill_date`='".$_POST['txtBillDate']."',`bill_month`='".$_POST['ddlBillMonth']."',`bill_year`='".$_POST['ddlBillYear']."',`total_amount`='".$_POST['txtTotalAmount']."',`deposit_bank_name`='".$_POST['txtDepositBankName']."',`bill_details`='".$_POST['txtBillDetails']."' WHERE bill_id='".$_GET['id']."'";
		mysqli_query($link,$sql);
		//mysql_close($link);
		$url = WEB_URL . 'bill/bill_list.php?m=up';
		header("Location: $url");
	}

	$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($link,"SELECT * FROM tbl_add_bill where bill_id = '" . $_GET['id'] . "'");
	while($row = mysqli_fetch_array($result)){
		$bill_type = $row['bill_type'];
		$bill_date = $row['bill_date'];
		$bill_month = $row['bill_month'];
		$bill_year = $row['bill_year'];
		$total_amount = $row['total_amount'];
		$deposit_bank_name = $row['deposit_bank_name'];
		$bill_details = $row['bill_details'];
		$hdnid = $_GET['id'];
		$title = $_data['text_1_1'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['text_16'];
		$form_url = WEB_URL . "bill/add_bill.php?id=".$_GET['id'];
	}
	
	//mysql_close($link);

}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['text_2'];?></li>
    <li class="active"><?php echo $_data['text_3'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>bill/bill_list.php" data-original-title="<?php echo $_data['back_text'];?>"><i class="fa fa-reply"></i></a> </div>
    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['text_4'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label for="ddlBillType"><span class="errorStar">*</span><?php echo $_data['text_5'];?> :</label>
            <select name="ddlBillType" id="ddlBillType" class="form-control">
              <option value="">--<?php echo $_data['text_6'];?>--</option>
              <?php 
				  	$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_bill_type order by bt_id ASC");
					while($row_unit = mysqli_fetch_array($result_unit)){?>
              <option <?php if($bill_type == $row_unit['bt_id']){echo 'selected';}?> value="<?php echo $row_unit['bt_id'];?>"><?php echo $row_unit['bill_type'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="txtBillDate"><span class="errorStar">*</span><?php echo $_data['text_7'];?> :</label>
            <input type="text" name="txtBillDate" value="<?php echo $bill_date;?>" id="txtBillDate" class="form-control datepicker"/>
          </div>
          <div class="form-group">
            <label for="ddlBillMonth"><span class="errorStar">*</span><?php echo $_data['text_8'];?> :</label>
            <select name="ddlBillMonth" id="ddlBillMonth" class="form-control">
              <option value="">--<?php echo $_data['text_9'];?>--</option>
              <?php 
				  	$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_month_setup order by m_id ASC");
					while($row_unit = mysqli_fetch_array($result_unit)){?>
              <option <?php if($bill_month == $row_unit['m_id']){echo 'selected';}?> value="<?php echo $row_unit['m_id'];?>"><?php echo $row_unit['month_name'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="ddlBillYear"><span class="errorStar">*</span><?php echo $_data['text_10'];?> :</label>
            <select name="ddlBillYear" id="ddlBillYear" class="form-control">
              <option value="">--<?php echo $_data['text_11'];?>--</option>
              <?php 
				  	$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_year_setup order by y_id ASC");
					while($row_unit = mysqli_fetch_array($result_unit)){?>
              <option <?php if($bill_year == $row_unit['y_id']){echo 'selected';}?> value="<?php echo $row_unit['y_id'];?>"><?php echo $row_unit['xyear'];?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label for="txtTotalAmount"><span class="errorStar">*</span><?php echo $_data['text_12'];?> :</label>
            <div class="input-group">
              <input type="text" name="txtTotalAmount" value="<?php echo $total_amount;?>" id="txtTotalAmount" class="form-control"/>
              <div class="input-group-addon"><?php echo CURRENCY;?></div>
            </div>
          </div>
          <div class="form-group">
            <label for="txtDepositBankName"><span class="errorStar">*</span><?php echo $_data['text_13'];?> :</label>
            <input type="text" name="txtDepositBankName" value="<?php echo $deposit_bank_name;?>" id="txtDepositBankName" class="form-control"/>
          </div>
          <div class="form-group">
            <label for="txtBillDetails"><span class="errorStar">*</span><?php echo $_data['text_14'];?> :</label>
            <textarea name="txtBillDetails" id="txtBillDetails" class="form-control"><?php echo $bill_details;?></textarea>
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
<script type="text/javascript">
function validateMe(){
	if($("#ddlBillType").val() == ''){
		alert("Bill Type Required !!!");
		$("#ddlBillType").focus();
		return false;
	}
	else if($("#txtBillDate").val() == ''){
		alert("Date is Required !!!");
		$("#txtBillDate").focus();
		return false;
	}
	else if($("#ddlBillMonth").val() == ''){
		alert("Bill Month is Required !!!");
		$("#ddlBillMonth").focus();
		return false;
	}
	else if($("#ddlBillYear").val() == ''){
		alert("Bill Year is Required !!!");
		$("#ddlBillYear").focus();
		return false;
	}
	else if($("#txtTotalAmount").val() == ''){
		alert("Total is Required !!!");
		$("#txtTotalAmount").focus();
		return false;
	}
	else if($("#txtDepositBankName").val() == ''){
		alert("Bank Name is Required !!!");
		$("#txtDepositBankName").focus();
		return false;
	}
	else if($("#txtBillDetails").val() == ''){
		alert("Bill Details Required !!!");
		$("#txtBillDetails").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
