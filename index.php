<?php

require_once './EbayHalfProductsAPI.php';

$appKey = '<INPUT YOUR APP KEY HERE>';
$encoding = 'JSON';

$apiCall = new EbayHalfProductsAPI($appKey, $encoding);

// sample input data
$sampleIds = [
    ['id' => '9780451524935', 'type' => 'EAN' ],
    ['id' => '9781419722868', 'type' => 'ISBN' ],
    ['id' => '075678252624', 'type' => 'UPC' ]
];

foreach ($sampleIds as $sampleId) {
    // get the response from eBay API
    $response = $apiCall->makeCall($sampleId['id'], $sampleId['type']);

    // decode json to object
    $json_response = json_decode($response);

    // no products found
    if (null === $json_response->Products) {
        continue;
    }

    $products = $json_response->Products->Product[0]->ItemArray->Item;

    echo '<h1>Found: ' . count($products) . ' products</h1>';
    echo '<p>Search by ' . $sampleId['type'] . ': ' . $sampleId['id'] . '</p>';
    echo '<table style="border: 1px solid #666; ">';
    echo '<thead><th>Product ID</th><th>URL</th><th>Quantity</th><th>Country</th><th>Price</th><th>Condition</th></thead>';
    echo '<tbody>';
    foreach ($products as $product) {
        echo '<tr>';
        echo '<td>' . $product->ItemID . '</td>';
        echo '<td><a target="_blank" href="' . $product->ViewItemURLForNaturalSearch . '">' . $product->ViewItemURLForNaturalSearch . '</a></td>';
        echo '<td>' . $product->Quantity . '</td>';
        echo '<td>' . $product->Country . '</td>';
        echo '<td>' . $product->CurrentPrice->Value . ' ' . $product->CurrentPrice->CurrencyID . '</td>';
        echo '<td>' . $product->HalfItemCondition . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
