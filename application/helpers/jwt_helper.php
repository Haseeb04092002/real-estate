<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * A simple JWT Helper for CodeIgniter 3 without external dependencies
 */
if (!function_exists('generate_jwt')) {
    function generate_jwt($payload, $secret = 'FRE_REALESTATE_SECRET_KEY_123') {
        // Create token header as a JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        
        // Base64Url encode the header and payload
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));
        
        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
        
        // Base64Url encode the signature
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        // Return the JWT
        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
}
