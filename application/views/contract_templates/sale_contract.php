<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Property Sale Agreement</title>
</head>

<body>

    <style>
        /*
    |--------------------------------------------------------------------------
    | DOMPDF - TRUE A4 PORTRAIT PAGE
    |--------------------------------------------------------------------------
    | The screenshots are sections of ONE portrait A4 page.
    | A4 = 210mm × 297mm.
    |--------------------------------------------------------------------------
    */

        @page {
            size: 210mm 297mm;
            margin: 7mm 7mm 6mm 7mm;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 5px !important;
            padding: 5px !important;
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            line-height: 1.04;
            color: #000;
        }

        .container {
            width: 196mm;
            margin: 0 auto;
            padding: 0;
        }

        .page {
            width: 196mm;
            height: 284mm;
            min-height: 284mm;
            max-height: 284mm;
            margin: 0;
            padding: 0;
            overflow: hidden;

            page-break-after: always;
            page-break-inside: avoid;
        }

        /* -------------------------------------------------------------
       COPYRIGHT
    ------------------------------------------------------------- */

        .copyright {
            width: 96%;
            margin: 0 auto 1.5mm auto;
            padding: 0;
            text-align: center;
            font-size: 7.7px;
            line-height: 1.05;
        }

        /* -------------------------------------------------------------
       MAIN TITLE
    ------------------------------------------------------------- */

        .document-title {
            margin: 0 0 1mm 0;
            padding: 0;
            text-align: center;
            font-size: 23px;
            line-height: 1;
            font-weight: bold;
        }

        /* -------------------------------------------------------------
       GENERAL TABLE SETTINGS
    ------------------------------------------------------------- */

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        td,
        th {
            line-height: 1.04;
        }

        .no-border-table,
        .no-border-table tr,
        .no-border-table td,
        .no-border-table th {
            border: none !important;
        }

        /* -------------------------------------------------------------
       TOP CONTRACT DETAILS TABLE
    ------------------------------------------------------------- */

        .main-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .main-table td {
            padding: 0.7mm 0.5mm;
            vertical-align: top;
            font-size: 10.5px;
        }

        .term-col {
            width: 22%;
        }

        .meaning-col {
            width: 50%;
        }

        .contact-col {
            width: 28%;
        }

        .header-cell {
            padding-top: 0 !important;
            padding-bottom: 0.7mm !important;
            text-align: center;
            font-size: 11px !important;
            line-height: 1;
            font-weight: bold;
        }

        .term {
            padding-left: 0 !important;
            font-size: 10.5px !important;
            font-weight: normal;
        }

        .value {
            font-size: 10.5px !important;
            line-height: 1.03;
            font-weight: bold;
        }

        .normal {
            font-weight: normal;
        }

        .contact-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .contact-table td {
            padding: 0 !important;
            font-size: 10px !important;
            line-height: 1.02;
            font-weight: bold;
        }

        .contact-label {
            width: 35%;
        }

        .contact-value {
            width: 65%;
        }

        .space-small td {
            padding-top: 1.4mm !important;
        }

        .space-medium td {
            padding-top: 1.8mm !important;
        }

        .land-lines {
            line-height: 1.03;
        }

        /* -------------------------------------------------------------
       CHECKBOXES
    ------------------------------------------------------------- */

        .checkbox {
            display: inline-block;
            position: relative;
            width: 10px;
            height: 10px;
            margin-right: 3px;
            border: 1px solid #000;
            vertical-align: -1.5px;
        }

        .checkbox.checked:before,
        .checkbox.checked:after {
            content: "";
            position: absolute;
            left: 4px;
            top: -1px;
            width: 1px;
            height: 11px;
            background: #000;
        }

        .checkbox.checked:before {
            transform: rotate(45deg);
        }

        .checkbox.checked:after {
            transform: rotate(-45deg);
        }

        /* -------------------------------------------------------------
       OPTIONS
    ------------------------------------------------------------- */

        .option-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        .option-table td {
            padding: 0.3mm 1.8mm 0.3mm 0;
            vertical-align: middle;
            white-space: nowrap;
            font-size: 10.5px !important;
            line-height: 1.03;
            font-weight: normal;
        }

        .wide-options {
            padding-top: 1.5mm !important;
        }

        .improvements-row td {
            padding-top: 0.5mm !important;
        }

        .attached-row td {
            padding-top: 0.5mm !important;
        }

        .attached-content {
            font-size: 10.5px !important;
            line-height: 1.03;
        }

        .attached-line {
            margin: 0;
            padding: 0;
        }

        .other-documents {
            margin-left: 51mm;
            line-height: 1;
        }

        /* -------------------------------------------------------------
       FORCE INLINE 16PX VALUES TO MATCH A4 DOCUMENT
    ------------------------------------------------------------- */

        .page table td {
            font-size: 10.5px !important;
        }

        .page div {
            line-height: 1.04;
        }

        /* -------------------------------------------------------------
       REAL ESTATE AGENT BOX
    ------------------------------------------------------------- */

        .page>div[style*="border:2px"] {
            margin-top: 1mm !important;
            padding: 1.5mm 2mm 1mm 2mm !important;
            border: 1.5px solid #000 !important;

            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 10.5px !important;
            line-height: 1.04 !important;
        }

        .page>div[style*="border:2px"]>div:first-child {
            margin: 0 0 1mm 0 !important;
            font-size: 11px !important;
            line-height: 1.02 !important;
            font-weight: bold;
        }

        .page>div[style*="border:2px"] table td {
            font-size: 10.5px !important;
            line-height: 1.04 !important;
        }

        /* Inclusions "other" text */
        .page>div[style*="border:2px"] td[colspan="4"] {
            line-height: 1.08 !important;
        }

        /* -------------------------------------------------------------
       PURCHASER / SOLICITOR / PRICE AREA
    ------------------------------------------------------------- */

        .page td[style*="padding-top:7px"] {
            padding-top: 1.5mm !important;
        }

        .page td[style*="padding-top:10px"] {
            padding-top: 2.5mm !important;
        }

        .page td[style*="padding-top:28px"] {
            padding-top: 8mm !important;
        }

        .page td[style*="padding-left:55px"] {
            padding-left: 13mm !important;
        }

        /* -------------------------------------------------------------
       SIGNATURE AREA
    ------------------------------------------------------------- */

        .page>table[style*="margin-top:34px"] {
            width: 100% !important;
            margin-top: 8mm !important;
            font-size: 10.5px !important;
            line-height: 1 !important;
        }

        .page>table[style*="margin-top:34px"] td {
            font-size: 10.5px !important;
        }

        .page td[style*="height:58px"] {
            height: 14mm !important;
        }

        .page div[style*="min-height:52px"] {
            min-height: 13mm !important;
            padding: 1mm 1.5mm !important;
            font-size: 10px !important;
            line-height: 1.02 !important;
        }

        .page div[style*="min-height:52px"] div {
            font-size: 10px !important;
            line-height: 1.02 !important;
        }

        /* -------------------------------------------------------------
       TAX INFORMATION
    ------------------------------------------------------------- */

        .page>div:last-child {
            margin-top: 2mm !important;
            padding: 0 !important;
            font-size: 10.5px !important;
            line-height: 1.03 !important;
        }

        .page>div:last-child>div:first-child {
            margin: 0 0 1mm 0 !important;
            padding: 0 !important;
            text-align: center;
            font-size: 11px !important;
            line-height: 1.02 !important;
            font-weight: bold;
        }

        .page>div:last-child table {
            width: 100%;
            border-collapse: collapse;
        }

        .page>div:last-child table td {
            padding-top: 0.25mm;
            padding-bottom: 0.25mm;
            font-size: 10.5px !important;
            line-height: 1.03 !important;
        }

        /* -------------------------------------------------------------
       HOLDER OF STRATA / COMMUNITY TITLE RECORDS
    ------------------------------------------------------------- */

        .page div[style*="min-height:50px"] {
            min-height: 11mm !important;
            margin-top: 2mm !important;
            padding: 1mm 2mm !important;
            border: 1px solid #000 !important;
        }

        .page div[style*="min-height:50px"] strong {
            font-size: 10.5px !important;
            line-height: 1.02 !important;
        }

        /* -------------------------------------------------------------
       DOMPDF PAGE-BREAK CONTROL
    ------------------------------------------------------------- */

        .page,
        .main-table,
        .contact-table,
        .option-table,
        .page>div,
        .page>table,
        tr,
        td {
            page-break-inside: avoid;
        }
    </style>

    <div class="container">
        <!-- page 1 starts -->
        <div class="page">
            <div class="copyright"> © 2005 COPYRIGHT&nbsp; The Law Society of New South Wales and The Real Estate Institute of New South Wales.&nbsp; You can prepare your own version of <br> pages 1 and 2 on a computer or typewriter, and you can reproduce this form (or part of it) for educational purposes, but any other reproduction of this form <br> (or part of it) is an infringement of copyright unless authorised by the copyright holders or legislation. </div>
            <div class="document-title"> Contract for the sale of land – 2005 edition </div>
            <table class="main-table no-border-table">
                <colgroup>
                    <col class="term-col">
                    <col class="meaning-col">
                    <col class="contact-col">
                </colgroup>
                <tr>
                    <td class="header-cell">TERM</td>
                    <td class="header-cell" colspan="2">MEANING OF TERM</td>
                </tr>
                <tr>
                    <td class="term">Vendor’s agent</td>
                    <td class="value"> Raine &amp; Horne Double Bay <br> 385 New South Head Road, Double Bay, NSW 2028 </td>
                    <td>
                        <table class="contact-table">
                            <tr>
                                <td class="contact-label">Phone:</td>
                                <td class="contact-value">(02) 9327 7971</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="space-small">
                    <td class="term">Co-agent</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="term">Vendor</td>
                    <td class="value"> Edda Unewisse and Kurt Unewisse <br> 35 Boonah Avenue, Eastgardens </td>
                    <td></td>
                </tr>
                <tr class="space-small">
                    <td class="term">Vendor’s Solicitor</td>
                    <td class="value"> Key Property Lawyers <br> PO Box 1398, Bondi Junction 1355 NSW </td>
                    <td>
                        <table class="contact-table">
                            <tr>
                                <td class="contact-label">Phone:</td>
                                <td class="contact-value">0403 529 937</td>
                            </tr>
                            <tr>
                                <td class="contact-label">Fax:</td>
                                <td class="contact-value">(02) 9343 0043</td>
                            </tr>
                            <tr>
                                <td class="contact-label">Ref:</td>
                                <td class="contact-value">NS:14/1299</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="space-medium">
                    <td class="term">Completion date</td>
                    <td colspan="2" class="value"> 42nd day after the date of this contract <span class="normal">(clause 15)</span>
                    </td>
                </tr>
                <tr>
                    <td class="term"> Land <br>
                        <span class="normal">(Address, plan details <br>and title reference) </span>
                    </td>
                    <td colspan="2" class="value land-lines"> 35 Boonah Avenue, Eastgardens 2036 <br> Registered Plan: Lot&nbsp; 1 Plan DP 383 654 <br> Folio Identifier 1/383654 </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" class="wide-options">
                        <table class="option-table">
                            <tr>
                                <td>
                                    <span class="checkbox checked"></span>VACANT POSSESSION
                                </td>
                                <td>
                                    <span class="checkbox"></span>subject to existing tenancies
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="improvements-row">
                    <td class="term">Improvements</td>
                    <td colspan="2">
                        <table class="option-table">
                            <tr>
                                <td>
                                    <span class="checkbox checked"></span>HOUSE
                                </td>
                                <td>
                                    <span class="checkbox checked"></span>garage
                                </td>
                                <td>
                                    <span class="checkbox"></span>carport
                                </td>
                                <td>
                                    <span class="checkbox"></span>home unit
                                </td>
                                <td>
                                    <span class="checkbox checked"></span>carspace
                                </td>
                                <td>
                                    <span class="checkbox"></span>none
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <span class="checkbox"></span>other:
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="attached-row">
                    <td class="term">Attached copies</td>
                    <td colspan="2" class="attached-content">
                        <div class="attached-line">
                            <span class="checkbox checked"></span> Documents in the List of Documents as marked or as numbered:
                        </div>
                        <div class="other-documents">
                            <span class="checkbox"></span>Other documents:
                        </div>
                    </td>
                </tr>
            </table>
            <div style="border:2px solid #000; padding:6px 10px 4px 10px; font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:1.08;">
                <div style="font-weight:bold; font-size:17px; margin-bottom:4px;"> A real estate agent is permitted by <em>legislation</em> to fill up the items in this box in a sale of residential property. </div>
                <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                    <tr>
                        <td style="width:22%; vertical-align:top; font-size:16px;">Inclusions</td>
                        <td style="width:78%; vertical-align:top;">
                            <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                                <tr>
                                    <td style="width:25%; white-space:nowrap;">
                                        <span class="checkbox checked"></span>blinds
                                    </td>
                                    <td style="width:28%; white-space:nowrap;">
                                        <span class="checkbox checked"></span>curtains
                                    </td>
                                    <td style="width:22%; white-space:nowrap;">
                                        <span class="checkbox"></span>insect screens
                                    </td>
                                    <td style="width:25%; white-space:nowrap;">
                                        <span class="checkbox"></span>stove
                                    </td>
                                </tr>
                                <tr>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox checked"></span>built-in wardrobes
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox checked"></span>dishwasher
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox checked"></span>light fittings
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox"></span>pool equipment
                                    </td>
                                </tr>
                                <tr>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox checked"></span>clothes line
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox checked"></span>fixed floor coverings
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox checked"></span>range hood
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox"></span>TV antenna
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding-top:2px; line-height:1.2;">
                                        <span class="checkbox checked"></span> other:&nbsp; Wall air-conditioner, garden corner bench and table, groundwater pump, bird <br> bath, build in shelves in living room, workbench and machinery in garage, kitchen corner <br> bench, Wardrobe in bedroom, pot plants, washing machine in internal laundry, shelves in <br> spare bedroom
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:7px; font-size:16px;">Exclusions</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-top:10px; font-size:16px;">Purchaser</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-top:28px; font-size:16px;">Purchaser’s solicitor</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:28px;">
                            <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                                <tr>
                                    <td style="width:22%; font-size:16px;">Price</td>
                                    <td style="width:4%; font-size:16px; font-weight:bold;">$</td>
                                    <td style="width:74%;"></td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;">Deposit</td>
                                    <td style="font-size:16px; font-weight:bold; border-bottom:1px solid #000;">$</td>
                                    <td style="font-size:16px; padding-left:55px;"> (10% of the price, unless otherwise stated) </td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;">Balance</td>
                                    <td style="font-size:16px; font-weight:bold;">$</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;">Contract date</td>
                                    <td></td>
                                    <td style="font-size:16px; text-align:right;"> (if not stated, the date this contract was made) </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <table style="width:100%; border-collapse:collapse; table-layout:fixed; margin-top:34px; font-family:Arial, Helvetica, sans-serif; font-size:16px;">
                <tr>
                    <td style="width:42%; vertical-align:top;">
                        <div style="border-top:1px solid #000; padding-top:3px; font-weight:bold;"> Vendor </div>
                    </td>
                    <td style="width:16%;"></td>
                    <td style="width:42%; vertical-align:top;">
                        <div style="border-top:1px solid #000; padding-top:3px; text-align:right; font-weight:bold;"> Witness </div>
                    </td>
                </tr>
                <tr>
                    <td style="height:58px;"></td>
                    <td style="vertical-align:top;">
                        <div style="border:1px dotted #000; padding:2px 8px 3px 8px; min-height:52px;">
                            <div style="font-weight:bold; font-size:16px;"> GST AMOUNT <span style="font-weight:normal;">(optional)</span>
                            </div>
                            <div>The price includes</div>
                            <div>GST of:</div>
                        </div>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">
                        <div style="border-top:1px solid #000; padding-top:3px; font-weight:bold;"> Purchaser </div>
                    </td>
                    <td colspan="2" style="vertical-align:top;">
                        <table style="width:100%; border-collapse:collapse; table-layout:auto;">
                            <tr>
                                <td style="white-space:nowrap; padding-left:6px;">
                                    <span class="checkbox"></span>JOINT TENANTS
                                </td>
                                <td style="white-space:nowrap; padding-left:8px;">
                                    <span class="checkbox"></span>tenants in common
                                </td>
                                <td style="white-space:nowrap; padding-left:8px;">
                                    <span class="checkbox"></span>in unequal shares
                                </td>
                                <td style="width:100%; border-top:1px solid #000; text-align:right; padding-top:3px; font-weight:bold;"> Witness </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:1.08;">
                <div style="text-align:center; font-weight:bold; font-size:17px; margin-bottom:3px;"> Tax information (the parties promise this is correct as far as each party is aware) </div>
                <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                    <tr>
                        <td style="width:51%; vertical-align:top;">
                            <strong>Land tax</strong> is adjustable
                        </td>
                        <td style="width:11%; vertical-align:top; white-space:nowrap;">
                            <span class="checkbox checked"></span>NO
                        </td>
                        <td style="width:38%; vertical-align:top; white-space:nowrap;">
                            <span class="checkbox"></span>yes
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">
                            <strong>GST:</strong>&nbsp; Taxable supply
                        </td>
                        <td style="vertical-align:top; white-space:nowrap;">
                            <span class="checkbox checked"></span>NO
                        </td>
                        <td style="vertical-align:top;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <td style="white-space:nowrap; padding-right:30px;">
                                        <span class="checkbox"></span>yes in full
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <span class="checkbox"></span>yes to an extent
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;"> Margin scheme will be used in making the taxable supply </td>
                        <td style="vertical-align:top; white-space:nowrap;">
                            <span class="checkbox"></span>NO
                        </td>
                        <td style="vertical-align:top; white-space:nowrap;">
                            <span class="checkbox"></span>yes
                        </td>
                    </tr>
                </table>
                <div style="margin-top:2px; margin-bottom:2px;"> This sale is not a taxable supply because (one or more of the following may apply) the sale is: </div>
                <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                    <tr>
                        <td style="width:5%;"></td>
                        <td style="width:95%; vertical-align:top;">
                            <span class="checkbox checked"></span> not made in the course or furtherance of an enterprise that the vendor carries on (section 9-5(b))
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span> by a vendor who is neither registered nor required to be registered for GST (section 9-5(d))
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span> GST-free because the sale is the supply of a going concern under section 38-325
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span> GST-free because the sale is subdivided farm land or farm land supplied for farming under Subdivision 38-O
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span> input taxed because the sale is of eligible residential premises (sections 40-65, 40-75(2) and 195-1)
                        </td>
                    </tr>
                </table>
                <div style="border:1px solid #000; min-height:50px; margin-top:7px; padding:3px 10px;">
                    <strong style="font-size:16px;"> HOLDER OF STRATA OR COMMUNITY TITLE RECORDS – Name, address and telephone number </strong>
                </div>
            </div>
        </div>
        <!-- page 1 ends -->
        <!-- page 2 starts -->
        <div class="page">
            <div style="width:100%; position:relative; margin-bottom:2mm; font-family:Arial, Helvetica, sans-serif;">
                <div style="text-align:center; font-size:11px; line-height:1;"> 2 </div>
                <div style="position:absolute; right:0; top:0; font-size:10.5px; line-height:1;"> Land – 2005 edition </div>
            </div>
            <table style="
        width:100%;
        border-collapse:collapse;
        table-layout:fixed;
        font-family:Arial, Helvetica, sans-serif;
        font-size:10.5px;
        line-height:1.05;
        border:1px solid #000;
    ">
                <tr>
                    <!-- LEFT COLUMN -->
                    <td style="
                width:50%;
                vertical-align:top;
                border-right:1px solid #000;
                padding:1.5mm 2mm 1mm 2mm;
            ">
                        <div style="
                    font-weight:bold;
                    font-size:11px;
                    margin-bottom:2mm;
                    line-height:1;
                "> General </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox checked"></span> 1 property certificate for the land
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox checked"></span> 2 plan of the land
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 3 unregistered plan of the land
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 4 plan of land to be subdivided
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 5 document that is to be lodged with a relevant plan
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox checked"></span> 6 section 149(2) certificate (Environmental Planning <br>
                            <span style="margin-left:11mm;">and Assessment Act 1979)</span>
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 7 section 149(5) information included in that certificate
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox checked"></span> 8 sewerage connections diagram
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox checked"></span> 9 sewer mains diagram
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 10 document that created or may have created an <br>
                            <span style="margin-left:11mm;">easement, profit à prendre, restriction on use or</span>
                            <br>
                            <span style="margin-left:11mm;">positive covenant disclosed in this contract</span>
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 11 section 88G certificate (positive covenant)
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 12 survey report
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 13 section 317A certificate (certificate of compliance)
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 14 building certificate given under <em>legislation</em>
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 15 insurance certificate (Home Building Act 1989)
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 16 brochure or note (Home Building Act 1989)
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 17 section 24 certificate (Swimming Pools Act 1982)
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 18 lease (with every relevant memorandum or variation)
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 19 other document relevant to tenancies
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 20 old system document
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 21 Crown tenure card
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 22 Crown purchase statement of account
                        </div>
                        <div>
                            <span class="checkbox"></span>
                            <span style="text-decoration:line-through;"> 23 Statutory declaration regarding vendor duty </span>
                        </div>
                    </td>
                    <!-- RIGHT COLUMN -->
                    <td style="
                width:50%;
                vertical-align:top;
                padding:1.5mm 2mm 1mm 2mm;
            ">
                        <div style="
                    font-weight:bold;
                    font-size:11px;
                    margin-bottom:1mm;
                    line-height:1.05;
                "> Strata or community title (clause 23 of the contract) </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 24 property certificate for strata common property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 25 plan creating strata common property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 26 strata by-laws not set out in <em>legislation</em>
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 27 strata development contract or statement
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 28 strata management statement
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 29 leasehold strata - lease of lot and common property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 30 property certificate for neighbourhood property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 31 plan creating neighbourhood property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 32 neighbourhood development contract
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 33 neighbourhood management statement
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 34 property certificate for precinct property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 35 plan creating precinct property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 36 precinct development contract
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 37 precinct management statement
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 38 property certificate for community property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 39 plan creating community property
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 40 community development contract
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 41 community management statement
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 42 document disclosing a change of by-laws
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 43 document disclosing a change in a development <br>
                            <span style="margin-left:11mm;">or management contract or statement</span>
                        </div>
                        <div style="margin-bottom:1mm;">
                            <span class="checkbox"></span> 44 document disclosing a change in boundaries
                        </div>
                        <div>
                            <span class="checkbox"></span> 45 certificate under Management Act – section 109 <br>
                            <span style="margin-left:11mm;"> (Strata Schemes) or section 26 (Community Land) </span>
                        </div>
                    </td>
                </tr>
            </table>


            <!--
    FIXED WARNINGS SECTION
    The previous issue was caused by the number column consuming too much width.
    This version uses a fixed 7mm number column and the remaining width for content.
