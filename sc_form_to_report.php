<!DOCTYPE html>
<html lang="bn">

<head>
	<meta charset="UTF-8">
	<title>ফরম-২১ </title>
	<link href="https://fonts.googleapis.com/css2?family=SutonnyMJ&display=swap" rel="stylesheet">

	<script src="https://code.jquery.com/jquery-3.7.1.min.js"
		integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<style>
		body {
			font-family: 'SutonnyMJ', sans-serif;
			padding: 5%;
			table-layout: auto;
			line-height: normal;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			font-size: 16px;
			background-color: transparent;
			/* padding: 5% !important; */
		}

		.footer {
			width: 100%;
			font-size: 14px;
		}

		td,
		th {
			padding: 6px;
			vertical-align: top;
			border: none;
		}

		tr,
		td {
			padding-bottom: 1px;
		}

		.form-title {
			font-size: 14px;
			font-weight: bold;
			text-align: center;
		}

		.form-subtitle {
			font-size: 14px;
			text-align: center;
			font-weight: bold;

		}

		.field-label {
			display: inline-block;
			vertical-align: top;
		}

		.field-dots {
			display: inline-block;
			width: calc(100% - 220px);
			border-bottom: 1px dotted #000;
			margin-top: 3%;
		}

		@media print {
			.printableArea {
				display: none !important;
			}

			table {
				font-size: 14px;
			}

			footer {
				font-size: 14px;
			}
		}
	</style>
</head>

