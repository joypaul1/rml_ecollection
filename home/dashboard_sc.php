<?php
include_once ('../_helper/com_conn.php');

?>

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">


        <div class="row">
            <div class="col-12">
                <div class="card rounded-4">
                    <div class="card-header border-success">
                        <div class="d-flex align-items-center justify-content-left">
                            <div class="">
                                <h6 class="mb-0 border-success">
                                    <strong class="text-primary">
                                        <i class="bx bx-flag text-primary"></i>
                                        Sales Certificate Last 5 Days Summary
                                    </strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                    <style>
                        .tbPink {
                            background-color: #d115db38 !important;
                            text-align: center;
                            font-weight: bold;
                        }

                        table.concerntList {
                            font-size: 14px;
                        }

                        .table-sm>:not(caption)>*>* {
                            padding: 0.1rem 0.1rem;
                        }
                    </style>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered align-middle mb-0 concerntList table-hover">
                                <thead class="bg-gradient-smile text-center text-white fw-bold">
                                    <tr>
                                        <th scope="col">Sl No</th>
                                        <th scope="col">
                                            <center>Request Date</center>
                                        </th>
                                        <th scope="col">
                                            <center>Request Total</center>
                                        </th>
                                        <th scope="col">
                                            <center>L&C To ACC</center>
                                        </th>
                                        <th scope="col">
                                            <center>ACC To CCD</center>
                                        </th>
                                        <th scope="col">
                                            <center>CCD Issued</center>
                                        </th>
                                        <th scope="col">
                                            <center>Bank NOC Requsition to ACC</center>
                                        </th>
                                        <th scope="col">
                                            <center>Bank NOC Received</center>
                                        </th>
                                        <th scope="col">
                                            <center>Bank NOC Disbursed</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
                                    $winloastSQL = oci_parse(
                                        $objConnect,
                                        "SELECT TO_DATE(SYSDATE,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-1,'DD/MM/YYYY') PARAMETER_DATE, 
                                        (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-1,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-2,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-2,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-3,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-3,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
                            UNION ALL
                            SELECT TO_DATE(SYSDATE-4,'DD/MM/YYYY') PARAMETER_DATE, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.REQUEST_DATE)= TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) REQUEST_TOTAL, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.LEASE_APPROVAL_DATE)= TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) LEASE_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.ACC_APPROVAL_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) ACC_TO_CCD, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where aa.FILE_CLEAR_STATUS=1 AND trunc(aa.FILE_CLEAR_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) CCD_COMPLETED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_REQUISITION_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_REQUISITION_TO_ACC, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_RECEIVED_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_RECEIVED, 
                                       (SELECT COUNT(aa.ID) FROM RML_COLL_SC_CCD aa where trunc(aa.BANK_NOC_DISBURSED_DATE) = TO_DATE(TO_CHAR(sysdate-4,'DD/MM/YYYY'),'DD/MM/YYYY')) BANK_NOC_DISBURSED 
                            FROM DUAL 
							"
                                    );
                                    $WIN         = 0;
                                    $LOST        = 0;
                                    $number      = 0;
                                    if (oci_execute($winloastSQL)) {
                                        while ($row = oci_fetch_assoc($winloastSQL)) {
                                            $number++;
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $number; ?></td>
                                                <td class="text-center"><?php echo $row['PARAMETER_DATE']; ?></td>
                                                <td class="text-center"><?php echo $row['REQUEST_TOTAL']; ?></td>
                                                <td class="text-center"><?php echo $row['LEASE_TO_ACC']; ?></td>
                                                <td class="text-center"><?php echo $row['ACC_TO_CCD']; ?></td>
                                                <td class="text-center"><?php echo $row['CCD_COMPLETED']; ?></td>
                                                <td class="text-center"><?php echo $row['BANK_REQUISITION_TO_ACC']; ?></td>
                                                <td class="text-center"><?php echo $row['BANK_NOC_RECEIVED']; ?></td>
                                                <td class="text-center"><?php echo $row['BANK_NOC_DISBURSED']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->


    </div>
</div>
<!--end page wrapper -->
<?php
include_once ('../_includes/footer_info.php');
include_once ('../_includes/footer.php');
?>