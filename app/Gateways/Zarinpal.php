<?php

namespace App\Gateways;

use SoapClient;
use App\Traits\Response;
use App\Interfaces\Gateway;
use App\Validations\PaymentValidation;

class Zarinpal implements Gateway
{
    use Response;

    public $paymentValidation;

    public function __construct(PaymentValidation $paymentValidation)
    {
        $this->paymentValidation = $paymentValidation;
    }

    private function curl_check()
    {
        return (function_exists('curl_version')) ? true : false;
    }

    private function soap_check()
    {
        return (extension_loaded('soap')) ? true : false;
    }

    private function zarinpal_node()
    {
        if ($this->curl_check() === true) {
            $ir_ch = curl_init("https://www.zarinpal.com/pg/services/WebGate/wsdl");
            curl_setopt($ir_ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ir_ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ir_ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ir_ch);
            $ir_info = curl_getinfo($ir_ch);
            curl_close($ir_ch);

            $de_ch = curl_init("https://de.zarinpal.com/pg/services/WebGate/wsdl");
            curl_setopt($de_ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($de_ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($de_ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($de_ch);
            $de_info = curl_getinfo($de_ch);
            curl_close($de_ch);

            $ir_total_time = (isset($ir_info['total_time']) && $ir_info['total_time'] > 0) ? $ir_info['total_time'] : false;
            $de_total_time = (isset($de_info['total_time']) && $de_info['total_time'] > 0) ? $de_info['total_time'] : false;

            return ($ir_total_time === false || $ir_total_time > $de_total_time) ? "de" : "ir";
        } else {
            if (function_exists('fsockopen')) {
                $de_ping = $this->zarinpal_ping("de.zarinpal.com", 80, 1);
                $ir_ping = $this->zarinpal_ping("www.zarinpal.com", 80, 1);

                $de_domain = "https://de.zarinpal.com/pg/services/WebGate/wsdl";
                $ir_domain = "https://www.zarinpal.com/pg/services/WebGate/wsdl";

                $ir_total_time = (isset($ir_ping) && $ir_ping > 0) ? $ir_ping : false;
                $de_total_time = (isset($de_ping) && $de_ping > 0) ? $de_ping : false;

                return ($ir_total_time === false || $ir_total_time > $de_total_time) ? "de" : "ir";
            } else {
                $webservice = "https://www.zarinpal.com/pg/services/WebGate/wsd";
                $headers = @get_headers($webservice);

                return (strpos($headers[0], '200') === false) ? "de" : "ir";
            }
        }
    }

    private function zarinpal_ping($host, $port, $timeout)
    {
        $time_b = microtime(true);
        $fsockopen = @fsockopen($host, $port, $errno, $errstr, $timeout);

        if (!$fsockopen) {
            return false;
        } else {
            $time_a = microtime(true);
            return round((($time_a - $time_b) * 1000), 0);
        }
    }

    public function redirect($url)
    {
        @redirect($url);
        echo "<meta http-equiv='refresh' content='0; url={$url}' />";
        echo "<script>window.location.href = '{$url}';</script>";
        exit;
    }

    public function request($info)
    {
        $SandBox = true;
        $ZarinGate = false;
        if ($this->soap_check() === true) {
            $client = new SoapClient("https://sandbox.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);
            $MerchantID = 'qw34rt65-12gh-sey6-dgy6-as34fg7h5fzc';


            $result = $client->PaymentRequest([
                'MerchantID' => $MerchantID,
                'Amount' => $info['amount'],
                'Description' => $info['description'],
                'Email' => $info['email'],
                'CallbackURL' => $info['callbackUrl'],
            ]);


            $Status = (isset($result->Status) && $result->Status != "") ? $result->Status : 0;
            $Authority = (isset($result->Authority) && $result->Authority != "") ? $result->Authority : "";
            $StartPay = (isset($result->Authority) && $result->Authority != "") ? "https://sandbox.zarinpal.com/pg/StartPay/" . $Authority : "";
            $StartPayUrl = (isset($ZarinGate) && $ZarinGate == true) ? "{$StartPay}/ZarinGate" : $StartPay;
            return array(
                "Method" => "SOAP",
                "Status" => $Status,
                "Message" => $this->paymentValidation->error_message($Status, $info['description'], $info['callbackUrl'], true),
                "StartPay" => $StartPayUrl,
                "Authority" => $Authority
            );
        } else {
            $data = array(
                'MerchantID' => $MerchantID,
                'Amount' => $info['amount'],
                'Description' => $info['description'],
                'CallbackURL' => $info['callbackUrl'],
            );


            $jsonData = json_encode($data);
            $ch = curl_init("https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json");
            curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonData)));

            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            $result = json_decode($result, true);

            if ($err) {
                $Status = 0;
                $Message = "cURL Error #:" . $err;
                $Authority = "";
                $StartPay = "";
                $StartPayUrl = "";
            } else {
                $Status = (isset($result["Status"]) && $result["Status"] != "") ? $result["Status"] : 0;
                $Message = $this->paymentValidation->error_message($Status, $info['description'], $info['callbackUrl'], true);
                $Authority = (isset($result["Authority"]) && $result["Authority"] != "") ? $result["Authority"] : "";
                $StartPay = (isset($result["Authority"]) && $result["Authority"] != "") ? "https://{$upay}.zarinpal.com/pg/StartPay/" . $Authority : "";
                $StartPayUrl = (isset($ZarinGate) && $ZarinGate == true) ? "{$StartPay}/ZarinGate" : $StartPay;
            }

            $response = array(
                "Method" => "CURL",
                "Status" => $Status,
                "Message" => $Message,
                "StartPay" => $StartPayUrl,
                "Authority" => $Authority
            );
        }

        return $response;
    }

    public function verify($info)
    {
        $SandBox = true;
        $ZarinGate = false;
        $ZarinGate = ($SandBox == true) ? false : $ZarinGate;

        if ($this->soap_check() === true) {
            $au = $info['authority'];
            $node = ($SandBox == true) ? "sandbox" : $this->zarinpal_node();


            $client = new SoapClient("https://{$node}.zarinpal.com/pg/services/WebGate/wsdl", ['encoding' => 'UTF-8']);
            $MerchantID = 'qw34rt65-12gh-sey6-dgy6-as34fg7h5fzc';
            $result = $client->PaymentVerification([
                'MerchantID' => $MerchantID,
                'Authority' => $au,
                'Amount' => $info['amount'],
            ]);


            $Status = (isset($result->Status) && $result->Status != "") ? $result->Status : 0;
            $RefID = (isset($result->RefID) && $result->RefID != "") ? $result->RefID : "";
            $Message = $this->paymentValidation->error_message($Status, "", "", false);

            return array(
                "Node" => "{$node}",
                "Method" => "SOAP",
                "Status" => $Status,
                "Message" => $Message,
                "Amount" => $info['amount'],
                "RefID" => $RefID,
                "Authority" => $au
            );
        } else {
            $au = $info['authority'];
            $node = ($SandBox == true) ? "sandbox" : "ir";
            $upay = ($SandBox == true) ? "sandbox" : "www";

            $MerchantID = 'qw34rt65-12gh-sey6-dgy6-as34fg7h5fzc';

            $data = array('MerchantID' => $MerchantID, 'Authority' => $au, 'Amount' => $info['amount']);
            $jsonData = json_encode($data);
            $ch = curl_init("https://{$upay}.zarinpal.com/pg/rest/WebGate/PaymentVerification.json");
            curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonData)));

            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            $result = json_decode($result, true);

            if ($err) {
                $Status = 0;
                $Message = "cURL Error #:" . $err;
                $Status = "";
                $RefID = "";
            } else {
                $Status = (isset($result["Status"]) && $result["Status"] != "") ? $result["Status"] : 0;
                $RefID = (isset($result['RefID']) && $result['RefID'] != "") ? $result['RefID'] : "";
                $Message = $this->paymentValidation->error_message($Status, "", "", false);
            }

            return array(
                "Node" => "{$node}",
                "Method" => "CURL",
                "Status" => $Status,
                "Message" => $Message,
                "Amount" => $info['amount'],
                "RefID" => $RefID,
                "Authority" => $au
            );
        }
    }
}

