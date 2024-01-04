<?php

function calculateExpense($type){
	global $con;
	$today=date('Y-m-d');
	if($type=='today'){
		$sub_sql=" and expense_date='$today'";
		$from=$today;
		$to=$today;
	}
	elseif($type=='yesterday'){
		$yesterday=date('Y-m-d',strtotime('yesterday'));
		$sub_sql=" and expense_date='$yesterday'";
		$from=$yesterday;
		$to=$yesterday;
	}elseif($type=='week' || $type=='month' || $type=='year'){
		$from=date('Y-m-d',strtotime("-1 $type"));
		$sub_sql=" and expense_date between '$from' and '$today'";
		$to=$today;
	}else{
		$sub_sql=" ";
		$from='';
		$to='';
	}
	
	$result=mysqli_query($con,"select sum(price) as price from expense where user_id='".$_SESSION['UID']."' $sub_sql");
	
	$row=mysqli_fetch_assoc($result);
	$p=0;
	$link="";
	if($row['price']>0){
		$p=$row['price'];
		$link="&nbsp;<a href='dashboard_report.php?from=".$from."&to=".$to."' target='_blank' class='detail_link'>Details</a>";
	}
	
	return $p;	
}

function getBudgetAmount(){
	global $con;
	$budresult=mysqli_query($con,"SELECT amount FROM budget WHERE user_id='".$_SESSION['UID']."'");
	$row=mysqli_fetch_assoc($budresult);
	$b=0;
	if($row['amount']>0){
		$b=$row['amount'];
	}
	
	return $b;	
}

function checkUser(){
	if(isset($_SESSION['UID']) && $_SESSION['UID']!=''){
	
		
	}else{
		header("Location: index.php");
	}
}


function userArea(){
	if($_SESSION['ROLEID']!=2){
		header("Location: category.php");
	}
}

function checkvalue($data){
    global $con;
    if(isset($data) && !empty($data)){
        return mysqli_real_escape_string($con, $data);
    }
    return ''; 
}



?>