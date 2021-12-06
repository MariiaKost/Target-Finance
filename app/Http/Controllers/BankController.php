<?php

namespace App\Http\Controllers;

use App\Models\ReceivedPaketData;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function bankPaketData (Request $request) {

        try {
             $this->validateBankPaketData($request);

             $receivedModel = new ReceivedPaketData();
             $receivedModel->body = $request->getContent();
             $receivedModel->save();
             return "ok";

        } catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    private function validateBankPaketData(Request $request) {

        if (stripos($request->header("Content-Type"), "/xml") ===false) {
            throw new \Exception("The request must be of the xml type");
        }

        if ($request->header("token") !== env('API_KEY')) {
            throw new \Exception("Invalid authorization token");
        }
    }
}
