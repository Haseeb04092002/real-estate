<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Property Sale Agreement</title>

    <style>
        body {
            font-family: "Libre Baskerville", serif;
            font-size: 12px;
            color: #000;
            margin: 0px;
            width: 100%;
            height: 100%;
            /*            border: 1px solid black;*/
            /*            padding: 10px;*/
        }

        .container {
            width: 100%;
        }

        /* HEADER */
        /*.header {
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }*/

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        /*.header-left {
            font-size: 10px;
            vertical-align: top;
            width: 65%;
            padding-right: 10px;
        }*/

        /*.header-right {
            text-align: center;
            vertical-align: top;
            width: 35%;
        }*/

        /*.company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .company-info {
            font-size: 11px;
            line-height: 1.4;
        }*/

        /* TITLE */
        .doc-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0;
            text-decoration: underline;
        }

        /* TABLES */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .no-border td {
            border: none;
            padding-top: 30px;
        }

        /* SIGNATURES */
        .signature-table td {
            border: none;
            padding-top: 40px;
        }

        .signature-line {
            margin-top: 30px;
            border-top: 1px solid #000;
            width: 80%;
        }

        /* FOOTER */
        .footer {
            border-top: 1px solid #000;
            padding-top: 10px;
            font-size: 10px;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- page 1 -->
        <div id="page1">
            <table>
                <tr>
                    <td style="text-align: justify-all; border: none;">
                        ©2005 COPYRIGHT The Law Society of New South Wales and
                        The Real Estate Institute of New South Wales. You can prepare
                        your own version of pages 1 and 2 on a computer or typewriter,
                        and you can reproduce this form (or part of it) for educational
                        purposes, but any other reproduction is an infringement of copyright
                        unless authorised by the copyright holders or legislation.
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; border: none;">
                        <div style="font-size: 20px; font-weight: 500;">FRE Real Estate</div>
                        <div style="font-size: 15px; font-weight: 200;">
                            Sydney Australia<br>
                            Phone: +92 300 1234567<br>
                            Email: info@freproperty.com
                        </div>
                    </td>
                </tr>
                <hr>
            </table>
            <div style="margin-bottom: 20px; font-size: 18px; font-weight: 500; text-align: center; text-decoration: underline;">
                Contract for the sale of land
            </div>

            <table width="100%" border="1" cellspacing="0" cellpadding="6">

                <colgroup>
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                </colgroup>

                <tr>
                    <td colspan="10" style="font-weight:bold; background:#f2f2f2; Border-right:none; text-align: left;">
                        TERM
                    </td>
                    <td colspan="10" style="font-weight:bold; background:#f2f2f2; Border-left:none; text-align: left;">
                        MEANING OF TERM
                    </td>
                </tr>

                <tr>
                    <td colspan="6"><strong>Buyer Name</strong></td>
                    <td colspan="14"><?= htmlspecialchars($BuyerName) ?></td>
                </tr>

                <tr>
                    <td colspan="6"><strong>Seller Name</strong></td>
                    <td colspan="14"><?= htmlspecialchars($BuyerName) ?></td>
                </tr>

                <tr>
                    <td colspan="6"><strong>Property Address</strong></td>
                    <td colspan="14"><?= htmlspecialchars($PropertyAddress) ?></td>
                </tr>

                <tr>
                    <td colspan="6"><strong>Purchase Price</strong></td>
                    <td colspan="14"><?= $PurchasePrice ?></td>
                </tr>

                <tr>
                    <td colspan="6"><strong>Deposit Amount</strong></td>
                    <td colspan="14"><?= $DepositAmount ?></td>
                </tr>

                <tr>
                    <td colspan="6"><strong>Completion date</strong></td>
                    <td colspan="14"><?= $SettlementDate ?></td>
                </tr>

            </table>

            <div style="margin-bottom: 10px; font-size: 15px; font-weight: 500; text-align: left; text-decoration: underline;">
                Property Inclusions
            </div>

            <table width="100%" cellspacing="0" cellpadding="0">
                <tr style="height: 0px; margin: 0px; padding: 0px;">
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="blinds">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="blinds">Blinds</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="curtains">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="curtains">Curtains</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="insect-screens">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="insect-screens">Insect Screens</label>
                    </td>
                </tr>

                <tr style="height: 0px; margin: 0px; padding: 0px;">
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="stove">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="stove">Stove</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="wardrobes">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="wardrobes">Built-in Wardrobes</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="dishwasher">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="dishwasher">Dishwasher</label>
                    </td>
                </tr>

                <tr style="height: 0px; margin: 0px; padding: 0px;">
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="light-fittings">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="light-fittings">Light Fittings</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="pool-equipment">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="pool-equipment">Pool Equipment</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="clothes-line">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="clothes-line">Clothes Line</label>
                    </td>
                </tr>

                <tr style="height: 0px; margin: 0px; padding: 0px;">
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="floor-coverings">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="floor-coverings">Fixed Floor Coverings</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="range-hood">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="range-hood">Range Hood</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="tv-antenna">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="tv-antenna">TV Antenna</label>
                    </td>
                </tr>

                <tr style="height: 0px; margin: 0px; padding: 0px;">
                    <!-- Only one item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="other">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="other">Other</label>
                    </td>
                </tr>
            </table>

            <div style="margin-bottom: 5px; font-size: 15px; font-weight: 500; text-align: left; text-decoration: underline;">
                Property Exclusions
            </div>

            <table width="100%" cellspacing="0" cellpadding="4">
                <tr>
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="blinds">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="blinds">Blinds</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="curtains">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="curtains">Curtains</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="insect-screens">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="insect-screens">Insect Screens</label>
                    </td>
                </tr>

                <tr>
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="stove">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="stove">Stove</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="wardrobes">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="wardrobes">Built-in Wardrobes</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="dishwasher">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="dishwasher">Dishwasher</label>
                    </td>
                </tr>

                <tr>
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="light-fittings">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="light-fittings">Light Fittings</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="pool-equipment">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="pool-equipment">Pool Equipment</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="clothes-line">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="clothes-line">Clothes Line</label>
                    </td>
                </tr>

                <tr>
                    <!-- First item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="floor-coverings">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="floor-coverings">Fixed Floor Coverings</label>
                    </td>

                    <!-- Second item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="range-hood">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="range-hood">Range Hood</label>
                    </td>

                    <!-- Third item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="tv-antenna">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="tv-antenna">TV Antenna</label>
                    </td>
                </tr>

                <tr>
                    <!-- Only one item -->
                    <td style="border: none; vertical-align: middle; width: 20px;">
                        <input type="checkbox" id="other">
                    </td>
                    <td style="border: none; vertical-align: middle; padding-left: 2px;">
                        <label for="other">Other</label>
                    </td>
                </tr>
            </table>

            <!-- FOOTER -->
            <div class="footer">
                This document is computer generated and does not require a physical signature.<br>
                © <?= date('Y') ?> FRE Real Estate
            </div>
        </div>

        <!-- page 2 -->
        <div id="page2">
            <div style="margin-bottom: 10px; font-size: 15px; font-weight: 500; text-align: left; text-decoration: underline;">
                Witnesses
            </div>

            <table width="100%" cellspacing="0" cellpadding="4">
                <colgroup>
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                    <col width="5%">
                </colgroup>

                <tr>
                    <td colspan="2" style="border: none; vertical-align: middle;">
                        Kind of Buyer:
                    </td>
                    <td colspan="4" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="joint-tenents">
                        <label for="joint-tenents">Joint Tenents</label>
                    </td>
                    <td colspan="4" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="tenants-common">
                        <label for="tenants-common">Tenants in Common</label>
                    </td>
                    <td colspan="10" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="unequal-shares">
                        <label for="unequal-shares">In Unequal Shares</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="10" style="border: none; vertical-align: middle;">
                        Buyer:___________________________
                    </td>
                    <td colspan="10" style="border: none; vertical-align: middle;">
                        Witness:___________________________
                    </td>
                </tr>

                <tr>
                    <td colspan="10" style="border: none; vertical-align: middle;">
                        Seller:___________________________
                    </td>
                    <td colspan="10" style="border: none; vertical-align: middle;">
                        Witness:___________________________
                    </td>
                </tr>

                <tr>
                    <td colspan="20" style="border: none; vertical-align: middle;">
                        GST AMOUNT (optional) The price includes GST of:___________________________
                    </td>
                </tr>

                <!-- New Fields Start -->

                <tr>
                    <td colspan="2" style="border: none; vertical-align: middle;">
                        Land tax is adjustable:
                    </td>
                    <td colspan="3" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="landtax-no">
                        <label for="landtax-no">No</label>
                    </td>
                    <td colspan="3" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="landtax-yes">
                        <label for="landtax-yes">Yes</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="border: none; vertical-align: middle;">
                        GST: Taxable supply
                    </td>
                    <td colspan="3" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="gst-no">
                        <label for="gst-no">No</label>
                    </td>
                    <td colspan="4" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="gst-full">
                        <label for="gst-full">Yes, in full</label>
                    </td>
                    <td colspan="6" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="gst-extent">
                        <label for="gst-extent">Yes, to an extent</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="border: none; vertical-align: middle;">
                        Margin scheme will be used in making the taxable supply:
                    </td>
                    <td colspan="3" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="margin-no">
                        <label for="margin-no">No</label>
                    </td>
                    <td colspan="3" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="margin-yes">
                        <label for="margin-yes">Yes</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" style="border: none; vertical-align: middle; font-size: 15px; font-weight:500;">
                        This sale is not a taxable supply because (one or more of the following may apply):
                    </td>
                </tr>

                <tr>
                    <td colspan="20" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="not-enterprise">
                        <label for="not-enterprise">Not made in the course or furtherance of an enterprise that the vendor carries on (section 9-5(b))</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="vendor-not-registered">
                        <label for="vendor-not-registered">By a vendor who is neither registered nor required to be registered for GST (section 9-5(d))</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="gst-free-going">
                        <label for="gst-free-going">GST-free because the sale is the supply of a going concern under section 38-325</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="gst-free-farm">
                        <label for="gst-free-farm">GST-free because the sale is subdivided farm land or farm land supplied for farming under Subdivision 38-O</label>
                    </td>
                </tr>

                <tr>
                    <td colspan="20" style="border: none; vertical-align: middle;">
                        <input type="checkbox" id="input-taxed-residential">
                        <label for="input-taxed-residential">Input taxed because the sale is of eligible residential premises (sections 40-65, 40-75(2) and 195-1)</label>
                    </td>
                </tr>

                <tr>
                    <!-- Left Column: Nested Table -->
                    <td style="border: none; vertical-align: top;" colspan="10">
                        <table width="100%" cellspacing="0" cellpadding="2">
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item1">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    property certificate for the land
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item2">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    plan of the land
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item3">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    unregistered plan of the land
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item4">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    plan of land to be subdivided
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item5">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    document that is to be lodged with a relevant plan
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item6">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    section 149(2) certificate (Environmental Planning and Assessment Act 1979)
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item7">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    section 149(5) information included in that certificate
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item8">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    sewerage connections diagram
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="border: none; vertical-align: middle;">
                                    <input type="checkbox" id="item9">
                                </td>
                                <td colspan="19" style="border: none; vertical-align: middle;">
                                    sewer mains diagram
                                </td>
                            </tr>
                        </table>
                    </td>

                    <!-- Right Column: Items 24-45 -->
                    <td style="border: none; vertical-align: top;" colspan="10">
                        <table width="100%" cellspacing="0" cellpadding="2">
                            <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item24">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                property certificate for strata common property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item25">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                plan creating strata common property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item26">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                strata by-laws not set out in legislation
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item27">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                strata development contract or statement
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item28">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                strata management statement
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item29">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                leasehold strata - lease of lot and common property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item30">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                property certificate for neighbourhood property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item31">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                plan creating neighbourhood property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item32">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                neighbourhood development contract
                            </td>
                        </tr>
                        </table>
                    </td>
                </tr>

            </table>

            <!-- FOOTER -->
            <div class="footer">
                This document is computer generated and does not require a physical signature.<br>
                © <?= date('Y') ?> FRE Real Estate
            </div>
        </div>



        <table width="100%" cellspacing="0" cellpadding="4">

            <tr>
                <!-- Left Column: Nested Table -->
                <td style="border: none; vertical-align: top;" colspan="10">
                    <table width="100%" cellspacing="0" cellpadding="2">
                        
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item10">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                document that created or may have created an easement, profit à prendre, restriction on use or positive covenant disclosed in this contract
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item11">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                section 88G certificate (positive covenant)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item12">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                survey report
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item13">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                section 317A certificate (certificate of compliance)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item14">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                building certificate given under legislation
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item15">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                insurance certificate (Home Building Act 1989)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item16">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                brochure or note (Home Building Act 1989)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item17">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                section 24 certificate (Swimming Pools Act 1982)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item18">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                lease (with every relevant memorandum or variation)
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item19">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                other document relevant to tenancies
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item20">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                old system document
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item21">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                Crown tenure card
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item22">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                Crown purchase statement of account
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item23">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                Statutory declaration regarding vendor duty
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- Right Column: Items 24-45 -->
                <td style="border: none; vertical-align: top;" colspan="10">
                    <table width="100%" cellspacing="0" cellpadding="2">
                        
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item33">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                neighbourhood management statement
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item34">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                property certificate for precinct property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item35">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                plan creating precinct property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item36">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                precinct development contract
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item37">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                precinct management statement
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item38">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                property certificate for community property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item39">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                plan creating community property
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item40">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                community development contract
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item41">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                community management statement
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item42">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                document disclosing a change of by-laws
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item43">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                document disclosing a change in a development or management contract or statement
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item44">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                document disclosing a change in boundaries
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" style="border: none; vertical-align: middle;">
                                <input type="checkbox" id="item45">
                            </td>
                            <td colspan="19" style="border: none; vertical-align: middle;">
                                certificate under Management Act – section 109 (Strata Schemes) or section 26 (Community Land)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
        </table>


        <!-- TERMS -->
        <table>
            <tr>
                <th>Terms & Conditions</th>
            </tr>
            <tr>
                <td>
                    This Property Sale Agreement is made between the Seller and Buyer
                    mentioned above. The Seller agrees to sell and the Buyer agrees to
                    purchase the described property at the agreed purchase price.
                    The deposit amount is payable immediately and the remaining balance
                    shall be cleared on or before the settlement date.
                </td>
            </tr>
        </table>

        <!-- SIGNATURES -->
        <table class="signature-table">
            <tr>
                <td width="50%">
                    <strong>Seller Signature</strong>
                    <div class="signature-line"></div>
                    Date:
                </td>
                <td width="50%">
                    <strong>Buyer Signature</strong>
                    <div class="signature-line"></div>
                    Date:
                </td>
            </tr>
        </table>



    </div>

</body>

</html>