-->

            <div style="
    width:100%;
    margin-top:3mm;
    border:1px solid #000;
    font-family:Arial, Helvetica, sans-serif;
    font-size:10.5px;
    line-height:1.08;
">

                <div style="border:1px solid #000; font-family:Arial, Helvetica, sans-serif; font-size:10.5px; line-height:1.08; padding:1.5mm 2mm 2mm 2mm;">

                    <div style="text-align:center; font-weight:bold; font-size:11px; margin-bottom:1.5mm;">
                        WARNINGS
                    </div>

                    <!-- 1 -->
                    <div style="position:relative; padding-left:7mm; margin-bottom:1.2mm;">
                        <span style="position:absolute; left:0; top:0;">1.</span>

                        <div>
                            Various Acts of Parliament and other matters can affect the rights of the parties to this contract.
                            &nbsp;Some important matters are actions, claims, decisions, licences, notices, orders, proposals or rights of way involving
                        </div>

                        <div style="margin-top:1mm; overflow:hidden;">

                            <div style="float:left; width:29%;">
                                <div>AGL Gas Networks Limited</div>
                                <div>Council</div>
                                <div>County Council</div>
                                <div>East Australian Pipeline Limited</div>
                                <div>Education &amp; Training Dept</div>
                                <div>Electricity authority</div>
                                <div>Environment &amp; Conservation Dept</div>
                                <div>Fair Trading</div>
                            </div>

                            <div style="float:left; width:42%;">
                                <div>Government Business &amp; Government Procurement</div>
                                <div>Heritage Office</div>
                                <div>Infrastructure Planning and Natural Resources</div>
                                <div>Land &amp; Housing Corporation</div>
                                <div>Mine Subsidence Board</div>
                                <div>Owner of adjoining land</div>
                                <div>Primary Industries Department</div>
                                <div>RailCorp</div>
                            </div>

                            <div style="float:left; width:29%;">
                                <div>Public Works Dept</div>
                                <div>Roads &amp; Traffic Authority</div>
                                <div>Rural Lands Protection Board</div>
                                <div>Sustainable Energy Development</div>
                                <div>Telecommunications authority</div>
                                <div>Water, sewerage or drainage authority</div>
                            </div>

                            <div style="clear:both;"></div>
                        </div>

                        <div style="margin-top:1mm;">
                            If you think that any of these matters affects the property, tell your solicitor.
                        </div>
                    </div>

                    <!-- 2 -->
                    <div style="position:relative; padding-left:7mm; margin-bottom:1.2mm;">
                        <span style="position:absolute; left:0; top:0;">2.</span>
                        A lease may be affected by the Agricultural Tenancies Act 1990, the Residential Tenancies Act 1987 or the Retail Leases Act 1994.
                    </div>

                    <!-- 3 -->
                    <div style="position:relative; padding-left:7mm; margin-bottom:1.2mm;">
                        <span style="position:absolute; left:0; top:0;">3.</span>
                        If any purchase money is owing to the Crown, it may become payable when the transfer is registered.
                    </div>

                    <!-- 4 -->
                    <div style="position:relative; padding-left:7mm; margin-bottom:1.2mm;">
                        <span style="position:absolute; left:0; top:0;">4.</span>
                        If a consent to transfer is required under legislation, see clause 27 as to the obligations of the parties.
                    </div>

                    <!-- 5 -->
                    <div style="position:relative; padding-left:7mm; margin-bottom:1.2mm;">
                        <span style="position:absolute; left:0; top:0;">5.</span>
                        The vendor should continue the vendor’s insurance until completion. &nbsp;If the vendor wants to give the purchaser
                        possession before completion, the vendor should first ask the insurer to confirm this will not affect the insurance.
                    </div>

                    <!-- 6 -->
                    <div style="position:relative; padding-left:7mm; margin-bottom:1.2mm;">
                        <span style="position:absolute; left:0; top:0;">6.</span>

                        The purchaser will usually have to pay stamp duty on this contract. &nbsp;

                        <span style="text-decoration:line-through;">
                            The sale will also usually be a vendor duty transaction.
                        </span>

                        &nbsp;If duty is not paid on time, a party may incur penalties.
                    </div>

                    <!-- 7 -->
                    <div style="position:relative; padding-left:7mm; margin-bottom:1.2mm;">
                        <span style="position:absolute; left:0; top:0;">7.</span>
                        If the purchaser agrees to the release of deposit any rights in relation to the land
                        (for example, the rights mentioned in clause 2.8) may be subject to the rights of other
                        persons such as the vendor’s mortgagee.
                    </div>

                    <!-- 8 -->
                    <div style="position:relative; padding-left:7mm;">
                        <span style="position:absolute; left:0; top:0;">8.</span>
                        The purchaser should arrange insurance as appropriate.
                    </div>

                </div>

                <!-- DISPUTES -->
                <div style="
        border-top:1px solid #000;
        padding:1.5mm 2mm 1mm 2mm;
    ">
                    <div style="
            text-align:center;
            font-weight:bold;
            font-size:11px;
            line-height:1;
            margin-bottom:1mm;
        ">
                        DISPUTES
                    </div>

                    <div style="font-size:10.5px; line-height:1.08;">
                        If you get into a dispute with the other party, the Law Society and Real Estate Institute encourage you to use informal
                        procedures such as negotiation, independent expert appraisal or mediation (for example mediation under the Law Society
                        Mediation Guidelines).
                    </div>
                </div>

                <!-- AUCTIONS -->
                <div style="
        border-top:1px solid #000;
        padding:1.5mm 2mm 1.5mm 2mm;
    ">
                    <div style="
            text-align:center;
            font-weight:bold;
            font-size:11px;
            line-height:1;
            margin-bottom:1mm;
        ">
                        AUCTIONS
                    </div>

                    <div style="font-size:10.5px; line-height:1.08;">
                        Regulations made under the Property Stock and Business Agents Act 2002 prescribe a number of conditions applying
                        to sales by auction.
                    </div>
                </div>

            </div>
        </div>
        <!-- page 2 ends -->
    </div>

</body>

</html>