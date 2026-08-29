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
            margin: 0 !important;
            padding: 0 !important;
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

            <div class="copyright">
                © 2005 COPYRIGHT&nbsp; The Law Society of New South Wales and The Real Estate Institute of New South Wales.&nbsp;
                You can prepare your own version of<br>
                pages 1 and 2 on a computer or typewriter, and you can reproduce this form (or part of it) for educational purposes,
                but any other reproduction of this form<br>
                (or part of it) is an infringement of copyright unless authorised by the copyright holders or legislation.
            </div>

            <div class="document-title">
                Contract for the sale of land – 2005 edition
            </div>

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
                    <td class="value">
                        Raine &amp; Horne Double Bay<br>
                        385 New South Head Road, Double Bay, NSW 2028
                    </td>
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
                    <td class="value">
                        Edda Unewisse and Kurt Unewisse<br>
                        35 Boonah Avenue, Eastgardens
                    </td>
                    <td></td>
                </tr>

                <tr class="space-small">
                    <td class="term">Vendor’s Solicitor</td>
                    <td class="value">
                        Key Property Lawyers<br>
                        PO Box 1398, Bondi Junction 1355 NSW
                    </td>
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
                    <td colspan="2" class="value">
                        42nd day after the date of this contract
                        <span class="normal">(clause 15)</span>
                    </td>
                </tr>

                <tr>
                    <td class="term">
                        Land<br>
                        <span class="normal">(Address, plan details<br>and title reference)</span>
                    </td>

                    <td colspan="2" class="value land-lines">
                        35 Boonah Avenue, Eastgardens 2036<br>
                        Registered Plan: Lot&nbsp; 1 Plan DP 383 654<br>
                        Folio Identifier 1/383654
                    </td>
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
                                <td><span class="checkbox checked"></span>HOUSE</td>
                                <td><span class="checkbox checked"></span>garage</td>
                                <td><span class="checkbox"></span>carport</td>
                                <td><span class="checkbox"></span>home unit</td>
                                <td><span class="checkbox checked"></span>carspace</td>
                                <td><span class="checkbox"></span>none</td>
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
                            <span class="checkbox checked"></span>
                            Documents in the List of Documents as marked or as numbered:
                        </div>

                        <div class="other-documents">
                            <span class="checkbox"></span>Other documents:
                        </div>
                    </td>
                </tr>
            </table>

            <div style="border:2px solid #000; padding:6px 10px 4px 10px; font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:1.08;">

                <div style="font-weight:bold; font-size:17px; margin-bottom:4px;">
                    A real estate agent is permitted by <em>legislation</em> to fill up the items in this box in a sale of residential property.
                </div>

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
                                        <span class="checkbox checked"></span>
                                        other:&nbsp; Wall air-conditioner, garden corner bench and table, groundwater pump, bird<br>
                                        bath, build in shelves in living room, workbench and machinery in garage, kitchen corner<br>
                                        bench, Wardrobe in bedroom, pot plants, washing machine in internal laundry, shelves in<br>
                                        spare bedroom
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
                                    <td style="font-size:16px; padding-left:55px;">
                                        (10% of the price, unless otherwise stated)
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:16px;">Balance</td>
                                    <td style="font-size:16px; font-weight:bold;">$</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td style="font-size:16px;">Contract date</td>
                                    <td></td>
                                    <td style="font-size:16px; text-align:right;">
                                        (if not stated, the date this contract was made)
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <table style="width:100%; border-collapse:collapse; table-layout:fixed; margin-top:34px; font-family:Arial, Helvetica, sans-serif; font-size:16px;">
                <tr>
                    <td style="width:42%; vertical-align:top;">
                        <div style="border-top:1px solid #000; padding-top:3px; font-weight:bold;">
                            Vendor
                        </div>
                    </td>

                    <td style="width:16%;"></td>

                    <td style="width:42%; vertical-align:top;">
                        <div style="border-top:1px solid #000; padding-top:3px; text-align:right; font-weight:bold;">
                            Witness
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="height:58px;"></td>

                    <td style="vertical-align:top;">
                        <div style="border:1px dotted #000; padding:2px 8px 3px 8px; min-height:52px;">
                            <div style="font-weight:bold; font-size:16px;">
                                GST AMOUNT <span style="font-weight:normal;">(optional)</span>
                            </div>
                            <div>The price includes</div>
                            <div>GST of:</div>
                        </div>
                    </td>

                    <td></td>
                </tr>

                <tr>
                    <td style="vertical-align:top;">
                        <div style="border-top:1px solid #000; padding-top:3px; font-weight:bold;">
                            Purchaser
                        </div>
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

                                <td style="width:100%; border-top:1px solid #000; text-align:right; padding-top:3px; font-weight:bold;">
                                    Witness
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


            <div style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:1.08;">

                <div style="text-align:center; font-weight:bold; font-size:17px; margin-bottom:3px;">
                    Tax information (the parties promise this is correct as far as each party is aware)
                </div>

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
                        <td style="vertical-align:top;">
                            Margin scheme will be used in making the taxable supply
                        </td>
                        <td style="vertical-align:top; white-space:nowrap;">
                            <span class="checkbox"></span>NO
                        </td>
                        <td style="vertical-align:top; white-space:nowrap;">
                            <span class="checkbox"></span>yes
                        </td>
                    </tr>
                </table>

                <div style="margin-top:2px; margin-bottom:2px;">
                    This sale is not a taxable supply because (one or more of the following may apply) the sale is:
                </div>

                <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                    <tr>
                        <td style="width:5%;"></td>
                        <td style="width:95%; vertical-align:top;">
                            <span class="checkbox checked"></span>
                            not made in the course or furtherance of an enterprise that the vendor carries on (section 9-5(b))
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span>
                            by a vendor who is neither registered nor required to be registered for GST (section 9-5(d))
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span>
                            GST-free because the sale is the supply of a going concern under section 38-325
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span>
                            GST-free because the sale is subdivided farm land or farm land supplied for farming under Subdivision 38-O
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="vertical-align:top;">
                            <span class="checkbox"></span>
                            input taxed because the sale is of eligible residential premises (sections 40-65, 40-75(2) and 195-1)
                        </td>
                    </tr>
                </table>

                <div style="border:1px solid #000; min-height:50px; margin-top:7px; padding:3px 10px;">
                    <strong style="font-size:16px;">
                        HOLDER OF STRATA OR COMMUNITY TITLE RECORDS – Name, address and telephone number
                    </strong>
                </div>

            </div>
        </div>
        <!-- page 1 ends -->

    </div>

</body>

</html>