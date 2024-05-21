<?php
include_once('../_helper/com_conn.php');


$v_rml_id = $_REQUEST['concern_id'];
$v_login_id = 0;


$v_start_date = $_REQUEST['start_date'];
$v_end_date   = $_REQUEST['end_date'];
$v_what_want  = $_REQUEST['want'];
$len          = strlen($_REQUEST['concern_id']);

if ($len == 1) {
    $v_login_id = '00000' . $v_rml_id;
} else if ($len == 2) {
    $v_login_id = '0000' . $v_rml_id;
} else if ($len == 3) {
    $v_login_id = '000' . $v_rml_id;
} else if ($len == 4) {
    $v_login_id = '00' . $v_rml_id;
} else if ($len == 5) {
    $v_login_id = '0' . $v_rml_id;
}

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">


            <div class="card rounded-4">
                <div class="card-header p-3 rounded-4 bg-gradient-info text-white fw-bold text-center">

                    <?php
                    if ($v_what_want == 'TOTAL_CODE') {
                        $summaryTitle = 'ERP Code Assign Summary';
                    } else if ($v_what_want == 'TOTAL_CODE_ON_ROAD') {
                        $summaryTitle = 'ERP Code Assign Summary[On Road]';
                    }else{
						$summaryTitle = 'Code Summary';
					}
                    $arrowIcon = "<i class='bx bxs-arrow-from-left'></i>";

                    echo '<div class="summary">';
                    echo '<strong>' . $summaryTitle . '</strong>';
                    echo '<br>';
                    echo $arrowIcon . 'Start Date: ' . $v_start_date;
                    echo '<br>';
                    echo $arrowIcon . 'End Date: ' . $v_end_date;
                    echo '<br>';
                    echo $arrowIcon . 'Concern ID: ' . $v_rml_id;
                    echo '</div>';
                    ?>

                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle mb-0 ">
                            <thead class="table-cust text-uppercase text-center">
                                <tr>
                                    <th>SL.</th>
                                    <th>Code Information </th>
                                    <th>Payment Information</th>
                                    <th>Visited Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                               
                                //query statement 
                                if ($v_what_want == 'TOTAL_CODE') {
                                    $query  = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN,
											 LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE
                                        FROM LEASE_ALL_INFO_ERP A
                                            WHERE A.COLL_CONCERN_ID ='$v_login_id'
                                            AND A.STATUS='Y'
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
                                            AND A.PAMTMODE='CRT'
                                            ORDER BY A.NUMBER_OF_DUE DESC";	
								//echo $query;
                                } else if ($v_what_want == 'TOTAL_CODE_ON_ROAD') {
									
									 $query="SELECT B.REF_CODE,
									               (select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
												   A.CUSTOMER_NAME,
												   A.PARTY_ADDRESS,
												   A.LAST_PAYMENT_AMOUNT,
												   A.CUSTOMER_MOBILE_NO,
												   A.NUMBER_OF_DUE,
												   A.LAST_PAYMENT_DATE,
												   A.COLL_CONCERN_ID,
												    LAST_VISIT_DATE(B.REF_CODE) LAST_VISIT_DATE,
                                                   (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )
											       TOTAL_VISITED,
											       (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )TOTAL_VISIT_ASSIGN											   
												FROM ACTIVE_REASON_CODE B,LEASE_ALL_INFO_ERP A
												 WHERE A.REF_CODE=B.REF_CODE
												 AND A.STATUS='Y'
												 --AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
												 AND A.COLL_CONCERN_ID='$v_login_id'
												 AND A.PAMTMODE='CRT'
												 AND  B.REASON_CODE='On Road'";			
                                }else if ($v_what_want == 'TOTAL_CODE_OTHERS') {
									
									 $query="SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											 LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
                                        FROM LEASE_ALL_INFO_ERP A
                                            WHERE A.COLL_CONCERN_ID ='$v_login_id'
                                            AND A.STATUS='Y'
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
                                            AND A.PAMTMODE='CRT'
											 AND A.REF_CODE NOT IN( 
											                  SELECT P.REF_CODE
															  FROM ACTIVE_REASON_CODE B,LEASE_ALL_INFO_ERP P
															    WHERE P.REF_CODE=B.REF_CODE
															     AND P.STATUS='Y'
															     AND P.COLL_CONCERN_ID='$v_login_id'
															     AND P.PAMTMODE='CRT'
															    AND  B.REASON_CODE='On Road'
												                )
                                            ORDER BY A.NUMBER_OF_DUE DESC"	;			
                                } else if ($v_what_want == 'TOTAL_VISIT_ASSIGN') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										    FROM RML_COLL_VISIT_ASSIGN B,LEASE_ALL_INFO_ERP A
										    WHERE A.REF_CODE=B.REF_ID
											AND B.CREATED_BY='$v_rml_id'
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
										   AND trunc(B.ASSIGN_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')";
                                }else if ($v_what_want == 'TOTAL_VISIT_ASSIGN_ON_ROAD') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										    FROM LEASE_ALL_INFO_ERP A,RML_COLL_VISIT_ASSIGN B,ACTIVE_REASON_CODE C
										    WHERE A.REF_CODE=B.REF_ID
											AND B.REF_ID=C.REF_CODE
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											AND C.REASON_CODE ='On Road'
											AND B.CREATED_BY='$v_rml_id'
										   AND trunc(B.ASSIGN_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')";
                                }else if ($v_what_want == 'TOTAL_VISIT_ASSIGN_OTHERS') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										    FROM LEASE_ALL_INFO_ERP A,RML_COLL_VISIT_ASSIGN B,ACTIVE_REASON_CODE C
										    WHERE A.REF_CODE=B.REF_ID
											AND B.REF_ID=C.REF_CODE
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											AND (C.REASON_CODE !='On Road' OR C.REASON_CODE IS NULL)
											AND B.CREATED_BY='$v_rml_id'
										   AND trunc(B.ASSIGN_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')";
                                } else if ($v_what_want == 'UNIQUE_VISIT_ASSIGN') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										    FROM (
											      SELECT unique P.REF_ID 
                                                  FROM RML_COLL_VISIT_ASSIGN P
                                                  WHERE P.CREATED_BY='$v_rml_id'
                                                  AND trunc(P.ASSIGN_DATE) BETWEEN TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
												  ) B ,LEASE_ALL_INFO_ERP A
										    WHERE A.REF_CODE=B.REF_ID
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											";
								}else if ($v_what_want == 'UNIQUE_VISIT_ASSIGN_ON_ROAD') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										     FROM LEASE_ALL_INFO_ERP A,
											                         (SELECT UNIQUE D.REF_ID
																	  FROM RML_COLL_VISIT_ASSIGN D,ACTIVE_REASON_CODE P
																	  WHERE D.REF_ID=P.REF_CODE
																	  AND D.CREATED_BY='$v_rml_id'
																	  AND P.REASON_CODE='On Road'
                                                                      AND trunc(D.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
                                                                      ) B
											WHERE A.REF_CODE=B.REF_ID
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											";
								}else if ($v_what_want == 'UNIQUE_VISIT_ASSIGN_OTHERS') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										     FROM LEASE_ALL_INFO_ERP A,
											                         (SELECT UNIQUE D.REF_ID
																	  FROM RML_COLL_VISIT_ASSIGN D,ACTIVE_REASON_CODE P
																	  WHERE D.REF_ID=P.REF_CODE
																	  AND D.CREATED_BY='$v_rml_id'
																	  AND (P.REASON_CODE!='On Road' OR P.REASON_CODE IS NULL)
                                                                      AND trunc(D.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
                                                                      ) B
											WHERE A.REF_CODE=B.REF_ID
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											";
								}else if ($v_what_want == 'UNIQUE_CODE_NOT_TOUCHING') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										     FROM LEASE_ALL_INFO_ERP A
											    WHERE A.COLL_CONCERN_ID='$v_login_id'
												AND A.STATUS='Y'
												--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
												AND A.PAMTMODE='CRT'
												AND A.REF_CODE NOT IN
												(
												  SELECT UNIQUE D.REF_ID
												  FROM RML_COLL_VISIT_ASSIGN D,ACTIVE_REASON_CODE P
												  WHERE D.REF_ID=P.REF_CODE
												  AND D.CREATED_BY='$v_rml_id'
												  AND trunc(D.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
												 ) ";
								}else if ($v_what_want == 'UNIQUE_VISIT_NOT_TOACHING_ON_ROAD') {
                                    $query = "SELECT B.REF_CODE,
									               (select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
												   A.CUSTOMER_NAME,
												   A.PARTY_ADDRESS,
												   A.LAST_PAYMENT_AMOUNT,
												   A.CUSTOMER_MOBILE_NO,
												   A.NUMBER_OF_DUE,
												   A.LAST_PAYMENT_DATE,
												   A.COLL_CONCERN_ID,
												   LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
                                                   (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )
											       TOTAL_VISITED,
											       (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )TOTAL_VISIT_ASSIGN											   
												FROM ACTIVE_REASON_CODE B,LEASE_ALL_INFO_ERP A
												 WHERE A.REF_CODE=B.REF_CODE
												 AND A.STATUS='Y'
												-- AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
												 AND A.COLL_CONCERN_ID='$v_login_id'
												 AND A.PAMTMODE='CRT'
												 AND  B.REASON_CODE='On Road'
												 AND A.REF_CODE NOT IN
												 (
												  SELECT UNIQUE P.REF_ID
													FROM RML_COLL_VISIT_ASSIGN P
													 WHERE P.CREATED_BY='$v_rml_id'
													 AND trunc(P.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
												 )";
								}else if ($v_what_want == 'UNIQUE_VISIT_NOT_TOACHING_OTHERS') {
                                    $query = "SELECT B.REF_CODE,
									               (select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
												   A.CUSTOMER_NAME,
												   A.PARTY_ADDRESS,
												   A.LAST_PAYMENT_AMOUNT,
												   A.CUSTOMER_MOBILE_NO,
												   A.NUMBER_OF_DUE,
												   A.LAST_PAYMENT_DATE,
												   A.COLL_CONCERN_ID,
												   LAST_VISIT_DATE(B.REF_CODE) LAST_VISIT_DATE,
                                                   (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )
											       TOTAL_VISITED,
											       (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )TOTAL_VISIT_ASSIGN											   
												FROM ACTIVE_REASON_CODE B,LEASE_ALL_INFO_ERP A
												 WHERE A.REF_CODE=B.REF_CODE
												 AND A.STATUS='Y'
												 --AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
												 AND A.COLL_CONCERN_ID='$v_login_id'
												 AND A.PAMTMODE='CRT'
												 AND  (B.REASON_CODE!='On Road' OR B.REASON_CODE IS NULL)
												 AND A.REF_CODE NOT IN
												 (
												  SELECT UNIQUE P.REF_ID
													FROM RML_COLL_VISIT_ASSIGN P
													 WHERE P.CREATED_BY='$v_rml_id'
													 AND trunc(P.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
												 )";
								}else if ($v_what_want == 'TOTAL_VISITED') {
                                    $query = "SELECT A.REF_CODE,
									               (select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
												   A.CUSTOMER_NAME,
												   A.PARTY_ADDRESS,
												   A.LAST_PAYMENT_AMOUNT,
												   A.CUSTOMER_MOBILE_NO,
												   A.NUMBER_OF_DUE,
												   A.LAST_PAYMENT_DATE,
												   A.COLL_CONCERN_ID,
												   LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
                                                   (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )
											       TOTAL_VISITED,
											       (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )TOTAL_VISIT_ASSIGN											   
												FROM LEASE_ALL_INFO_ERP A,RML_COLL_VISIT_ASSIGN B
												 WHERE A.REF_CODE=B.REF_ID
												 AND A.STATUS='Y'
												 --AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
												 AND B.CREATED_BY='$v_rml_id'
												 AND B.VISIT_STATUS=1
												 AND A.PAMTMODE='CRT'
												 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
												";
								}else if ($v_what_want == 'UNIQUE_VISITED') {
                                    $query = "SELECT UNIQUE A.REF_CODE,
									               (select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
												   A.CUSTOMER_NAME,
												   A.PARTY_ADDRESS,
												   A.LAST_PAYMENT_AMOUNT,
												   A.CUSTOMER_MOBILE_NO,
												   A.NUMBER_OF_DUE,
												   A.LAST_PAYMENT_DATE,
												   A.COLL_CONCERN_ID,
												   LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
                                                   (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )
											       TOTAL_VISITED,
											       (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											       )TOTAL_VISIT_ASSIGN											   
												FROM LEASE_ALL_INFO_ERP A,RML_COLL_VISIT_ASSIGN B
												 WHERE A.REF_CODE=B.REF_ID
												 AND A.STATUS='Y'
												-- AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
												 AND B.CREATED_BY='$v_rml_id'
												 AND B.VISIT_STATUS=1
												 AND A.PAMTMODE='CRT'
												 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
												";
								}else if ($v_what_want == 'TOTAL_VISITED_ON_ROAD') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										     FROM LEASE_ALL_INFO_ERP A,
											                         (SELECT D.REF_ID
																	  FROM RML_COLL_VISIT_ASSIGN D,ACTIVE_REASON_CODE P
																	  WHERE D.REF_ID=P.REF_CODE
																	  AND D.CREATED_BY='$v_rml_id'
																	  AND D.VISIT_STATUS=1
																	  AND P.REASON_CODE='On Road'
                                                                      AND trunc(D.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
                                                                      ) B
											WHERE A.REF_CODE=B.REF_ID
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											";
								}else if ($v_what_want == 'TOTAL_VISITED_OTHERS') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										     FROM LEASE_ALL_INFO_ERP A,
											                         (SELECT D.REF_ID
																	  FROM RML_COLL_VISIT_ASSIGN D,ACTIVE_REASON_CODE P
																	  WHERE D.REF_ID=P.REF_CODE
																	  AND D.CREATED_BY='$v_rml_id'
																	  AND D.VISIT_STATUS=1
																	  AND (P.REASON_CODE!='On Road' OR P.REASON_CODE IS NULL)
                                                                      AND trunc(D.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
                                                                      ) B
											WHERE A.REF_CODE=B.REF_ID
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											";
								}else if ($v_what_want == 'UNIQUE_VISITED_ON_ROAD') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										     FROM LEASE_ALL_INFO_ERP A,
											                         (SELECT UNIQUE D.REF_ID
																	  FROM RML_COLL_VISIT_ASSIGN D,ACTIVE_REASON_CODE P
																	  WHERE D.REF_ID=P.REF_CODE
																	  AND D.CREATED_BY='$v_rml_id'
																	  AND D.VISIT_STATUS=1
																	  AND P.REASON_CODE='On Road'
                                                                      AND trunc(D.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
                                                                      ) B
											WHERE A.REF_CODE=B.REF_ID
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											";
								}else if ($v_what_want == 'UNIQUE_VISITED_OTHERS') {
                                    $query = "SELECT 
                                            A.REF_CODE,
											(select K.REASON_CODE from ACTIVE_REASON_CODE K WHERE K.REF_CODE=A.REF_CODE) REASON_CODE,
                                            A.CUSTOMER_NAME,
                                            A.PARTY_ADDRESS,
                                            A.LAST_PAYMENT_AMOUNT,
                                            A.CUSTOMER_MOBILE_NO,
                                            A.NUMBER_OF_DUE,
                                            A.LAST_PAYMENT_DATE,
                                            A.COLL_CONCERN_ID,
											LAST_VISIT_DATE(A.REF_CODE) LAST_VISIT_DATE,
										    (SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.VISIT_STATUS=1
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )
											TOTAL_VISITED,
											(SELECT COUNT(B.REF_ID)
													FROM RML_COLL_VISIT_ASSIGN B
													 WHERE B.CREATED_BY='$v_rml_id'
													 AND B.REF_ID=A.REF_CODE
													 AND trunc(B.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
											 )TOTAL_VISIT_ASSIGN
										     FROM LEASE_ALL_INFO_ERP A,
											                         (SELECT UNIQUE D.REF_ID
																	  FROM RML_COLL_VISIT_ASSIGN D,ACTIVE_REASON_CODE P
																	  WHERE D.REF_ID=P.REF_CODE
																	  AND D.CREATED_BY='$v_rml_id'
																	  AND D.VISIT_STATUS=1
																	  AND (P.REASON_CODE!='On Road' OR P.REASON_CODE IS NULL)
                                                                      AND trunc(D.ASSIGN_DATE) between TO_DATE('$v_start_date','DD/MM/YYYY') and TO_DATE('$v_end_date','DD/MM/YYYY')
                                                                      ) B
											WHERE A.REF_CODE=B.REF_ID
											--AND (a.DUE_AMOUNT>0 OR a.NOT_YET_DUE_AMOUNT > 0)
											";
								}
                                $strSQL = oci_parse($objConnect, $query);

                                oci_execute($strSQL);
                                $number = 0;
                                while ($row = oci_fetch_assoc($strSQL)) {

                                    $number++;
                                ?>
                                    <tr>
                                        <td class="text-center">
                                            <strong>
                                                <?php echo $number; ?>
                                            </strong>
                                        </td>

                                        <td class="customer-info">
                                            <?php
                                            echo 'Code: ' . $row['REF_CODE'];
                                            echo '<br>';
                                            echo 'Customer Name: ' . $row['CUSTOMER_NAME'];
                                            echo '<br>';
                                            echo 'Mobile: <i>' . $row['CUSTOMER_MOBILE_NO'] . '</i>';
                                            echo '<br>';
											$d=$row['PARTY_ADDRESS'];
											if(strlen($d)>100){
												$a= substr($d, 0, 80);  
												$b= substr($d, 80, 100);  
											 echo 'Address: <i>' . $a;	
											 echo '<br>';
											 echo $b . '</i>';
											}else{
												 echo 'Address: <i>' . $d . '</i>';
											}
                                            ?>
                                        </td>
                                        <td class="concern-info">
                                            <?php
                                           
                                           echo 'Last Payment: <span class="fw-bold text-success">' . number_format($row['LAST_PAYMENT_AMOUNT'], 2) . ' TK</span>';
 
                                            echo '<br>';
                                            echo 'Last Payment Date: ' . $row['LAST_PAYMENT_DATE'];
                                            echo '<br>';
                                            echo '<u>Number of Due: <b style="color:red;">' . $row['NUMBER_OF_DUE'] . '</b></u>';
                                            ?>
                                        </td>
                                        <td>
                                            <?php
											echo 'Last Visit Date: ' . $row['LAST_VISIT_DATE'];
											echo '<br>';
                                            echo 'Total Visit: ' . $row['TOTAL_VISITED'];
                                            echo '<br>';
                                            echo 'Total Visit Assign: ' . $row['TOTAL_VISIT_ASSIGN']; 
											echo '<br>';
											echo '<u>Current Reason Code :</u> <b style="color:red;">' . $row['REASON_CODE'] . '</b>';
                                            ?>
                                        </td>

                                    </tr>


                                <?php } ?>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div><!--end row-->

    </div>
</div>
<!--end page wrapper -->
<?php
include_once('../_includes/footer_info.php');
include_once('../_includes/footer.php');
?>