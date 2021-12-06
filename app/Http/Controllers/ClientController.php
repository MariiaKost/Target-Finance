<?php

namespace App\Http\Controllers;

use App\Models\SentPaketData;
use Illuminate\Http\Request;
use App\Converting\ArrayToXmlConverter;
use App\Curl\CurlDataSender;

class ClientController extends Controller
{
    private $arrayToXmlConverter;

    private $curlDataSender;

    public function __construct
    (
        ArrayToXmlConverter $arrayToXmlConverter,
        CurlDataSender $curlDataSender
    )
    {
        $this->arrayToXmlConverter = $arrayToXmlConverter;
        $this->curlDataSender = $curlDataSender;
    }

    public function clientPaketData(Request $request) {

        try {
            $this->validateClientPaketData($request);
            $data = $request->all();

            $xml = $this->arrayToXmlConverter->process($data);

            $url = route('bank_paket_data');
            $sentPaket = $this->curlDataSender->sendXmlData($url,$xml);

            $sentModel = new SentPaketData();
            $sentModel->body = $sentPaket["body"];
            $sentModel->save();
            return "success";

        } catch (\Exception $exception){
            return $exception->getMessage();
        }


    }


    private function validateClientPaketData(Request $request) {

        if (!$request->isJson()) {
            throw new \Exception("The request must be of the json type");
         }

        if ($request->header("token") !== env('API_KEY')) {
             throw new \Exception("Invalid authorization token");
         }
    }


}
