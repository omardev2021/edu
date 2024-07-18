<?php

namespace App\Services;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Ramsey\Uuid\Type\Integer;

use Illuminate\Support\Facades\Session;
class PaymentService
{

    public function payment_api(Request $request, $total, $url)
    {
        $idorder = 'PHP_' . rand(1, 1000); // Customer Order ID

        // Payment gateway details live
//        $terminalId = "lowkalo"; // Provided by URWAY
//        $password = "lowkalo@7867"; // Provided by URWAY
//        $merchant_key = "fa58bd331c779c328fb9618e383fc5968205481ca340ae9688f012919bbbf0bd"; // Provided by URWAY
//        $currencycode = "SAR";
//        $amount = $total;
//        $txn_details = $idorder . '|' . $terminalId . '|' . $password . '|' . $merchant_key . '|' . $amount . '|' . $currencycode;
//        $hash = hash('sha256', $txn_details);




        $terminalId = "lowkalo"; // Will be provided by URWAY
        $password = "lowkalo@7867"; // Will be provided by URWAY
        $merchant_key = "fa58bd331c779c328fb9618e383fc5968205481ca340ae9688f012919bbbf0bd"; // Will be provided by URWAY
        $currencycode = "SAR";
        $amount = $total;
        $txn_details = $idorder . '|' . $terminalId . '|' . $password . '|' . $merchant_key . '|' . $amount . '|' . $currencycode;
        $hash = hash('sha256', $txn_details);


        // Payment request fields
        $fields = [
            'trackid' => $idorder,
            'terminalId' => $terminalId,
            'customerEmail' => auth()->user()->email,
            'action' => "1",  // Action is always 1
            'merchantIp' => $request->ip(),
            'password' => $password,
            'currency' => $currencycode,
            'country' => "SA",
            'amount' => $amount,
            "udf1" => "Test1",
            "udf2" => $url, // Response page URL
            "udf3" => "ar",
            "udf4" => "",
            "udf5" => "Test5",
            'requestHash' => $hash  // Generated hash
        ];

        $data = json_encode($fields);


        $ch = curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');

//        live
//        $ch = curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');



//                $ch = curl_init('https://payments.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        // Execute post
        $server_output = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return response()->json(['error' => $error_msg], 500);
        }

        // Close connection
        curl_close($ch);
        $result = json_decode($server_output);

        if (!empty($result->payid) && !empty($result->targetUrl)) {
            $payment_url = $result->targetUrl . '?paymentid=' . $result->payid;
            return Inertia::location($payment_url); // Redirect using Inertia
        } else {
            return redirect()->back()->withErrors(['error' => 'Payment initiation failed']);
        }
    }





//    public function payment_api(Request $request,$total,$url)
//    {
//        $idorder = 'PHP_' . rand(1, 1000); //Customer Order ID
//
//
//        // $terminalId = "lowkalo"; // Will be provided by URWAY
//        // $password = "URWAY_KALO@2695"; // Will be provided by URWAY
//        // $merchant_key = "6b1a1dc0ecaccc57dd93db0ca38a5fddadfa2c39036ce69c6cb0f103d70321ad"; // Will be provided by URWAY
//        // $currencycode = "SAR";
//        // $amount = $total;
//        // $txn_details = $idorder . '|' . $terminalId . '|' . $password . '|' . $merchant_key . '|' . $amount . '|' . $currencycode;
//        // $hash = hash('sha256', $txn_details);
//
//        $terminalId = "lowkalo"; // Will be provided by URWAY
//        $password = "lowkalo@7867"; // Will be provided by URWAY
//        $merchant_key = "fa58bd331c779c328fb9618e383fc5968205481ca340ae9688f012919bbbf0bd"; // Will be provided by URWAY
//        $currencycode = "SAR";
//        $amount = $total;
//        $txn_details = $idorder . '|' . $terminalId . '|' . $password . '|' . $merchant_key . '|' . $amount . '|' . $currencycode;
//        $hash = hash('sha256', $txn_details);
//
//
//
//        $fields = array(
//            'trackid' => $idorder,
//            'terminalId' => $terminalId,
//            'customerEmail' => auth()->user()->email,
//            'action' => "1",  // action is always 1
//            'merchantIp' => $request->ip(),
//            'password' => $password,
//            'currency' => $currencycode,
//            'country' => "SA",
//            'amount' => $amount,
//            "udf1"              => "Test1",
//            "udf2"              => $url, //Response page URL
//            "udf3"              => "ar",
//            "udf4"              => "",
//            "udf5"              => "Test5",
//            'requestHash' => $hash  //generated Hash
//        );
//        $data = json_encode($fields);
//        // $ch = curl_init('https://payments.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
//        $ch = curl_init('https://payments-dev.urway-tech.com/URWAYPGService/transaction/jsonProcess/JSONrequest');
//
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt(
//            $ch,
//            CURLOPT_HTTPHEADER,
//            array(
//                'Content-Type: application/json',
//                'Content-Length: ' . strlen($data)
//            )
//        );
//        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
//        //execute post
//        $server_output = curl_exec($ch);
//        //close connection
//        curl_close($ch);
//        $result = json_decode($server_output);
//        if (!empty($result->payid) && !empty($result->targetUrl)) {
//            $url = $result->targetUrl . '?paymentid=' .  $result->payid;
//
//
//
//
//            return response()->json([
//                'payment'=>$url,
//
//            ], 200);
//            // header('Location: '. $url, true, 307);//Redirect to Payment Page
//        } else {
//            return redirect()->back();
//            // print_r($result);
//            // echo "<br/><br/>";
//            // print_r($data);
//            // die();
//        }
//    }
}
