<?php

$output = array();
// Select Function

function login_data($table_name,$field_name,$data_value,$_connection){


	$login_data_query = "SELECT * FROM $table_name WHERE $field_name[0] = '".$data_value[0]."' and $field_name[1] = '".$data_value[1]."'";
	$login_data_result = mysqli_query($_connection,$login_data_query);

	
	if($login_data_row = mysqli_fetch_assoc($login_data_result)){ 
		$output['success'] = 1;
		$output['output'] = $login_data_row;
		return $output;
	}	
	else{
		return $output['success'] = 0; 
	}
	
}


function get_data($table_name,$where_field,$where_data,$_connection){

	$fetch_all_query =  "SELECT * FROM $table_name WHERE $where_field = '".$where_data."'";
	$fetch_all_result = mysqli_query($_connection,$fetch_all_query);

	if($fetch_all_row = mysqli_fetch_assoc($fetch_all_result)){ 

		$output['success'] = 1;
		$output['output'] = $fetch_all_row;
		return $output;
	}	
	else{
		return $output['success'] = 0; 
	}
}

function update_data($table_name,$set,$where_field,$where_data,$_connection){
		$update_query = "UPDATE $table_name SET $set WHERE $where_field = '$where_data'";
		$update_result = mysqli_query($_connection,$update_query);
		if($update_result){
			return $output['success'] = 1;
		}
		else{
			return $output['success'] = 0;	
		}	
}

function delete_data($table_name,$where_field,$where_data,$_connection){
	$delete_query = "DELETE FROM $table_name WHERE $where_field = '".$where_data."'";
	$delete_result =  mysqli_query($_connection,$delete_query);
	if($delete_result){
		return $output['success'] =1;
	}
	else{
		return $output['success'] = 0;
	}
}

function insert_data($table_name,$field,$data,$_connection){
	$insert_query = "INSERT INTO $table_name($field,admin_id,created_by) VALUES ($data,'".$_SESSION['admin_credential']['admin_id']."','".$_SESSION['admin_credential']['admin_id']."')" ;
	$insert_result = mysqli_query($_connection,$insert_query);
	if($insert_result){
		return $output['success'] =1;
	}
	else{
		return $output['success'] =0;
	}
}



?>
