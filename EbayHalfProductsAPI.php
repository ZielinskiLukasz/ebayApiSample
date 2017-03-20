<?php

class EbayHalfProductsAPI
{
    private $appKey;
    private $encoding;

    public function __construct(string $appKey, string $encoding)
    {
        $this->appKey = $appKey;
        $this->encoding = $encoding;
    }

    public function makeCall(string $productId, string $searchType)
    {
        $url = 'http://open.api.ebay.com/shopping?callname=FindHalfProducts&responseencoding=' . $this->encoding . '&appid=' . $this->appKey . '&version=967&ProductID.type=' . $searchType . '&ProductID.Value=' . $productId . '&IncludeSelector=Items';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $result = curl_exec($curl);
        curl_close($curl);
        
        return $result;
    }
}
