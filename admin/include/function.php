<?php
require_once('constant.php');
class query_function{
// Select Function

function login_data($table_name,$field_name,$data_value,$_connection){

	$output = array();


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
	$output = array();
		$fetch_all_query =  "SELECT * FROM $table_name WHERE $where_field = '".$where_data."'";
	$fetch_all_result = mysqli_query($_connection,$fetch_all_query) or die("Query Error");

	if($fetch_all_row = mysqli_fetch_assoc($fetch_all_result)){ 

		$output['success'] = 1;
		$output['output'] = $fetch_all_row;
		return $output;
	}	
	else{
		return $output['success'] = 0; 
	}
}

function update_data($table_name,$set_array,$where_field,$where_data,$_connection){
	$output = array();
	$set = "";
	$x=1;
	foreach($set_array as $key=>$value){
                $set .= "{$key} = \"{$value}\"";
                if($x < count($set_array)){
                    $set .= ',';
                }
               $x++;
            }
	$output = array();
	$update_query = "UPDATE $table_name SET $set WHERE $where_field = '$where_data'";
	// echo $update_query; exit;
	$update_result = mysqli_query($_connection,$update_query) or die('Query Error');
		if($update_result){
			return $output['success'] = 1;
		}
		else{
			return $output['success'] = 0;	
		}	
}

function delete_data($table_name,$where_field,$where_data,$_connection){
	$output = array();
	$delete_query = "DELETE FROM $table_name WHERE $where_field = '".$where_data."'";
	$delete_result =  mysqli_query($_connection,$delete_query);
	if($delete_result){
		return $output['success'] =1;
	}
	else{
		return $output['success'] = 0;
	}
}

function insert_data($table_name,$set_array,$_connection){
	$output = array();
	$field = $data = "";
	$x =1;
	foreach($set_array as $key=>$value){
                $field .= $key;
                $data .= "'".$value."'";
                if($x < count($_POST)) {
                    $field .= ',';
                    $data .= ',';
                }
                $x++;
            }
	$output = array();
	$insert_query = "INSERT INTO $table_name($field,admin_id,created_by) VALUES ($data,'".$_SESSION['admin_credential']['admin_id']."','".$_SESSION['admin_credential']['admin_id']."')" ;
	$insert_result = mysqli_query($_connection,$insert_query) or die('Query Error');
	if($insert_result){
		return $output['success'] =1;
	}
	else{
		return $output['success'] =0;
	}
}


}
?>
