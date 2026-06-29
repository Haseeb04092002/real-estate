<?php


defined('BASEPATH') or exit('No direct script access allowed');
// Get column names of table
$columns = $this->db->list_fields('tbl_properties_features');
// echo "<br>";
// echo "<pre>";
// print_r($columns);
// die();
?>


<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('components/header_meta'); ?>
<?php $this->load->view('components/css_links'); ?>


</head>

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <?php $this->load->view('components/header', ['ListingPages' => 'no']); ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="bi bi-building me-2"></i>
                Smart Contract System
            </a>
        </div>
    </nav>

    <div class="container border-0">

        <!-- NAV TABS -->
        <ul class="nav nav-tabs" id="docTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="btn btn-primary rounded-0 mx-2 active" data-bs-toggle="tab" data-bs-target="#sale" type="button">Contract of Sale</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-primary rounded-0 mx-2" data-bs-toggle="tab" data-bs-target="#deed-of-conveyance" type="button">Deed of Conveyance</button>
            </li>
            <!-- <li class="nav-item" role="presentation">
                <button class="btn btn-primary rounded-0 mx-2" data-bs-toggle="tab" data-bs-target="#vendor-statement" type="button">Vendor Statement</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-primary rounded-0 mx-2" data-bs-toggle="tab" data-bs-target="#vendor-disclosure" type="button">Vendor Disclosure</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-primary rounded-0 mx-2" data-bs-toggle="tab" data-bs-target="#inspection" type="button">Building Inspection Reports</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-primary rounded-0 mx-2" data-bs-toggle="tab" data-bs-target="#settlement" type="button">Settlement Statement</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="btn btn-primary rounded-0 mx-2" data-bs-toggle="tab" data-bs-target="#transfer" type="button">Transfer of Land</button>
            </li> -->
        </ul>

        <!-- TAB CONTENT -->
        <div class="tab-content p-4 bg-white">

            <!-- Contract of Sale -->
            <div class="tab-pane fade show active" id="sale">
                <h4 class="text-center">Contract of Sale</h4>
                <form action="<?= site_url('Properties/smart_contract/sale_contract') ?>"
                    method="POST"
                    target="_blank"
                    class="p-5 shadow">

                    <!-- BASIC DETAILS -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Buyer Name</label>
                            <input type="text" class="form-control" name="txtA11" id="txtA11">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Seller Name</label>
                            <input type="text" class="form-control" name="txtA12" id="txtA12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Property Address</label>
                            <input type="text" class="form-control" name="txtA13" id="txtA13">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Purchase Price ($)</label>
                            <input type="number" class="form-control" name="txtA14" id="txtA14">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Deposit Amount ($)</label>
                            <input type="number" class="form-control" name="txtA15" id="txtA15">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Completion Date</label>
                            <input type="date" class="form-control" name="txtA16" id="txtA16">
                        </div>
                    </div>

                    <!-- PROPERTY INCLUSIONS / EXCLUSIONS-->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3">Property Inclusions</h6>
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB11" id="txtB11">
                                        <label class="form-check-label ps-2">Medical centre</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB12" id="txtB12">
                                        <label class="form-check-label ps-2">Flooring</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB13" id="txtB13">
                                        <label class="form-check-label ps-2">Power backup</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB14" id="txtB14">
                                        <label class="form-check-label ps-2">View</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB15" id="txtB15">
                                        <label class="form-check-label ps-2">Other main features</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB16" id="txtB16">
                                        <label class="form-check-label ps-2">Built in year</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB17" id="txtB17">
                                        <label class="form-check-label ps-2">Parking spaces</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB18" id="txtB18">
                                        <label class="form-check-label ps-2">Floors</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB19" id="txtB19">
                                        <label class="form-check-label ps-2">Double glazed windows</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB20" id="txtB20">
                                        <label class="form-check-label ps-2">Central air conditioning</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB21" id="txtB21">
                                        <label class="form-check-label ps-2">Central heating</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB22" id="txtB22">
                                        <label class="form-check-label ps-2">Waste disposal</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB23" id="txtB23">
                                        <label class="form-check-label ps-2">Furnished</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB24" id="txtB24">
                                        <label class="form-check-label ps-2">Other rooms</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB25" id="txtB25">
                                        <label class="form-check-label ps-2">Bedrooms</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB26" id="txtB26">
                                        <label class="form-check-label ps-2">Features</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB27" id="txtB27">
                                        <label class="form-check-label ps-2">Bathrooms</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB28" id="txtB28">
                                        <label class="form-check-label ps-2">Servant quarters</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB29" id="txtB29">
                                        <label class="form-check-label ps-2">Kitchens</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB30" id="txtB30">
                                        <label class="form-check-label ps-2">Store rooms</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB31" id="txtB31">
                                        <label class="form-check-label ps-2">Drawing room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB32" id="txtB32">
                                        <label class="form-check-label ps-2">Dining room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB33" id="txtB33">
                                        <label class="form-check-label ps-2">Study room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB34" id="txtB34">
                                        <label class="form-check-label ps-2">Prayer room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB35" id="txtB35">
                                        <label class="form-check-label ps-2">Powder room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB36" id="txtB36">
                                        <label class="form-check-label ps-2">Gym</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB37" id="txtB37">
                                        <label class="form-check-label ps-2">Steam room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB38" id="txtB38">
                                        <label class="form-check-label ps-2">Lounge room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB39" id="txtB39">
                                        <label class="form-check-label ps-2">Laundry room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB40" id="txtB40">
                                        <label class="form-check-label ps-2">Communication facilities</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB41" id="txtB41">
                                        <label class="form-check-label ps-2">Broadband internet access</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB42" id="txtB42">
                                        <label class="form-check-label ps-2">TV ready</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB43" id="txtB43">
                                        <label class="form-check-label ps-2">Intercom</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB44" id="txtB44">
                                        <label class="form-check-label ps-2">Conference room</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB45" id="txtB45">
                                        <label class="form-check-label ps-2">Other community facilities</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB46" id="txtB46">
                                        <label class="form-check-label ps-2">Community lawn</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB47" id="txtB47">
                                        <label class="form-check-label ps-2">Community swimming pool</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB48" id="txtB48">
                                        <label class="form-check-label ps-2">Community gym</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB49" id="txtB49">
                                        <label class="form-check-label ps-2">First aid</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB50" id="txtB50">
                                        <label class="form-check-label ps-2">Day care center</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB51" id="txtB51">
                                        <label class="form-check-label ps-2">Kids play area</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB52" id="txtB52">
                                        <label class="form-check-label ps-2">Barbeque area</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB53" id="txtB53">
                                        <label class="form-check-label ps-2">Mosque</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB54" id="txtB54">
                                        <label class="form-check-label ps-2">Community centre</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB55" id="txtB55">
                                        <label class="form-check-label ps-2">Other healthcare</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB56" id="txtB56">
                                        <label class="form-check-label ps-2">Lawn garden</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB57" id="txtB57">
                                        <label class="form-check-label ps-2">Swimming pool</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB58" id="txtB58">
                                        <label class="form-check-label ps-2">Sauna</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB59" id="txtB59">
                                        <label class="form-check-label ps-2">Jacuzzi</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB60" id="txtB60">
                                        <label class="form-check-label ps-2">Nearby schools</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB61" id="txtB61">
                                        <label class="form-check-label ps-2">Nearby hospitals</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB62" id="txtB62">
                                        <label class="form-check-label ps-2">Nearby shopping malls</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB63" id="txtB63">
                                        <label class="form-check-label ps-2">Nearby restaurants</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB64" id="txtB64">
                                        <label class="form-check-label ps-2">Distance from airport</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB65" id="txtB65">
                                        <label class="form-check-label ps-2">Nearby public transport service</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="txtB66" id="txtB66">
                                        <label class="form-check-label ps-2">Other nearby places</label>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- KIND OF BUYER -->
                    <h6 class="mt-4">Kind of Buyer</h6>
                    <div class="row mb-4 p-3">
                        <div class="col-md-2 form-check">
                            <input class="form-check-input" type="checkbox" name="txtA25" id="txtA25">
                            <label class="form-check-label ps-2">Joint Tenants</label>
                        </div>
                        <div class="col-md-2 form-check">
                            <input class="form-check-input" type="checkbox" name="txtA26" id="txtA26">
                            <label class="form-check-label ps-2">Tenants in Common</label>
                        </div>
                        <div class="col-md-2 form-check">
                            <input class="form-check-input" type="checkbox" name="txtA27" id="txtA27">
                            <label class="form-check-label ps-2">Unequal Shares</label>
                        </div>
                    </div>

                    <!-- GST -->
                    <h6>GST</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">GST Amount (optional)</label>
                            <input type="text" class="form-control" name="txtA32" id="txtA32">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" name="txtA33" id="txtA33">
                            <label class="form-check-label ps-2">Land Tax Adjustable</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" name="txtA34" id="txtA34">
                            <label class="form-check-label ps-2">GST Taxable Supply</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" name="txtA35" id="txtA35">
                            <label class="form-check-label ps-2">Margin Scheme</label>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Generate PDF</button>
                    </div>

                </form>

            </div>

            <!-- deed-of-conveyance -->
            <div class="tab-pane fade" id="deed-of-conveyance">
                <h4 class="text-center">Contract of Sale</h4>
                <form action="<?= site_url('Properties/smart_contract/deed_of_conveyance') ?>"
                    method="POST"
                    target="_blank"
                    class="p-5 shadow">

                    <!-- BASIC DETAILS -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Grantor Name</label>
                            <input type="text" class="form-control" name="txtA11" id="txtA11">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Grantee Name</label>
                            <input type="text" class="form-control" name="txtA12" id="txtA12">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Head Office Location</label>
                            <input type="text" class="form-control" name="txtA13" id="txtA13">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Generate PDF</button>
                    </div>

                </form>

            </div>

            <!-- Vendor Statement -->
            <div class="tab-pane fade" id="vendor-statement">
                <h4>Vendor Statement</h4>
                <form>
                    <div class="row g-3 mt-2">

                        <div class="col-md-6">
                            <label class="form-label">Vendor Name</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Property Zoning</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Council Rates Notice</label>
                            <input type="file" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Services Available</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox"> Water
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox"> Gas
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox"> Electricity
                            </div>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="button" class="btn btn-primary">Generate PDF</button>
                    </div>
                </form>
            </div>

            <!-- Vendor Disclosure -->
            <div class="tab-pane fade" id="vendor-disclosure">
                <h4>Vendor Disclosure</h4>
                <form>
                    <div class="row g-3 mt-2">

                        <div class="col-md-12">
                            <label class="form-label">Easements / Restrictions</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Planning Certificate</label>
                            <input type="file" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Sewer Diagram</label>
                            <input type="file" class="form-control">
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="button" class="btn btn-primary">Generate PDF</button>
                    </div>
                </form>
            </div>

            <!-- Building Inspection Reports -->
            <div class="tab-pane fade" id="inspection">
                <h4>Building Inspection Reports</h4>
                <form>
                    <div class="row g-3 mt-2">

                        <div class="col-md-6">
                            <label class="form-label">Inspector Name</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Inspection Date</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Upload Building Report</label>
                            <input type="file" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Upload Pest Report</label>
                            <input type="file" class="form-control">
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="button" class="btn btn-primary">Generate PDF</button>
                    </div>
                </form>
            </div>

            <!-- Settlement Statement -->
            <div class="tab-pane fade" id="settlement">
                <h4>Settlement Statement</h4>
                <form>
                    <div class="row g-3 mt-2">

                        <div class="col-md-4">
                            <label class="form-label">Council Rates Adjustment</label>
                            <input type="number" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Water Rates Adjustment</label>
                            <input type="number" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Stamp Duty</label>
                            <input type="number" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Upload Settlement Docs</label>
                            <input type="file" class="form-control">
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="button" class="btn btn-primary">Generate PDF</button>
                    </div>
                </form>
            </div>

            <!-- Transfer of Land -->
            <div class="tab-pane fade" id="transfer">
                <h4>Transfer of Land</h4>
                <form>
                    <div class="row g-3 mt-2">

                        <div class="col-md-6">
                            <label class="form-label">Transferor (Seller)</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Transferee (Buyer)</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Property Title Number</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Upload Identification (POI)</label>
                            <input type="file" class="form-control">
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="button" class="btn btn-primary">Generate PDF</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <?php
    $this->load->view('components/footer');
    $this->load->view('components/js_links');
    ?>

</body>

</html>