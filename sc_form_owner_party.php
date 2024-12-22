<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner's Particulars Form</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 5% !important;
            margin: 8%;
            margin-bottom: 0% !important;
            font-size: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 6px;
            vertical-align: top;
            border: none;
            /* Removed the border */
        }

        tr,
        td {
            padding-bottom: 1px;
        }

        .serial-number {
            font-size: 10px;
            font-weight: bold;
            /* text-align: right; */
            width: 5%;
        }

        .label {
            font-size: 11px;
            text-align: left;
            width: 45%;
        }

        .blank {
            width: 50%;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: -9%;
            gap: 1%;
        }


        .header {
            text-align: center;
            /* margin-right: 5%; */
        }

        .header p {
            margin: 0;
            padding: 0;
        }

        .header p:first-child {
            font-weight: bold;
        }


        .photo-box {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
            font-size: 11px;
            line-height: 1.3;
            width: 100px;
            height: 60px;
        }

        .signature-section {
            padding: 10px;
            padding-bottom: 0 !important;
        }

        .signature-heading {
            font-weight: bold;
            font-size: 14px;
        }

        .signature-box {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            /* Space between boxes */
        }

        .signature-box div {
            width: 40%;
            height: 40px;
            border: 1px solid #000;
            line-height: 40px;
            text-align: left;
            font-weight: bold;
        }

        .footer-remark {
            font-size: 10px;
        }

        @media print {
            .printableArea {
                display: none !important;
            }

            @page {
                size: A4 portrait;
            }

            /* body {
                margin-top: 5% !important;
                margin: 8%;
                font-size: 8px;
            } */
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
    <div style="display:block;text-align:end">
        <button type="button" class="printableArea" onclick="printDiv('printableArea')">Print Ownership Info.
            File</button>
    </div>

    <div id="printableArea">
        <div class="container">
            <div class="header">
                <p style="font-size: 16px;">OWNER'S PARTICULARS/SPECIMEN SIGNATURE</p>
                <p style="font-size: 12px;">মালিকের ব্যক্তিগত তথ্যাবলি/নমুনা স্বাক্ষর</p>
                <p style="margin-top: 5px;font-size: 15px;">(For Vehicle Registration or Ownership Transfer)</p>
                <p style="font-size: 12px;">(মোটরযান রেজিস্ট্রেশন বা মালিকানা হস্তান্তরের ক্ষেত্রে)</p>
            </div>
            <!-- Photo Box Section -->
            <div class="photo-box">
                ৩ কপি রঙিন ছবি /<br> 3 copies colour photo
            </div>
        </div>
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td class="serial-number">১।</td>
                <td class="label">NAME (CAPITAL LETTER)
                    <br> নাম (স্পষ্ট অক্ষরে)
                </td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">: <span style="font-weight: 500;font-size: 11px;">RANGS MOTORS LTD.</span></span>
                </td>
            </tr>
            <tr>
                <td class="serial-number">২।</td>
                <td class="label">FATHER'S NAME<br> পিতার নাম</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">৩।</td>
                <td class="label">MOTHER'S NAME<br> মাতার নাম</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">৪।</td>
                <td class="label">HUSBAND/WIFE NAME<br> স্বামী/স্ত্রীর নাম</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">৫।</td>
                <td class="label">PRESENT ADDRESS (WITH SUPPORTING DOCUMENTS)<br> বর্তমান ঠিকানা (প্রমাণকসহ)</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">: <span style="font-weight: 500;font-size: 11px;">117/A,(LEVEL-4),OLD AIRPORT
                            ROAD,BIJOY SHARANI, TEJGAON,DHAKA.</span></span></td>
            </tr>
            <tr>
                <td class="serial-number">৬।</td>
                <td class="label">PERMANENT ADDRESS<br> স্থায়ী ঠিকানা</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">৭।</td>
                <td class="label">SEX<br> জেন্ডার</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">৮।</td>
                <td class="label">CELL PHONE NO<br> মোবাইল নম্বর</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">৯।</td>
                <td class="label">NATIONALITY<br> জাতীয়তা</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">১০।</td>
                <td class="label">DATE OF BIRTH<br> জন্ম তারিখ</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">১১।</td>
                <td class="label">NID NO. (WITH COPY)<br> জাতীয় পরিচয় পত্রের নম্বর (ছায়ালিপি সংযুক্ত)</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">১২।</td>
                <td class="label">e-TIN NO. (WITH COPY)<br> ই-টিআইএন নম্বর (ছায়ালিপি সংযুক্ত করতে হবে)</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">১৩।</td>
                <td class="label">GUARDIAN'S NAME (In case of Minor)<br> অভিভাবকের নাম (যদি থাকে)</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">১৪।</td>
                <td class="label">VEHICLE REGISTRATION NO <br>
                    (In case of ownership transfer) <br>
                    মটরযানের রেজিঃ নম্বর (মালিকানা হস্তান্তরের ক্ষেত্রে)
                </td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">: <span style="font-weight: 500;font-size: 11px;"><?= $V_REG_NO ?></span></span>
                </td>
            </tr>
            <tr>
                <td class="serial-number">১৫।</td>
                <td class="label">ENGINE NO<br> ইঞ্জিন নম্বর</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">: <span style="font-weight: 500;font-size: 11px;"><?= $V_ENG_NO ?></span> </span>
                </td>
            </tr>
            <tr>
                <td class="serial-number">১৬।</td>
                <td class="label">CHASSIS NO<br> চেসিস নম্বর</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">: <span style="font-weight: 500;font-size: 11px;"><?= $V_CHASSIS_NO ?></span></span>
                </td>
            </tr>
            <tr>
                <td class="serial-number">১৭।</td>
                <td class="label">YEAR OF MFG OF VEHICLE<br> তৈরির সন</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">১৮।</td>
                <td class="label">
                    PREV. REGISTRATION NO (If any)<br>
                    পূর্বের রেজিস্ট্রেশন নম্বর (যদি থাকে) <br>
                    (In case of Reconditioned vehicle/Special Registration) <br>
                    (রিকন্ডিশনড মোটরযান/বিশেষ রেজিস্ট্রেশনপ্রাপ্ত মোটরযানের ক্ষেত্রে)
                </td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
            <tr>
                <td class="serial-number">১৯।</td>
                <td class="label">BANK NAME FOR Fee/Tax Deposit<br> ফি/কর গ্রহণকারী ব্যাংকের নাম :</td>
                <td class="blank"><span style="text-align: left;
                display: block;
                font-weight: 800;">:</span></td>
            </tr>
        </table>

        <!-- Specimen Signature Section -->
        <div class="signature-section">
            <div class="signature-heading">SPECIMEN SIGNATURE (নমুনা স্বাক্ষর)</div>
            <div class="signature-box">
                <div>১।</div>
                <div>২।</div>
                <div>৩।</div>
                <div>৪।</div>
            </div>
            <p class="footer-remark">
                বি: দ্র: সরকারি/আধাসরকারি/স্বায়ত্তশাসিত এইরূপ প্রতিষ্ঠানে যাদের NID ও TIN নেই,
                সে প্রতিষ্ঠানের ক্ষমতাপ্রাপ্ত ব্যক্তির NID এর কপি দাখিল করিতে হইবে এবং তাহাকে সংশ্লিষ্ট
                আবেদনপত্রে ও উপরের ঘরে স্বাক্ষর করিতে হইবে।
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