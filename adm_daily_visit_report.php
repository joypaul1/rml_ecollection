<?php 
	session_start();
	
	if(!isset($_SESSION['id'],$_SESSION['user_role_id']))
	{
		header('location:index.php?lmsg=true');
		exit;
	}		
	require_once('inc/config.php');
	require_once('layouts/header.php'); 
	require_once('layouts/left_sidebar.php'); 
	require_once('inc/connoracle.php');
	
?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="">Monthly Visit Assign Summary</a>
        </li>
      </ol>
	  <div class="container-fluid">
			<div class="row">
				
				
				<div class="col-lg-12">
					<div class="md-form mt-2">
					 <div class="resume-item d-flex flex-column flex-md-row">
					 <table class="table table-striped table-bordered table-sm" id="table" cellspacing="0" width="100%">  
						<thead class="thead-dark">
								<tr>
								  <th scope="col"><center>Sl</center></th>
								  <th scope="col"><center>Concern</center></th>
								  <th scope="col"><center>Visit Assign Unit</center></th>
								  <th scope="col"><center>Non Visit Unit</center></th>
								  <th scope="col"><center>Visit Times</center></th>
								  <th scope="col"><center>Unique Visit</center></th>
								  <th scope="col"><center>EMI Unit(Physical)</center></th>
								  <th scope="col"><center>EMI Unit(Telephonic)</center></th>
								  <th scope="col"><center>Total</center></th>
								 
								</tr>
					   </thead>
					   
					   <tbody>

						<?php

						

			
			
			
			$strSQL = oci_parse($objConnect, 
					   "SELECT usr.RML_ID,
                        usr.EMP_NAME,
                        COLL_VISIT_UNIT(usr.RML_ID,'01/03/2020','31/03/2020') VISIT_ASSIGN_UNIT,
                         COLL_VISIT_ASIGN_NUMBER(usr.RML_ID,(SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),
                         (SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL)) TOTAL_VISIT_ASSIGN_NO,
						  COLL_EMI_VISIT_TOTAL(USR.ID,TO_DATE((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy'),TO_DATE((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy')) TELEPHONIC_EMI_UNIT,
                       ( SELECT COUNT(a.ID)  
                                 FROM RML_COLL_VISIT_ASSIGN b,RML_COLL_MONEY_COLLECTION a
                                    WHERE a.RML_COLL_APPS_USER_ID=usr.ID
                                    AND a.REF_ID=B.REF_ID
                                    AND TRUNC(a.CREATED_DATE) BETWEEN TO_DATE((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy') AND TO_DATE((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy')
                                    AND TRUNC(b.ASSIGN_DATE) BETWEEN TO_DATE((SELECT TO_CHAR (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy') AND TO_DATE((SELECT TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE)- (TO_NUMBER (TO_CHAR (SYSDATE, 'DD')) - 1),1)- 1,'dd/mm/yyyy')FROM DUAL),'dd/mm/yyyy')) PHYSICAL_EMI_VISIT
                            FROM RML_COLL_APPS_USER usr
                        where usr.ACCESS_APP='RML_COLL'
                        and usr.RML_ID NOT IN('001','002','956','955') 
                        and usr.LEASE_USER='CC'
                        and usr.IS_ACTIVE=1
                            ORDER BY AREA_ZONE");  
																

						  @oci_execute(@$strSQL);
						  $number=0;
						  $GRANT_TOTAL_VISIT_ASSIGN_UNIT=0;
						  $GRANT_TOTAL_NON_VISIT_ASSIGN_UNIT=0;
						  $GRANT_TOTAL_VISIT_TIMES_UNIT=0;
						  $GRANT_TOTAL_UNIQUE_VISIT_UNIT=0;
						  
						  $PHYSICAL_TOTAL_EMI_UNIT=0;
						  $TELEPHONIC_TOTAL_EMI_UNIT=0;
							
		                  while($row=@oci_fetch_assoc(@$strSQL)){	
						   $number++;
						   $VISIT_ASSIGN_UNIT=$row['VISIT_ASSIGN_UNIT'] ;
						   $GRANT_TOTAL_VISIT_ASSIGN_UNIT=$GRANT_TOTAL_VISIT_ASSIGN_UNIT+$VISIT_ASSIGN_UNIT;
						   
						   
						   $TOTAL_UNIQUE_VISIT=explode(',', $row['TOTAL_VISIT_ASSIGN_NO'])[0];
						   $TOTAL_VISIT_TIMES=explode(',', $row['TOTAL_VISIT_ASSIGN_NO'])[1];
						   $GRANT_TOTAL_NON_VISIT_ASSIGN_UNIT=$GRANT_TOTAL_NON_VISIT_ASSIGN_UNIT+($VISIT_ASSIGN_UNIT-$TOTAL_UNIQUE_VISIT);
						   $GRANT_TOTAL_VISIT_TIMES_UNIT=$GRANT_TOTAL_VISIT_TIMES_UNIT+$TOTAL_VISIT_TIMES;
						   $GRANT_TOTAL_UNIQUE_VISIT_UNIT=$GRANT_TOTAL_UNIQUE_VISIT_UNIT+$TOTAL_UNIQUE_VISIT;
						   
						   $PHYSICAL_EMI_UNIT=$row['PHYSICAL_EMI_VISIT'] ;
						   $PHYSICAL_TOTAL_EMI_UNIT=$PHYSICAL_TOTAL_EMI_UNIT+$PHYSICAL_EMI_UNIT;
						   
						   $TELEPHONIC_EMI_UNIT=$row['TELEPHONIC_EMI_UNIT'] ;
						   $TELEPHONIC_TOTAL_EMI_UNIT=$TELEPHONIC_TOTAL_EMI_UNIT+$TELEPHONIC_EMI_UNIT;
                           ?>
						   <tr>
							  <td align="center"><?php echo $number;?></td> 
							  <td><?php echo $row['EMP_NAME'];?></td>
							  <td align="center"><?php echo $VISIT_ASSIGN_UNIT;?></td>
							  <td align="center"><?php echo $VISIT_ASSIGN_UNIT-$TOTAL_UNIQUE_VISIT;?></td>
							  <td align="center"><?php echo $TOTAL_VISIT_TIMES; ?></td>
							  <td align="center"><?php echo $TOTAL_UNIQUE_VISIT ?></td>
							  <td align="center"><?php echo $PHYSICAL_EMI_UNIT;?></td>
							  <td align="center"><?php echo $TELEPHONIC_EMI_UNIT;?></td>
							  <td align="center"><?php echo $VISIT_ASSIGN_UNIT;?></td>
							 
							  
							  
						  </tr>
						 <?php
						  }
						  ?>
						   <tr>
						      <td align="center"></td> 
							  
							  <td align="center">Grand Total:</td>
							  <td align="center"><?php echo $GRANT_TOTAL_VISIT_ASSIGN_UNIT;?></td>
							  <td align="center"><?php echo $GRANT_TOTAL_NON_VISIT_ASSIGN_UNIT;?></td>
							  <td align="center"><?php echo $GRANT_TOTAL_VISIT_TIMES_UNIT;?></td>
							  <td align="center"><?php echo $GRANT_TOTAL_UNIQUE_VISIT_UNIT;?></td>
							  <td align="center"><?php echo $PHYSICAL_TOTAL_EMI_UNIT;?></td>
							  <td align="center"><?php echo $TELEPHONIC_TOTAL_EMI_UNIT;?></td>
							  <td align="center"><?php echo $GRANT_TOTAL_VISIT_ASSIGN_UNIT;?></td>
						 </tr>
						 
					</tbody>	
				 
		              </table>
					</div>
					<div>
					
					
					<a class="btn btn-success subbtn" id="downloadLink" onclick="exportF(this)" style="margin-left:5px;">Export to excel</a>
					</div>
				  </div>
				</div>
			</div>
		</div>
	  

      <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

	<script>
	function exportF(elem) {
		  var table = document.getElementById("table");
		  var html = table.outerHTML;
		  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
		  elem.setAttribute("href", url);
		  elem.setAttribute("download", "Collection_Report.xls"); // Choose the file name
		  return false;
		}
	</script>
<?php require_once('layouts/footer.php'); ?>	