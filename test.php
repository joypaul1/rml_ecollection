<?php
 $movie_name = urlencode('MP19Big 00095');						
 $url = 'http://202.40.181.98:8090/rml/rml/lease/lease_api1/'. $movie_name;
 echo $url;
 //$url = 'http://202.40.181.98:8090/rml/rml/lease/lease_api1/M319Alfa13371';
 

 //$json = file_get_contents($url);
 @$json = file($url);
 @$shamim=json_decode($json[0], true);
 //echo '<pre>';
 //print_r($shamim);
 //echo '</pre>';
 //
 echo "<br>";
 
 //echo '<pre>';
// print_r($shamim[items][0]);
 //echo '</pre>';
 
 echo @$shamim[items][0]['ref_code'];
 
//$character = json_decode($json);
//echo $character->next;

							
?>