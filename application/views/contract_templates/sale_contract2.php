<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Contract for Sale of Land</title>

    <style>
        body {
            font-family: "Libre Baskerville", serif;
            font-size: 12px;
            color: #000;
            margin: 0px;
            width: 100%;
            height: 100%;
        }

        .container {
            width: 100%;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .doc-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 25px 0;
            text-decoration: underline;
        }

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

        .signature-table td {
            border: none;
            padding-top: 40px;
        }

        .signature-line {
            margin-top: 30px;
            border-top: 1px solid #000;
            width: 80%;
        }

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

        <!-- Header -->
        <div id="page1">
            <table>
                <tr>
                    <td style="text-align: justify; border: none;">
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
            </table>
            <hr style="border: 0.5px solid #000; margin-bottom: 15px;">

            <div style="margin-bottom: 20px; font-size: 18px; font-weight: 500; text-align: center; text-decoration: underline;">
                Contract for the Sale of Land - 2005 Edition
            </div>

            <!-- Key Terms Table -->
            <table width="100%" border="1" cellspacing="0" cellpadding="6">
                <colgroup>
                    <col width="30%">
                    <col width="70%">
                </colgroup>

                <tr>
                    <th style="font-weight:bold; background:#f2f2f2; text-align: left;">
                        TERM
                    </th>
                    <th style="font-weight:bold; background:#f2f2f2; text-align: left;">
                        MEANING OF TERM
                    </th>
                </tr>

                <tr>
                    <td><strong>Vendor</strong></td>
                    <td><?= isset($VendorName) ? htmlspecialchars($VendorName) : 'WALKER AVE PROJECTS PTY LTD ACN 681 293 372 ATF Walker Ave Projects Unit Trust' ?></td>
                </tr>

                <tr>
                    <td><strong>Vendor\'s Solicitor</strong></td>
                    <td><?= isset($VendorSolicitor) ? htmlspecialchars($VendorSolicitor) : 'George Xylas Solicitor, 335A Gardeners Rd, Rosebery NSW 2018 | Phone: 02 9693 5704 | Email: george@gxlaw.com.au' ?></td>
                </tr>

                <tr>
                    <td><strong>Vendor\'s Agent</strong></td>
                    <td><?= isset($VendorAgent) ? htmlspecialchars($VendorAgent) : 'Ray White Park Coast East, 126 Avoca Street, Randwick NSW 2031 | Phone: 9381 7050 | Ref: Justin Bell' ?></td>
                </tr>

                <tr>
                    <td><strong>Purchaser</strong></td>
                    <td><?= isset($BuyerName) ? htmlspecialchars($BuyerName) : (isset($PurchaserName) ? htmlspecialchars($PurchaserName) : 'The Uniting Church in Australia Property Trust (NSW)') ?></td>
                </tr>

                <tr>
                    <td><strong>Purchaser\'s Solicitor</strong></td>
                    <td><?= isset($PurchaserSolicitor) ? htmlspecialchars($PurchaserSolicitor) : 'Jae Hunt, Level 9, 222 Pitt Street, Sydney NSW 2000 | Tel: 0477 717 840' ?></td>
                </tr>

                <tr>
                    <td><strong>Land / Property Address</strong></td>
                    <td><?= isset($PropertyAddress) ? htmlspecialchars($PropertyAddress) : '8 WALKER AVE MASCOT NSW 2020 (LOT 1 DEPOSITED PLAN 536401, Folio Identifier 1/536401)' ?></td>
                </tr>

                <tr>
                    <td><strong>Purchase Price</strong></td>
                    <td><?= isset($PurchasePrice) ? $PurchasePrice : '$1,250,000' ?></td>
                </tr>

                <tr>
                    <td><strong>Deposit Amount</strong></td>
                    <td><?= isset($DepositAmount) ? $DepositAmount : '$125,000 (10% of purchase price)' ?></td>
                </tr>

                <tr>
                    <td><strong>Date for Completion</strong></td>
                    <td><?= isset($SettlementDate) ? $SettlementDate : '42nd day after the contract date (Clause 15)' ?></td>
                </tr>

                <tr>
                    <td><strong>Possession Status</strong></td>
                    <td><?= isset($PossessionStatus) ? htmlspecialchars($PossessionStatus) : 'VACANT POSSESSION' ?></td>
                </tr>
            </table>

            <!-- Inclusions Checklist -->
            <div style="margin-top: 15px; margin-bottom: 10px; font-size: 15px; font-weight: 500; text-align: left; text-decoration: underline;">
                Property Inclusions
            </div>

            <table width="100%" cellspacing="0" cellpadding="2">
                <tr>
                    <td style="border: none; width: 25%;"><input type="checkbox" id="inc_house" checked> <label for="inc_house">HOUSE</label></td>
                    <td style="border: none; width: 25%;"><input type="checkbox" id="inc_blinds" checked> <label for="inc_blinds">Blinds</label></td>
                    <td style="border: none; width: 25%;"><input type="checkbox" id="inc_curtains"> <label for="inc_curtains">Curtains</label></td>
                    <td style="border: none; width: 25%;"><input type="checkbox" id="inc_screens" checked> <label for="inc_screens">Insect Screens</label></td>
                </tr>
                <tr>
                    <td style="border: none;"><input type="checkbox" id="inc_stove" checked> <label for="inc_stove">Stove</label></td>
                    <td style="border: none;"><input type="checkbox" id="inc_wardrobes" checked> <label for="inc_wardrobes">Built-in Wardrobes</label></td>
                    <td style="border: none;"><input type="checkbox" id="inc_dishwasher" checked> <label for="inc_dishwasher">Dishwasher</label></td>
                    <td style="border: none;"><input type="checkbox" id="inc_light" checked> <label for="inc_light">Light Fittings</label></td>
                </tr>
                <tr>
                    <td style="border: none;"><input type="checkbox" id="inc_floor" checked> <label for="inc_floor">Fixed Floor Coverings</label></td>
                    <td style="border: none;"><input type="checkbox" id="inc_range" checked> <label for="inc_range">Range Hood</label></td>
                    <td style="border: none;"><input type="checkbox" id="inc_tv" checked> <label for="inc_tv">TV Antenna</label></td>
                    <td style="border: none;"><input type="checkbox" id="inc_garage" checked> <label for="inc_garage">Garage</label></td>
                </tr>
            </table>

            <!-- Tax & Statutory Provisions -->
            <div style="margin-top: 15px; margin-bottom: 10px; font-size: 15px; font-weight: 500; text-align: left; text-decoration: underline;">
                Tax & Statutory Declarations
            </div>

            <table width="100%" cellspacing="0" cellpadding="4" border="1">
                <tr>
                    <td width="50%"><strong>Land Tax Adjustable:</strong> YES</td>
                    <td width="50%"><strong>GST Taxable Supply:</strong> YES (In Full)</td>
                </tr>
                <tr>
                    <td><strong>Margin Scheme Used:</strong> YES</td>
                    <td><strong>Purchaser GSTRW Payment:</strong> YES</td>
                </tr>
                <tr>
                    <td><strong>Vendor Duty Payable:</strong> NO</td>
                    <td><strong>Deposit Used for Vendor Duty:</strong> NO</td>
                </tr>
            </table>

            <!-- Important Notices & Cooling Off Period -->
            <div style="margin-top: 15px; margin-bottom: 5px; font-size: 14px; font-weight: bold; text-decoration: underline;">
                WARNING & IMPORTANT NOTICES
            </div>
            <table width="100%" cellspacing="0" cellpadding="6" border="1" style="background-color: #fafafa;">
                <tr>
                    <td>
                        <strong>SWIMMING POOLS:</strong> An owner of property on which a swimming pool is situated must ensure that the pool complies with the requirements of the Swimming Pools Act 1992. Penalties apply.<br><br>
                        <strong>SMOKE ALARMS:</strong> The owners of certain types of buildings and strata lots must have smoke alarms (or heat alarms) installed in accordance with regulations under the Environmental Planning and Assessment Act 1979. It is an offence not to comply.<br><br>
                        <strong>COOLING OFF PERIOD (PURCHASER'S RIGHTS):</strong><br>
                        1. This is the statement required by section 66X of the Conveyancing Act 1919.<br>
                        2. The purchaser may rescind the contract at any time before 5 p.m. on the fifth business day after the day on which the contract was made.<br>
                        3. A purchaser exercising the right to cool off will forfeit to the vendor 0.25% of the purchase price of the property.
                    </td>
                </tr>
            </table>

            <!-- Terms & Conditions Summary -->
            <table style="margin-top: 15px;">
                <tr>
                    <th>Definitions & General Provisions (Clause 1)</th>
                </tr>
                <tr>
                    <td>
                        The vendor sells and the purchaser buys the property for the price under these provisions instead of Schedule 3 Conveyancing Act 1919, subject to any legislation that cannot be excluded.<br><br>
                        <strong>Definitions:</strong><br>
                        • <em>adjustment date:</em> the earlier of the giving of possession to the purchaser or completion.<br>
                        • <em>bank:</em> a bank as defined in the Banking Act 1959, the Reserve Bank or a State bank.<br>
                        • <em>business day:</em> any day except a bank or public holiday throughout NSW or a Saturday or Sunday.<br>
                        • <em>depositholder:</em> vendor's agent (or vendor's solicitor if none named).<br>
                        • <em>work order:</em> a valid direction, notice or order that requires work to be done or money to be spent on the property.
                    </td>
                </tr>
            </table>

            <!-- Signatures -->
            <table class="signature-table" style="margin-top: 20px;">
                <tr>
                    <td width="50%">
                        <strong>Signed by Vendor:</strong><br>
                        WALKER AVE PROJECTS PTY LTD<br>
                        HUSSEIN CHALICH (SOLE DIRECTOR/SECRETARY)
                        <div class="signature-line"></div>
                        Date:
                    </td>
                    <td width="50%">
                        <strong>Signed by Purchaser:</strong><br>
                        The Uniting Church in Australia Property Trust (NSW)
                        <div class="signature-line"></div>
                        Date:
                    </td>
                </tr>
            </table>

        </div>

    </div>

</body>

</html>
