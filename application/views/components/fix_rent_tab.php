<?php
$file = 'd:\xampp\htdocs\properties_new\application\views\components\filter_modal_2.php';
$content = file_get_contents($file);

// Extract Buy Tab content
preg_match('/<!-- Buy Tab Content -->.*?<div class="tab-pane fade active show" id="BuyContent"[^>]*>(.*?)<\/div>\s*<!-- End Buy Tab -->/is', $content, $buyMatch);

if (!$buyMatch) {
    echo "Could not find BuyContent\n";
    exit;
}

$buyContent = $buyMatch[1];

// Find Rent Tab boundaries and replace
$pattern = '/(<div class="tab-pane fade" id="RentContent"[^>]*>).*?(<\/div>\s*<\/div>\s*<\/div>\s*<!-- Modal Footer -->)/is';

$newContent = preg_replace($pattern, '$1' . "\n" . $buyContent . "\n          </div>\n\n" . '$2', $content);

if ($newContent && $newContent !== $content) {
    file_put_contents($file, $newContent);
    echo "Successfully replaced Rent tab content.\n";
} else {
    echo "No changes made.\n";
}
