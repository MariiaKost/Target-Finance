<?php

namespace App\Curl;


class CurlDataSender
{
    public function sendXmlData($url, $xml) {

            $headers = array (
                'Content-Type: application/xml',
                'token: '. env('API_KEY')
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
            $res = curl_exec($curl);

            if ($res!=="ok") {
                throw new \Exception($res);
            } else {
                return array(
                    "headers" => $headers,
                    "body" => $xml
                );
            }
            curl_close($curl);

    }
}
