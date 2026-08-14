<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContractPreview extends CI_Controller {

    public function index($templateName = 'sale_contract2')
    {
        $data['BuyerName'] = 'John Doe';
        $data['VendorName'] = 'WALKER AVE PROJECTS PTY LTD';
        $data['PropertyAddress'] = '8 WALKER AVE MASCOT NSW 2020';
        $data['PurchasePrice'] = '$1,250,000';
        $data['DepositAmount'] = '$125,000';
        $data['SettlementDate'] = '42nd day after contract date';
        
        $this->load->view('contract_templates/' . $templateName, $data);
    }
}
