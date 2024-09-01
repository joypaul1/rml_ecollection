<?php
require_once('inc/connoracle.php');
if (!empty($_GET['zonal_head_id'])) {

    $v_zonal_head_id=$_GET['zonal_head_id'];

    $strSQL  = oci_parse($objConnect, 
	               "select RML_ID,CONCERN from MONTLY_COLLECTION
					where is_active=1
					and ZONAL_HEAD='$v_zonal_head_id'
					AND RML_ID NOT IN('$v_zonal_head_id')");
	oci_execute($strSQL);
	echo '<select name="concern_cc" id="emp_id" class="form-control" required="">';
	echo '<option selected value="">Select Concern</option>';
 	while($row=oci_fetch_assoc($strSQL)){	
		echo "<option value=".$row['RML_ID'].">".$row['CONCERN']."</option>";
		
       }							  
    echo "</select>";
}
?>