<body>
	<?php
	require_once('inc/connoracle.php');
	$sc_id = $_REQUEST['sc_id'];
	$is_found = 0;
	$strSQL = oci_parse($objConnect, "SELECT 
									   ID, 
									   REF_CODE, 
									   CURRENT_PARTY_NAME, 
									   CURRENT_PARTY_MOBILE, 
									   CURRENT_PARTY_ADDRS, 
									   MODEL_NAME, 
									   INSTALLMENT_RECEIVED, 
									   SALES_AMOUNT, 
									   DP, 
									   FIRST_PARTY_NAME, 
									   FIRST_PARTY_DP, 
									   FRIST_PARTY_INSTALLMENT_REC, 
									   RESOLED_DP, 
									   RESOLED_RECEIVED, 
									   RECEIVABLE, 
									   DISCOUNT, 
									   RECEIVED, 
									   CLOSING_DATE, 
									   RESALE_APPROVAL_DATE, 
									   REQUEST_DATE, 
									   REQUEST_BY, 
									   REQUESTER_NAME, 
									   REQUESTER_MOBILE, 
									   LEASE_APPROVAL_STATUS, 
									   LEASE_APPROVAL_DATE, 
									   LEASE_APPROVAL_BY, 
									   ACC_APPROVAL_DATE, 
									   ACC_APPROVAL_BY, 
									   ACC_APPROVAL_STATUS, 
									   CCD_APPROVAL_DATE, 
									   CCD_APPROVAL_BY, 
									   CCD_APPROVAL_STATUS, 
									   FILE_CLEAR_STATUS,
									   CLOSING_FEE,
									   BRTA_LOCATION,
									   RESPONSIBLE_PERSON,
									   RESPONSIBLE_DESIGNATION,
									   CUSTOMER_SO,
									   BANK_ID,
									   (select BANK_NAME from RML_COLL_CCD_BANK where ID=BANK_ID) AS BANK_NAME,
									   (select BANK_ADDRESS from RML_COLL_CCD_BANK where ID=BANK_ID) AS BANK_ADDRESS,
									   ENG_NO,CHASSIS_NO,REG_NO,
									   SYSDATE AS CURRENT_DATA_TIME,
									   FATHER_OR_HUSBAND_NAME 
									FROM RML_COLL_SC_CCD
									where ID='$sc_id'
									and CCD_APPROVAL_STATUS=1 
									and FILE_CLEAR_STATUS=1");
	oci_execute($strSQL);
	while ($row = oci_fetch_assoc($strSQL)) {
		$is_found = 1;
		$V_REF_CODE = $row['REF_CODE'];
		$V_CURRENT_PARTY_NAME = $row['CURRENT_PARTY_NAME'];
		$V_CURRENT_PARTY_MOBILE = $row['CURRENT_PARTY_MOBILE'];
		$V_CURRENT_PARTY_ADDRS = $row['CURRENT_PARTY_ADDRS'];
		$V_MODEL_NAME = $row['MODEL_NAME'];
		$V_INSTALLMENT_RECEIVED = $row['INSTALLMENT_RECEIVED'];
		$V_SALES_AMOUNT = $row['SALES_AMOUNT'];
		$V_DP = $row['DP'];
		$V_FIRST_PARTY_NAME = $row['FIRST_PARTY_NAME'];
		$V_FIRST_PARTY_DP = $row['FIRST_PARTY_DP'];
		$V_FRIST_PARTY_INSTALLMENT_REC = $row['FRIST_PARTY_INSTALLMENT_REC'];
		$V_RESOLED_DP = $row['RESOLED_DP'];
		$V_RESOLED_RECEIVED = $row['RESOLED_RECEIVED'];
		$V_RECEIVABLE = $row['RECEIVABLE'];
		$V_DISCOUNT = $row['DISCOUNT'];
		$V_RECEIVED = $row['RECEIVED'];
		$V_CLOSING_DATE = $row['CLOSING_DATE'];
		$V_RESALE_APPROVAL_DATE = $row['RESALE_APPROVAL_DATE'];
		$V_REQUEST_DATE = $row['REQUEST_DATE'];
		$V_REQUEST_BY = $row['REQUEST_BY'];
		$V_REQUESTER_NAME = $row['REQUESTER_NAME'];
		$V_REQUESTER_MOBILE = $row['REQUESTER_MOBILE'];
		$V_LEASE_APPROVAL_STATUS = $row['LEASE_APPROVAL_STATUS'];
		$V_LEASE_APPROVAL_DATE = $row['LEASE_APPROVAL_DATE'];
		$V_LEASE_APPROVAL_BY = $row['LEASE_APPROVAL_BY'];
		$V_ACC_APPROVAL_DATE = $row['ACC_APPROVAL_DATE'];
		$V_ACC_APPROVAL_BY = $row['ACC_APPROVAL_BY'];
		$V_ACC_APPROVAL_STATUS = $row['ACC_APPROVAL_STATUS'];
		$V_CCD_APPROVAL_DATE = $row['CCD_APPROVAL_DATE'];
		$V_CCD_APPROVAL_BY = $row['CCD_APPROVAL_BY'];
		$V_CCD_APPROVAL_STATUS = $row['CCD_APPROVAL_STATUS'];
		$V_FILE_CLEAR_STATUS = $row['FILE_CLEAR_STATUS'];
		$V_CLOSING_FEE = $row['CLOSING_FEE'];
		$V_BRTA_LOCATION = $row['BRTA_LOCATION'];
		$V_RESPONSIBLE_PERSON = $row['RESPONSIBLE_PERSON'];
		$V_RESPONSIBLE_DESIGNATION = $row['RESPONSIBLE_DESIGNATION'];
		$V_CUSTOMER_SO = $row['CUSTOMER_SO'];
		$V_BANK_ID = $row['BANK_ID'];
		$V_ENG_NO = $row['ENG_NO'];
		$V_CHASSIS_NO = $row['CHASSIS_NO'];
		$V_REG_NO = $row['REG_NO'];
		$V_SYSDATE = $row['CURRENT_DATA_TIME'];
		$V_BANK_NAME = $row['BANK_NAME'];
		$V_BANK_ADDRESS = $row['BANK_ADDRESS'];
		$V_FATHER_OR_HUSBAND_NAME = $row['FATHER_OR_HUSBAND_NAME'];
	}
	?>
	<div style="display: block;text-align:right">
		<button type="button" class="printableArea" onclick="printDiv('printableArea')">Print ফরম-২১ File</button>
	</div>
	<div id="printableArea">
		<div style="margin-bottom: 5%;">
			<div class="form-title">ফরম-২১</div>
			<div class="form-subtitle">মোটরযানের মালিকানা বদলি সংক্রান্ত ক্রেতার ঘোষণাপত্র <br>[বিধি ৪১(১) দ্রষ্টব্য]
			</div>
		</div>

		<table class="table">
			<tr>
				<td style="width:21%;" class="field-label">রেজিস্ট্রেশন কর্তৃপক্ষ:</td>
				<td style="width: 75%;font-family: arial,serif;margin-top:0% !important" colspan="4" class="field-dots">
					BRTA, <?= $V_BRTA_LOCATION ?>
				</td>
			</tr>
			<tr>
				<td style="width:13%;" class="field-label">আমি/আমরা:</td>
				<td style="width:83%;font-family: arial,serif;margin-top:0% !important" colspan="4" class="field-dots">
					RANGS MOTORS LTD.
				</td>
			</tr>
			<tr>
				<td class="field-label" style="width: 23%;">জাতীয় পরিচয়পত্র নম্বর:</td>
				<td class="field-dots" style="width: 29%;"></td>
				<td class="field-label" style="width: 15%;">টিআইএন নম্বর:</td>
				<td class="field-dots" style="width: 25%;"></td>
			</tr>
			<tr>
				<td style="width:5%;" class="field-label">মাতা:</td>
				<td style="width: 91%;" colspan="4" class="field-dots">
				</td>
			</tr>
			<tr>
				<td style="width:11%;" class="field-label">পিতা/স্বামী:</td>
				<td style="width: 85%;" colspan="4" class="field-dots">
				</td>
			</tr>
			<tr>
				<td style="width:7%;" class="field-label">ঠিকানা:</td>
				<td style="width: 89%;font-family: arial,serif;margin-top:0% !important" colspan="4" class="field-dots">
					117/A,(LEVEL-4),OLD
					AIRPORT ROAD,BIJOY
					SHARANI,TEJGAON,DHAKA. </td>
			</tr>
			<tr>
				<td style="width: 96%;margin-left: 2%;" class="field-dots">
				</td>
			</tr>
			<tr>
				<td>এতদ্বারা জানাইতেছি যে, মোটরযান যাহার:
				</td>
			</tr>
			<tr>
				<td class="field-label" style="width: 18%;">রেজিস্ট্রেশন নম্বর:</td>
				<td class="field-dots" style="width: 38%;font-family: arial,serif;margin-top:0% !important">
					<?php echo $V_REG_NO; ?>
				</td>
				<td class="field-label" style="width: 5%;">ধরন:</td>
				<td class="field-dots" style="width: 31%;"></td>
			</tr>
			<!-- <tr>
				<td class="field-label" style="width: 18%;">রেজিস্ট্রেশন নম্বর:</td>
				<td class="field-dots" style="width: 38%;"></td>
				<td class="field-label" style="width: 5%;">ধরন:</td>
				<td class="field-dots" style="width: 31%;"></td>
			</tr> -->
			<!-- <tr>
				<td class="field-label" style="width: 12%;">চেসিস নম্বর:</td>
				<td class="field-dots" style="width: 34%;"></td>
				<td class="field-label" style="width: 12%;">
					ইঞ্জিন নম্বর:</td>
				<td class="field-dots" style="width: 34%;"></td>
			</tr> -->
			<tr>
				<td class="field-label" style="width: 12%;">চেসিস নম্বর:</td>
				<td class="field-dots" style="width: 34%;font-family: arial,serif;margin-top:0% !important">
					<?php echo $V_CHASSIS_NO; ?>
				</td>
				<td class="field-label" style="width: 12%;">
					ইঞ্জিন নম্বর:</td>
				<td class="field-dots" style="width: 34%;font-family: arial,serif;margin-top:0% !important">
					<?php echo $V_ENG_NO; ?>
				</td>
			</tr>
			<tr>
				<td class="field-label" style="width: 12%;">প্রস্তুতকারক:</td>
				<td class="field-dots" style="width: 38%;"></td>
				<td class="field-label" style="width: 10%;">প্রস্তুতকাল:</td>
				<td class="field-dots" style="width: 32%;"></td>
			</tr>
			<tr>
				<td>নিম্নবর্ণিত ব্যক্তির নিকট হইতে ক্রয় করিয়াছি:
				</td>
			</tr>
			<tr>
				<td style="width:7%;" class="field-label">জনাব:</td>
				<td style="width: 89%;font-family: arial,serif;margin-top:0% !important" colspan="4" class="field-dots">
					<?php echo $V_BANK_NAME; ?>
				</td>
			</tr>
			<tr>
				<td style="width:11%;" class="field-label">পিতা/স্বামী:</td>
				<td style="width: 85%;font-family: arial,serif;" colspan="4" class="field-dots">

				</td>
			</tr>
			<tr>
				<td style="width:7%;" class="field-label">ঠিকানা:</td>
				<td style="width: 89%;font-family: arial,serif;margin-top:0% !important" colspan="4" class="field-dots">
					<?php echo ucwords(strtolower(substr($V_BANK_ADDRESS, 0, 87))) ?>
				</td>
			</tr>
			<tr>
				<td style="width: 96%;margin-left: 2%;font-family: arial,serif;" class="field-dots">
					<?php echo ucwords(strtolower(substr($V_BANK_ADDRESS, 87, 170))) ?>
				</td>
			</tr>
			<tr>
				<td class="field-dots" style="width: 43%;"></td>
				<td class="field-label">উপরে বর্ণিত মোটরযানটির মালিকানা আমার/আমাদের</td>
			</tr>
			<tr>
				<td style="width: 96%;line-height: 25px;" class="field-label">অনুকূলে বদলি তথা
					রেজিস্ট্রেশন করিবার অনুরোধ জানাইতেছি এবং মোটরযানের রেজিস্ট্রেশন সনদ, হালনাগাদ ফিটনেস সনদ, ট্যাক্স
					টোকেন, রুট পারমিট (প্রযোজ্য ক্ষেত্রে) সংযুক্ত করিলাম।</td>
			</tr>

		</table>
		<!-- display: flex;justify-content: space-between; -->
		<div class="footer" style="display: flex;justify-content: left;margin-top: 5%;">
			<p>তারিখ: </p>

		</div>
		<div class="footer" style="display: flex;justify-content: right;text-align: center;">
			<p>গ্রহীতার (ক্রেতা) স্বাক্ষর <br>ভাড়া খরিদ/দায়বদ্ধ মালিকের স্বাক্ষর
			</p>

		</div>
	</div>

	<script type="text/javascript">
		function printDiv(divName) {
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
	</script>

</body>

</html>