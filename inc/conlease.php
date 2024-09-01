 <?php
 
      $serverName = "192.168.172.9";
	  $connectionInfo = array( "Database"=>"RangsLeasingBeta1000", "UID"=>"sa", "PWD"=>"Pass#9805");
	  $objConnect = sqlsrv_connect( $serverName, $connectionInfo);
    If (!$objConnect)
        echo 'Failed to connect to Lease and Credit Software';
?>