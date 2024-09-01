<!-- Navigation-->

<?php
// $v_active      = 'active';
// $v_active_open = 'active open';
$currentUrl = $_SERVER['REQUEST_URI'];
function isActive($url)
{
  global $currentUrl;
  return strpos($currentUrl, $url) !== false ? ' show' : '';
}
function isActManu($url)
{
  global $currentUrl;
  return strpos($currentUrl, $url) !== false ? 'activeManu' : '';
}
?>
<style>
  .activeManu {
    background-color: #58a8c759;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-green fixed-top" id="mainNav">
  <a class="navbar-brand" href="dashboard.php"></a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
    aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">


      <!--Only Sales Certificate  -->
      <?php
      if ($_SESSION['user_role_id'] == 5) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="dashboard_sc.php">
            <i class="fa fa-home"></i>
            <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
            </span>
          </a>
        </li>

      <?php } else if ($_SESSION['user_role_id'] == 7) { ?>

          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
            <a class="nav-link" href="dashboard_tt.php">
              <i class="fa fa-home"></i>
              <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
              </span>
            </a>
          </li>
      <?php } else if ($_SESSION['user_role_id'] == 2) { ?>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
              <a class="nav-link" href="dashboard_adm.php">
                <i class="fa fa-home"></i>
                <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                </span>
              </a>
            </li>
      <?php } else if ($_SESSION['user_role_id'] == 9) { ?>

              <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="dashboard_service.php">
                  <i class="fa fa-home"></i>
                  <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                  </span>
                </a>
              </li>
      <?php } else if ($_SESSION['user_role_id'] == 10) { ?>

                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                  <a class="nav-link" href="dashboard_seized.php">
                    <i class="fa fa-home"></i>
                    <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                    </span>
                  </a>
                </li>
      <?php } else if ($_SESSION['user_role_id'] == 3) { ?>

                  <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a class="nav-link" href="dashboard_ah.php">
                      <i class="fa fa-home"></i>
                      <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                      </span>
                    </a>
                  </li>
      <?php } else if ($_SESSION['user_role_id'] == 8) { ?>

                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                      <a class="nav-link" href="dashboard_audit.php">
                        <i class="fa fa-home"></i>
                        <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                        </span>
                      </a>
                    </li>
      <?php } else if ($_SESSION['user_role_id'] == 11) { ?>

                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a class="nav-link" href="dashboard_rmwl.php">
                          <i class="fa fa-home"></i>
                          <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                          </span>
                        </a>
                      </li>
      <?php } else if ($_SESSION['user_role_id'] == 12) { ?>

                        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                          <a class="nav-link" href="dashboard_accounts.php">
                            <i class="fa fa-home"></i>
                            <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                            </span>
                          </a>
                        </li>
      <?php } else if ($_SESSION['user_role_id'] == 13) { ?>

                          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                            <a class="nav-link" href="dashboard_ccd_call.php">
                              <i class="fa fa-home"></i>
                              <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                              </span>
                            </a>
                          </li>
      <?php } else if ($_SESSION['user_role_id'] == 14) { ?>

                            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                              <a class="nav-link" href="dashboard_sale.php">
                                <i class="fa fa-home"></i>
                                <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                                </span>
                              </a>
                            </li>
      <?php } else if ($_SESSION['user_role_id'] == 1) { ?>

                              <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                                <a class="nav-link" href="dashboard_it.php">
                                  <i class="fa fa-home"></i>
                                  <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                                  </span>
                                </a>
                              </li>
      <?php } else { ?>
                              <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                                <a class="nav-link" href="dashboard.php">
                                  <i class="fa fa-home"></i>
                                  <span style="color:yellow" class="nav-link-text">
              <?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?> Dashboard
                                  </span>
                                </a>
                              </li>
        <?php
      }
      ?>


      <?php
      //Seized Module
      if ($_SESSION['user_role_id'] == 10) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Seized Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseSeized"
            data-parent="#exampleAccordion">
            <i class="fa fa-ellipsis-v"></i>
            <span class="nav-link-text">Seized Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_seized_update.php'); ?>
          <?php echo isActive('/adm_seized_confirm.php'); ?>
          
          " id="collapseSeized">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_update.php'); ?>"
                href="adm_seized_update.php"> Seized Info Update</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_confirm.php'); ?>"
                href="adm_seized_confirm.php"> Seized Confirm</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Release Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseRelease"
            data-parent="#exampleAccordion">
            <i class="fa fa-list"></i>
            <span class="nav-link-text">Release Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_seized_release.php'); ?>
          <?php echo isActive('/release.php'); ?>
          
          " id="collapseRelease">

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_release.php'); ?>"
                href="adm_seized_release.php"> Release Confirm</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/release.php'); ?>" href="release.php"> Release List</a>
            </li>
          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Report Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#seizedReport"
            data-parent="#exampleAccordion">
            <i class="fa fa-ellipsis-v"></i>
            <span class="nav-link-text">Report Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_seized_report.php'); ?>
          <?php echo isActive('/adm_driver_name_list.php'); ?>
          <?php echo isActive('/adm_depot_location_list.php'); ?>
          
          " id="seizedReport">

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_report.php'); ?>"
                href="adm_seized_report.php"> Seized Report List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-righ <?php echo isActManu('/adm_driver_name_list.php'); ?>"
                href="adm_driver_name_list.php"> Driver Name List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-righ <?php echo isActManu('/adm_depot_location_list.php'); ?>"
                href="adm_depot_location_list.php"> Depot Location
                List</a>
            </li>

          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Service Code">
          <a class="nav-link nav-link-collapse collapsed
          <?php echo isActive('/service.php'); ?>
          <?php echo isActive('/service_list.php'); ?>
          <?php echo isActive('/service_report.php'); ?>
          
          
          " data-toggle="collapse" href="#freeService" data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Service Code</span>
          </a>
          <ul class="sidenav-second-level collapse" id="freeService">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service.php'); ?>" href="service.php"> Search</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_list.php'); ?>" href="service_list.php">
                Conditional Data</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_report.php'); ?>" href="service_report.php">
                Report List</a>
            </li>

          </ul>
        </li>

      <?php } ?>







      <?php
      //Only Sales Certificate 
      if ($_SESSION['user_role_id'] == 5) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Admin Entry Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#adminentrypanel"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Admin Entry Panel</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/bank_list.php'); ?>
          <?php echo isActive('/sc_customer_handover.php'); ?>
          <?php echo isActive('/sc_customer_received.php'); ?>
          
          " id="adminentrypanel">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/bank_list.php'); ?>" href="bank_list.php"> Bank List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_customer_handover.php'); ?>"
                href="sc_customer_handover.php"> SC Handover</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_customer_received.php'); ?>"
                href="sc_customer_received.php"> CAR Received</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Bank NOC Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#banknocpanel"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Bank NOC Panel</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_bank_requsition.php'); ?>
          <?php echo isActive('/sc_bank_noc_received_ccd.php'); ?>
          <?php echo isActive('/sc_bank_noc_disbursed.php'); ?>
          
          
          " id="banknocpanel">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_bank_requsition.php'); ?>"
                href="sc_bank_requsition.php"> Bank NOC Requisition</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_bank_noc_received_ccd.php'); ?>"
                href="sc_bank_noc_received_ccd.php"> Bank NOC
                Received</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_bank_noc_disbursed.php'); ?>"
                href="sc_bank_noc_disbursed.php"> Bank NOC
                Disbursed</a>
            </li>
          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="CCD Admin Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#ccdadmin"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">CCD Admin Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_approval_ccd.php'); ?>
          <?php echo isActive('/sc_check_list.php'); ?>
          <?php echo isActive('/sc_check_list_completed.php'); ?>
          
          " id="ccdadmin">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_approval_ccd.php'); ?>" href="sc_approval_ccd.php">
                Wating List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_check_list.php'); ?>" href="sc_check_list.php"> Check
                List Remain</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_check_list_completed.php'); ?>"
                href="sc_check_list_completed.php"> Check List
                Completed</a>
            </li>

          </ul>
        </li>





        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="SC Reissue Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#screissuespanel"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">SC Reissue Panel</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/reissues_list.php'); ?>
          <?php echo isActive('/reissues_approval_ccd.php'); ?>
          <?php echo isActive('/reissues_list_report.php'); ?>
          
          " id="screissuespanel">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/reissues_list.php'); ?>" href="reissues_list.php">
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/reissues_approval_ccd.php'); ?>"
                href="reissues_approval_ccd.php"> Approval List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/reissues_list_report.php'); ?>"
                href="reissues_list_report.php"> Report</a>
            </li>

          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="SC Report Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#screportpanel"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">SC Report Panel</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_report_1.php'); ?>
          <?php echo isActive('/sc_report_sumary_dtls.php'); ?>
          <?php echo isActive('/sc_report_data.php'); ?>
          <?php echo isActive('/sc_report_data.php'); ?>
          <?php echo isActive('/sc_report_handover.php'); ?>
          <?php echo isActive('/sc_report_noc.php'); ?>
          <?php echo isActive('/sc_list_reissues_ccd.php'); ?>
          <?php echo isActive('/sc_problem_report.php'); ?>
          <?php echo isActive('/sc_list_test.php'); ?>
          
          " id="screportpanel">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_report_1.php'); ?>" href="sc_report_1.php"> Summary
                Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_report_sumary_dtls.php'); ?>"
                href="sc_report_sumary_dtls.php"> Summary Report-2</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_report_data.php'); ?>" href="sc_report_data.php">
                Request Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_report_handover.php'); ?>"
                href="sc_report_handover.php"> Handover Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_report_noc.php'); ?>" href="sc_report_noc.php"> Bank
                NOC Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_reissues_ccd.php'); ?>"
                href="sc_list_reissues_ccd.php"> File Problem List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_problem_report.php'); ?>"
                href="sc_problem_report.php"> File Problem Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_test.php'); ?>" href="sc_list_test.php">
                Test</a>
            </li>

          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Password Change<">
          <a class="nav-link" href="password_change_free.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text"> Password Change</span>
          </a>
        </li>
        <!--
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Prepare SC Documents">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#scdocuments" data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Prepare SC Documents</span>
          </a>
          <ul class="sidenav-second-level collapse" id="scdocuments">
            <li>
              <a class="fa fa-hand-o-right" href="sc_closing_meeting_minute_report.php"> Meeting Minutes</a>
            </li>
      <li>
              <a class="fa fa-hand-o-right" href="sc_ownership_transfer_report.php"> Ownership Transfer</a>
            </li>
      <li>
              <a class="fa fa-hand-o-right" href="sc_form_tto_report.php"> T.T.O</a>
            </li>
      <li>
              <a class="fa fa-hand-o-right" href="bank_noc_or_disbursed.php"> T.O</a>
            </li>
      <li>
              <a class="fa fa-hand-o-right" href="bank_noc_or_disbursed.php"> Sales Receipt</a>
            </li>
          </ul>
        </li>
    
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="CCD Admin Report">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#ccdadminreport" data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">CCD Admin Report</span>
          </a>
          <ul class="sidenav-second-level collapse" id="ccdadminreport">
            <li>
              <a class="fa fa-hand-o-right" href="sc_closing_approval_sheet_report.php"> Approval Sheet</a>
            </li>
      <li>
              <a class="fa fa-hand-o-right" href="sc_closing_approval_sheet_rsv_report.php"> Approval Sheet(RS)</a>
            </li>
      <li>
              <a class="fa fa-hand-o-right" href="sc_closing_meeting_minute_report.php"> Meeting Minutes</a>
            </li>
      
          </ul>
        </li>
    
    
    
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
        <a class="nav-link" href="sc_feedback.php">
        <i class="fa fa-flag-checkered"></i>
        <span class="nav-link-text">User Feed-Back</span>
        </a>
    </li>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
        <a class="nav-link" href="sc_close_action.php">
        <i class="fa fa-tasks"></i>
        <span class="nav-link-text">Final Action</span>
        </a>
    </li>
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Report Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
             <li>
              <a class="fa fa-bar-chart" href="sc_report_1.php">SC Report-1</a>
             </li>
       <li>
              <a class="fa fa-bar-chart" href="sc_report_2.php"> Closed Report</a>
             </li>
        <li>
              <a class="fa fa-bar-chart" href="sc_report_3.php"> Closed Ref Info</a>
             </li>
          </ul>
        </li>
    -->
      <?php } ?>



      <?php
      //only visible to Normal User
      if ($_SESSION['user_role_id'] == 6) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Report Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
            <li>
              <a class="fa fa-money" href="collection_report.php"> Collection Report</a>
            </li>
            <li>
              <a href="visit_report.php">EMI Visit Report</a>
            </li>
            <li>
              <a href="seized_report.php">Seized Report</a>
            </li>
          </ul>
        </li>

      <?php } ?>


      <?php
      //only visible to Bank TT User
      if ($_SESSION['user_role_id'] == 7) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Empmasters">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#target"
            data-parent="#exampleAccordion">
            <i class="fa fa-money"></i>
            <span class="nav-link-text">Target VS Collection</span>
          </a>
          <ul class="sidenav-second-level collapse" id="target">
            <li>
              <a class="fa fa-money" href="adm_ah_target_assign.php"> Area Head Collection</a>
            </li>
            <li>
              <a class="fa fa-money" href="adm_zh_target_assign.php"> Zonal Head Collection</a>
            </li>
            <li>
              <a class="fa fa-money" href="adm_cc_target_assign.php"> Concern Collection</a>
            </li>
            <li>
              <a class="fa fa-money" href="adm_cc_collection_history.php"> Collection History</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Empmasters">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseEmpmasters"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">TT Pending Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseEmpmasters">
            <li>
              <a class="fa fa-hand-o-right" href="tt_edit.php"> TT Edit</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="tt_confirm.php"> Create Date Wise</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="tt_date_wise.php"> TT Date Wise</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="tt_ref_confirm.php"> Ref-Code Wise</a>
            </li>

          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Report Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
            <li>
              <a class="fa fa-hand-o-right" href="tt_ref_report.php"> Ref-Code Info</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="tt_report_date_wise.php"> Confirm TT</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="tt_report_zone_wise.php"> Zone Wise TT</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="tt_report_concern_wise.php"> Concern Wise TT</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#ttDelete"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Delete Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="ttDelete">
            <li>
              <a class="fa fa-hand-o-right" href="tt_delete.php"> TT Delete</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Free Service">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#freeService"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Free Service Code</span>
          </a>
          <ul class="sidenav-second-level collapse" id="freeService">
            <li>
              <a class="fa fa-hand-o-right" href="service.php"> Search</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="service_list.php"> Conditional Data</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="service_report.php"> Report List</a>
            </li>

          </ul>
        </li>


      <?php } ?>
      <?php



      //only visible to Audit user
      if ($_SESSION['user_role_id'] == 8) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Empmasters">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#visitAssign"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Visit Assign Module</span>
          </a>
          <ul class="sidenav-second-level collapse" id="visitAssign">

            <!--
      <li>
              <a class="fa fa-hand-o-right" href="adm_daily_visit_report.php"> Monthly Assign Report</a>
            </li>
      -->
            <li>
              <a class="fa fa-hand-o-right" href="adm_daily_visit.php"> Daily Visit Monitor</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right" href="adm_concern_visit.php"> Concern Visit Summary</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right" href="adm_zone_visit.php"> Zone Visit Summary</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Target VS Collection">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#targetvscollection"
            data-parent="#exampleAccordion">
            <i class="fa fa-money"></i>
            <span class="nav-link-text">Target VS Collection</span>
          </a>
          <ul class="sidenav-second-level collapse" id="targetvscollection">
            <li>
              <a class="fa fa-money" href="adm_ah_target_assign.php"> Area Head Collection</a>
            </li>
            <li>
              <a class="fa fa-money" href="adm_zh_target_assign.php"> Zonal Head Collection</a>
            </li>
            <li>
              <a class="fa fa-money" href="adm_cc_target_assign.php"> Concern Collection</a>
            </li>
            <li>
              <a class="fa fa-money" href="adm_cc_collection_history.php"> Collection History</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Report Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-file"></i>
            <span class="nav-link-text">Report Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
            <li>
              <a class="fa fa-bar-chart" href="collection_report.php"> Collection Report</a>
            </li>
            <li>
              <a class="fa fa-bar-chart" href="visit_report.php"> EMI Visit Report</a>
            </li>
            <li>
              <a class="fa fa-bar-chart" href="seized_report.php"> Seized Report</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Image Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#imagesModule"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Image Module</span>
          </a>
          <ul class="sidenav-second-level collapse" id="imagesModule">
            <li>
              <a class="fa fa-hand-o-right" href="adm_zone_images.php"> Images Zone Unit</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="adm_images_view.php"> Code Wise Images</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="adm_images_grade_summary.php"> Grade Summary</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="adm_images_history.php"> Uploaded History</a>
            </li>

          </ul>
        </li>

        <!--
    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sale Certificate Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#scReport" data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Sale Certificate Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="scReport">
             <li>
              <a class="fa fa-bar-chart" href="sc_report_1.php"> Certificate Report</a>
             </li>
       <li>
              <a class="fa fa-bar-chart" href="sc_report_2.php"> Closed Report</a>
             </li>
          </ul>
        </li>
    -->


      <?php } ?>



      <?php
      //only IT User
      if ($_SESSION['user_role_id'] == 1) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Location Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#locationManager"
            data-parent="#exampleAccordion">
            <i class="fa fa-certificate"></i>
            <span class="nav-link-text">Location Module[Test]</span>
          </a>
          <ul class="sidenav-second-level collapse" id="locationManager">
            <li>
              <a class="fa fa-hand-o-right" href="emi_location.php"> EMI Location</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="visit_location.php"> Visit Location</a>
            </li>


          </ul>
        </li>





        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#usermoduleadmin"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Apps Admin Module</span>
          </a>
          <ul class="sidenav-second-level collapse" id="usermoduleadmin">
            <li>
              <a class="fa fa-hand-o-right" href="apps_user_list.php"> Active User List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="inactive_user_list.php"> In-Active User List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="data_syn.php"> Data Syn</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="coll_session_date.php"> Apps Session Data</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="exel_upload.php"> Target Upload</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Web Admin Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#webAdminPanel"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Web Admin Module</span>
          </a>
          <ul class="sidenav-second-level collapse" id="webAdminPanel">
            <li>
              <a class="fa fa-hand-o-right" href="user.php"> Web User List</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="ERP View">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#eraviewpanel"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">ERP_LINK_LIVE</span>
          </a>
          <ul class="sidenav-second-level collapse" id="eraviewpanel">
            <li>
              <a class="fa fa-hand-o-right" href="lease_all_info.php"> lease_all_info</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right" href="filesum_v.php"> FILESUM_V</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Collection Entry Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collectionentrypanel"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Collection Entry Panel</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collectionentrypanel">
            <li>
              <a class="fa fa-hand-o-right" href="entry_list.php"> Entry Search</a>
            </li>

          </ul>
        </li>

      <?php } ?>





      <!--====================Only ADM User ==============================-->
      <?php
      if ($_SESSION['user_role_id'] == 2) { ?>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Module">
          <!-- <a class="nav-link nav-link-collapse " data-toggle="collapse" href="#usermoduleadmin" data-parent="#exampleAccordion"> -->
          <a class="nav-link nav-link-collapse   
         " data-toggle="collapse" href="#usermoduleadmin" data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Admin Module</span>
          </a>
          <ul class="sidenav-second-level  collapse
          <?php echo isActive('/apps_user_list.php'); ?>
          <?php echo isActive('/setup_list.php'); ?>
          <?php echo isActive('/target_list.php'); ?>
          
          " id="usermoduleadmin">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/apps_user_list.php'); ?>" href="apps_user_list.php">
                User List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/setup_list.php'); ?>" href="setup_list.php"> User Setup
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/target_list.php'); ?>" href="target_list.php"> Target
                List</a>
            </li>
          </ul>
        </li>



        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sales Certificate Module">
          <a class="nav-link nav-link-collapse" data-toggle="collapse" href="#salesCertificatePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-file-excel-o"></i>
            <span class="nav-link-text">Sales Certificate Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_list.php'); ?>
          <?php echo isActive('/sc_list_reissues.php'); ?>
          <?php echo isActive('/reissues_approval_lease.php'); ?>
          <?php echo isActive('/sc_adm_report.php'); ?>
          
          " id="salesCertificatePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list.php'); ?>" href="sc_list.php"> Request List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_reissues.php'); ?>" href="sc_list_reissues.php">
                File Problem List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/reissues_approval_lease.php'); ?>"
                href="reissues_approval_lease.php"> Reissues
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_adm_report.php'); ?>" href="sc_adm_report.php"> Code
                Wise Report</a>
            </li>
          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Empmasters">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#visitAssign"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Visit Assign Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_daily_visit_new.php'); ?>
          <?php echo isActive('/adm_daily_visit.php'); ?>
          <?php echo isActive('/adm_concern_visit.php'); ?>
          <?php echo isActive('/adm_zone_visit.php'); ?>
          " id="visitAssign">

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_daily_visit_new.php'); ?>"
                href="adm_daily_visit_new.php"> Concern Monitor</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_daily_visit.php'); ?>" href="adm_daily_visit.php">
                Visit Monitor</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_concern_visit.php'); ?>"
                href="adm_concern_visit.php"> Concern Visit Summary</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_zone_visit.php'); ?>" href="adm_zone_visit.php">
                Zone Visit Summary</a>
            </li>
          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Empmasters">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#imagesModule"
            data-parent="#exampleAccordion">
            <i class="fa fa-picture-o"></i>
            <span class="nav-link-text">Image Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_zone_images.php'); ?>
          <?php echo isActive('/adm_images_view.php'); ?>
          <?php echo isActive('/adm_images_grade_summary.php'); ?>
          <?php echo isActive('/adm_images_history.php'); ?>
          
          " id="imagesModule">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_zone_images.php'); ?>" href="adm_zone_images.php">
                Images Zone Unit</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_images_view.php'); ?>" href="adm_images_view.php">
                Code Wise Images</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_images_grade_summary.php'); ?>"
                href="adm_images_grade_summary.php"> Grade
                Summary</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_images_history.php'); ?>"
                href="adm_images_history.php"> Uploaded History</a>
            </li>

          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Target VS Collection">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#target"
            data-parent="#exampleAccordion">
            <i class="fa fa-money"></i>
            <span class="nav-link-text">Target VS Collection</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_ah_target_assign.php'); ?>
          <?php echo isActive('/adm_zh_target_assign.php'); ?>
          <?php echo isActive('/adm_cc_target_assign.php'); ?>
          <?php echo isActive('/adm_cc_collection_history.php'); ?>
          
          " id="target">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_ah_target_assign.php'); ?>"
                href="adm_ah_target_assign.php"> Area Head
                Collection</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_zh_target_assign.php'); ?>"
                href="adm_zh_target_assign.php"> Zonal Head
                Collection</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_cc_target_assign.php'); ?>"
                href="adm_cc_target_assign.php"> Concern
                Collection</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_cc_collection_history.php'); ?>"
                href="adm_cc_collection_history.php"> Collection
                History</a>
            </li>
          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Bank TT Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#bankTT"
            data-parent="#exampleAccordion">
            <i class="fa fa-file-excel-o"></i>
            <span class="nav-link-text">Bank TT Panel</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/tt_ref_report.php'); ?>
          <?php echo isActive('/tt_report_date_wise.php'); ?>
          <?php echo isActive('/tt_report_concern_wise.php'); ?>
          
          " id="bankTT">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/tt_ref_report.php'); ?>" href="tt_ref_report.php">
                Ref-Code Info</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right  <?php echo isActManu('/tt_report_date_wise.php'); ?>"
                href="tt_report_date_wise.php"> Confirm TT</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right  <?php echo isActManu('/tt_report_zone_wise.php'); ?>"
                href="tt_report_zone_wise.php"> Zone Wise TT</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right  <?php echo isActManu('/tt_report_concern_wise.php'); ?>"
                href="tt_report_concern_wise.php"> Concern Wise
                TT</a>
            </li>
          </ul>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reason Code Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-ban"></i>
            <span class="nav-link-text">Reason Code Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_reason_code_list.php'); ?>
          <?php echo isActive('/adm_reason_code_report.php'); ?>
          <?php echo isActive('/adm_last_reason_code_report.php'); ?>
          <?php echo isActive('/adm_reason_code_summary.php'); ?>
          " id="collapseExamplePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_reason_code_list.php'); ?>"
                href="adm_reason_code_list.php"> Reason Code List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_reason_code_report.php'); ?>"
                href="adm_reason_code_report.php"> Reason Code
                Details</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_last_reason_code_report.php'); ?>"
                href="adm_last_reason_code_report.php"> Last
                Reason Code List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_reason_code_summary.php'); ?>"
                href="adm_reason_code_summary.php"> Reason Code
                Summary</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Seized Module">
          <a class="nav-link nav-link-collapse collapsed
          
          
          " data-toggle="collapse" href="#collapseSeized" data-parent="#exampleAccordion">
            <i class="fa fa-ellipsis-v"></i>
            <span class="nav-link-text">Seized Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_driver_name_list.php'); ?>
          <?php echo isActive('/adm_depot_location_list.php'); ?>
          <?php echo isActive('/adm_seized_confirm.php'); ?>
          <?php echo isActive('/adm_seized_report.php'); ?>
          
          " id="collapseSeized">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_driver_name_list.php'); ?>"
                href="adm_driver_name_list.php"> Driver Name
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_depot_location_list.php'); ?>"
                href="adm_depot_location_list.php"> Depot Location
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_confirm.php'); ?>"
                href="adm_seized_confirm.php"> Seized Info
                Update</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_report.php'); ?>"
                href="adm_seized_report.php"> Seized Report
                List</a>
            </li>


          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Admin Setting Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#salesadminsetting"
            data-parent="#exampleAccordion">
            <i class="fa fa-certificate"></i>
            <span class="nav-link-text">Admin Setting Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/zone_wise_unit.php'); ?>
          
          " id="salesadminsetting">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/zone_wise_unit.php'); ?>" href="zone_wise_unit.php">
                Zone Setting</a>
            </li>

          </ul>
        </li>


      <?php } ?>

      <!--====================End ADM User ==============================-->











      <!--====================Area Head User ==============================-->
      <?php
      if (($_SESSION['user_role_id'] == 3)) { ?>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Master Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseEmpmasters"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Master Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/area_head_concern.php'); ?>
          
          " id="collapseEmpmasters">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/area_head_concern.php'); ?>"
                href="area_head_concern.php"> Concern List</a>
            </li>

          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Empmasters">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#visitAssign"
            data-parent="#exampleAccordion">
            <i class="fa fa-user-plus"></i>
            <span class="nav-link-text">Visit Assign Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_daily_visit.php'); ?>
          <?php echo isActive('/adm_concern_visit.php'); ?>
          <?php echo isActive('/adm_zone_visit.php'); ?>
          
          " id="visitAssign">

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_daily_visit.php'); ?>" href="adm_daily_visit.php">
                Daily Visit Monitor</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_concern_visit.php'); ?>"
                href="adm_concern_visit.php"> Concern Visit Summary</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_zone_visit.php'); ?>" href="adm_zone_visit.php">
                Zone Visit Summary</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sales Certificate Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#salesCertificatePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-certificate"></i>
            <span class="nav-link-text">Sales Certificate Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_ah_report.php'); ?>
          <?php echo isActive('/sc_ah_summary_report.php'); ?>
          
          " id="salesCertificatePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_ah_report.php'); ?>" href="sc_ah_report.php"> Code
                Wise Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_ah_summary_report.php'); ?>"
                href="sc_ah_summary_report.php"> Zone Summary
                Report</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Report Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Report Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/collection_report.php'); ?>
          <?php echo isActive('/visit_report.php'); ?>
          <?php echo isActive('/seized_report.php'); ?>
          
          " id="collapseExamplePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/collection_report.php'); ?>"
                href="collection_report.php">Collection Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/visit_report.php'); ?>" href="visit_report.php">EMI
                Visit Report</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/seized_report.php'); ?>" href="seized_report.php">Seized
                Report</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Empmasters">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#imagesModule"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Image Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_zone_images.php'); ?>
          <?php echo isActive('/adm_images_view.php'); ?>
          <?php echo isActive('/adm_images_grade_summary.php'); ?>
          <?php echo isActive('/adm_images_history.php'); ?>
          
          " id="imagesModule">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_zone_images.php'); ?>" href="adm_zone_images.php">
                Images Zone Unit</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_images_view.php'); ?>" href="adm_images_view.php">
                Code Wise Images</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_images_grade_summary.php'); ?>"
                href="adm_images_grade_summary.php"> Grade
                Summary</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_images_history.php'); ?>"
                href="adm_images_history.php"> Uploaded History</a>
            </li>

          </ul>
        </li>


      <?php } ?>

      <!--====================END Area Head User ==============================-->

      <!--====================Free service==============================-->
      <?php
      if (($_SESSION['user_role_id'] == 9)) { ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Service Code">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#freeService"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Free Service Code</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/service.php'); ?>
          <?php echo isActive('/service_list.php'); ?>
          <?php echo isActive('/service_report.php'); ?>
          <?php echo isActive('/service_report_1.php'); ?>
          
          " id="freeService">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service.php'); ?>" href="service.php"> Add Call</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_list.php'); ?>" href="service_list.php">
                Conditional Data</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_report.php'); ?>" href="service_report.php">
                Report List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_report_1.php'); ?>" href="service_report_1.php">
                Report Date Wise</a>
            </li>

          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sales Certificate Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#salesCertificatePages"
            data-parent="#salesCertificatePages">
            <i class="fa fa-certificate"></i>
            <span class="nav-link-text">Sales Certificate Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_list.php'); ?>
          <?php echo isActive('/sc_list_reissues.php'); ?>
          <?php echo isActive('/reissues_approval_lease.php'); ?>
          <?php echo isActive('/sc_adm_report.php'); ?>
          " id="salesCertificatePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list.php'); ?>" href="sc_list.php"> Request List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_reissues.php'); ?>" href="sc_list_reissues.php">
                File Problem List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/reissues_approval_lease.php'); ?>"
                href="reissues_approval_lease.php"> Reissues
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_adm_report.php'); ?>" href="sc_adm_report.php"> Code
                Wise Report</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Password Change<">
          <a class="nav-link" href="password_change_free.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text"> Password Change</span>
          </a>
        </li>
        <?php
        if ($_SESSION['emp_id'] == 'RML-00955' || $_SESSION['emp_id'] == 'cs') { ?>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Module">
            <a class="nav-link nav-link-collapse collapsed
            <?php echo isActive('/user_list_callsystem.php'); ?>
            
            " data-toggle="collapse" href="#usermodule" data-parent="#exampleAccordion">
              <i class="fa fa-address-card-o"></i>
              <span class="nav-link-text">User Module</span>
            </a>
            <ul class="sidenav-second-level collapse" id="usermodule">
              <li>
                <a class="fa fa-hand-o-right <?php echo isActManu('/user_list_callsystem.php'); ?>"
                  href="user_list_callsystem.php"> User List</a>
              </li>

            </ul>
          </li>

        <?php }
      } ?>

      <!--====================END Free service ==============================-->
      <!--====================Accounts Sales Certificate==============================-->
      <?php
      if (($_SESSION['user_role_id'] == 12)) { ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Service Code">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#freeService"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">SC Approval</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_accounts_approval.php'); ?>
          <?php echo isActive('/sc_bank_requsition_acc.php'); ?>
          
          " id="freeService">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_accounts_approval.php'); ?>"
                href="sc_accounts_approval.php"> Approval List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_bank_requsition_acc.php'); ?>"
                href="sc_bank_requsition_acc.php"> Bank NOC List</a>
            </li>


          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Report Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#accreportmodule"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Report Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_list_acc_report.php'); ?>
          <?php echo isActive('/sc_check_list_completed_acc.php'); ?>
          <?php echo isActive('/sc_report_1.php'); ?>
          
          " id="accreportmodule">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_acc_report.php'); ?>"
                href="sc_list_acc_report.php"> Report List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_check_list_completed_acc.php'); ?>"
                href="sc_check_list_completed_acc.php">
                Completed List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_report_1.php'); ?>" href="sc_report_1.php"> Summary
                Report</a>
            </li>

          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Password Change<">
          <a class="nav-link" href="password_change_free.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text"> Password Change</span>
          </a>
        </li>

        <?php
        if ($_SESSION['emp_id'] == 'RML-00955' || $_SESSION['emp_id'] == 'cs') { ?>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Module">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#usermodule"
              data-parent="#exampleAccordion">
              <i class="fa fa-address-card-o"></i>
              <span class="nav-link-text">User Module</span>
            </a>
            <ul class="sidenav-second-level collapse
            <?php echo isActive('/user_list_callsystem.php'); ?>
            " id="usermodule">
              <li>
                <a class="fa fa-hand-o-right <?php echo isActManu('/user_list_callsystem.php'); ?>"
                  href="user_list_callsystem.php"> User List</a>
              </li>

            </ul>
          </li>

        <?php }
      } ?>

      <!--====================END Accounts Sales Certificate==========-->

      <!--====================Start RMWL==============================-->
      <?php
      if (($_SESSION['user_role_id'] == 11)) { ?>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Service Code">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#freeService"
            data-parent="#exampleAccordion">
            <i class="fa fa-address-card-o"></i>
            <span class="nav-link-text">Free Service Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/service_check.php'); ?>
          <?php echo isActive('/service_report_free.php'); ?>
          <?php echo isActive('/service_report_date.php'); ?>
          
          " id="freeService">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_check.php'); ?>" href="service_check.php"> Add
                Service</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_report_free.php'); ?>"
                href="service_report_free.php"> Report List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/service_report_date.php'); ?>"
                href="service_report_date.php"> Report Date Wise</a>
            </li>

          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Password Change<">
          <a class="nav-link" href="password_change_rmwl.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text"> Password Change</span>
          </a>
        </li>


        <?php

      }
      ?>

      <!--====================END RMWL ==============================-->

      <!--====================Start CCD Call SYSTEM=============================-->

      <?php
      if (($_SESSION['user_role_id'] == 13)) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Admin Panel">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#adminPanelCall"
            data-parent="#exampleAccordion">
            <i class="fa fa-hand-o-right"></i>
            <span class="nav-link-text">Admin Panel</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/call_customer_list.php'); ?>
          <?php echo isActive('/call_category.php'); ?>
          
          
          " id="adminPanelCall">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_customer_list.php'); ?>"
                href="call_customer_list.php"> Data Search</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_category.php'); ?>" href="call_category.php"> Call
                Category List</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Call To Customer">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#CalltoCustomer"
            data-parent="#exampleAccordion">
            <i class="fa fa-phone"></i>
            <span class="nav-link-text">Outbound Call Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/call_customer_report.php'); ?>
          <?php echo isActive('/call_customer_report_closed.php'); ?>
          <?php echo isActive('/call_customer_notification.php'); ?>
          
          " id="CalltoCustomer">

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_customer_report.php'); ?>"
                href="call_customer_report.php"> Open Call List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_customer_report_closed.php'); ?>"
                href="call_customer_report_closed.php"> Closed
                Call List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_customer_notification.php'); ?>"
                href="call_customer_notification.php">
                Notification List</a>
            </li>
          </ul>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#usermodule"
            data-parent="#exampleAccordion">
            <i class="fa fa-mobile-phone fa-2x"></i>
            <span class="nav-link-text">Inbound Call Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/call_customer_to_ccd.php'); ?>
          <?php echo isActive('/call_customer_to_ccd_closed.php'); ?>
          <?php echo isActive('/call_customer_notification_inbound.php'); ?>
          
          " id="usermodule">

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_customer_to_ccd.php'); ?>"
                href="call_customer_to_ccd.php"> Open Call List</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_customer_to_ccd_closed.php'); ?>"
                href="call_customer_to_ccd_closed.php"> Closed
                Call List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/call_customer_notification_inbound.php'); ?>"
                href="call_customer_notification_inbound.php"> Notification List</a>
            </li>
          </ul>
        </li>
        <?php
      }
      ?>
      <!--====================End CCD Call SYSTEM=============================-->


      <!--====================Start Sales SYSTEM==============================-->

      <?php
      if (($_SESSION['user_role_id'] == 14)) { ?>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sales Certificate Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#salesCertificatePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-certificate"></i>
            <span class="nav-link-text">Sales Certificate Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_list_sales.php'); ?>
          <?php echo isActive('/sc_list_reissues_sales.php'); ?>
          <?php echo isActive('/sc_adm_report_sales.php'); ?>
          
          " id="salesCertificatePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_sales.php'); ?>" href="sc_list_sales.php">
                Request List</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_reissues_sales.php'); ?>"
                href="sc_list_reissues_sales.php"> File Problem
                List</a>
            </li>

            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_adm_report_sales.php'); ?>"
                href="sc_adm_report_sales.php"> Code Wise Report</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Password Change<">
          <a class="nav-link" href="password_change_rmwl.php">
            <i class="fa fa-fw fa fa-wpforms"></i>
            <span class="nav-link-text"> Password Change</span>
          </a>
        </li>


        <?php
      }
      ?>
      <!--====================END Start Sales SYSTEM=============================-->

      <?php if (($_SESSION['user_role_id'] == 15)) { ?>
        <!--====================REASON CODE Module + SIZED Module+ SALE Certificate  =============================-->
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reason Code Module">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-ban"></i>
            <span class="nav-link-text">Reason Code Module</span>
          </a>
          <ul class="sidenav-second-level collapse
            <?php echo isActive('/adm_reason_code_list.php'); ?>
            <?php echo isActive('/adm_reason_code_report.php'); ?>
            <?php echo isActive('/adm_last_reason_code_report.php'); ?>
            <?php echo isActive('/adm_reason_code_summary.php'); ?>
          " id="collapseExamplePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_reason_code_list.php'); ?>"
                href="adm_reason_code_list.php"> Reason Code List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_reason_code_report.php'); ?>"
                href="adm_reason_code_report.php"> Reason Code
                Details</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_last_reason_code_report.php'); ?>"
                href="adm_last_reason_code_report.php"> Last
                Reason Code List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_reason_code_summary.php'); ?>"
                href="adm_reason_code_summary.php"> Reason Code
                Summary</a>
            </li>
          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Seized Module">
          <a class="nav-link nav-link-collapse collapsed
          " data-toggle="collapse" href="#collapseSeized" data-parent="#exampleAccordion">
            <i class="fa fa-ellipsis-v"></i>
            <span class="nav-link-text">Seized Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/adm_driver_name_list.php'); ?>
          <?php echo isActive('/adm_depot_location_list.php'); ?>
          <?php echo isActive('/adm_seized_confirm.php'); ?>
          <?php echo isActive('/adm_seized_report.php'); ?>
          
          " id="collapseSeized">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_driver_name_list.php'); ?>"
                href="adm_driver_name_list.php"> Driver Name
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_depot_location_list.php'); ?>"
                href="adm_depot_location_list.php"> Depot Location
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_confirm.php'); ?>"
                href="adm_seized_confirm.php"> Seized Info
                Update</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/adm_seized_report.php'); ?>"
                href="adm_seized_report.php"> Seized Report
                List</a>
            </li>


          </ul>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Sales Certificate Module">
          <a class="nav-link nav-link-collapse" data-toggle="collapse" href="#salesCertificatePages"
            data-parent="#exampleAccordion">
            <i class="fa fa-file-excel-o"></i>
            <span class="nav-link-text">Sales Certificate Module</span>
          </a>
          <ul class="sidenav-second-level collapse
          <?php echo isActive('/sc_list.php'); ?>
          <?php echo isActive('/sc_list_reissues.php'); ?>
          <?php echo isActive('/reissues_approval_lease.php'); ?>
          <?php echo isActive('/sc_adm_report.php'); ?>
          
          " id="salesCertificatePages">
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list.php'); ?>" href="sc_list.php"> Request List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_list_reissues.php'); ?>" href="sc_list_reissues.php">
                File Problem List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/reissues_approval_lease.php'); ?>"
                href="reissues_approval_lease.php"> Reissues
                List</a>
            </li>
            <li>
              <a class="fa fa-hand-o-right <?php echo isActManu('/sc_adm_report.php'); ?>" href="sc_adm_report.php"> Code
                Wise Report</a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <!--====================REASON CODE Module + SIZED Module+ SALE Certificate  =============================-->



    </ul>



    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" href="index.php?logout=true">
          <span style="color:yellow">
            <?php echo $_SESSION['user_name']; ?>
          </span>&nbsp;&nbsp;<i class="fa fa-fw fa-sign-out"></i>Logout
        </a>
      </li>

    </ul>
  </div>
</nav>