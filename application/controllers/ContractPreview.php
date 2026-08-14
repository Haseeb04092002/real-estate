<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class ContractPreview extends CI_Controller {

    public function index($templateName = 'sale_contract2')
    {
        // Load Dompdf autoloader from third_party
        require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

        $data['BuyerName'] = 'John Doe';
        $data['VendorName'] = 'WALKER AVE PROJECTS PTY LTD';
        $data['PropertyAddress'] = '8 WALKER AVE MASCOT NSW 2020';
        $data['PurchasePrice'] = '$1,250,000';
        $data['DepositAmount'] = '$125,000';
        $data['SettlementDate'] = '42nd day after contract date';
        
        // Render view HTML to variable
        $html = $this->load->view('contract_templates/' . $templateName, $data, TRUE);

        // Configure Dompdf options
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output PDF to browser for download
        $filename = $templateName . '_' . date('Y-m-d') . '.pdf';
        $dompdf->stream($filename, array("Attachment" => 1));
    }
}
