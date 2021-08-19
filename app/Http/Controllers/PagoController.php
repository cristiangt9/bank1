<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoController extends Controller
{
    private $precio = "100000.00";
    private $currency_code = "COP";
    private $publicKey = 'c80819b04203b844f110eeed016bf0c9';
    private $privateKey = '297643af3ec03de56e949fbcaaec1aca';
    public function index()
    {
        $description = "Esto es una descripción de prueba";
        return view('index', [
            'precio' => $this->precio,
            'currency_code' => $this->currency_code,
            'description' => $description,
            'publicKey' => $this->publicKey,
            'privateKey' => $this->privateKey,
        ]);
    }

    public function response(Request $request)
    {
        $response = $this->getDetailsPayment($request->ref_payco);
        return $this->confirmation($response["data"]);
    }

    public function getDataCard()
    {
        return view('formCard', ['publicKey' => $this->publicKey]);
    }

    public function tokenizationDataCard(Request $request)
    {
        dd($request->all());
        $epayco = new \Epayco\Epayco([
            "apiKey" => $this->publicKey,
            "privateKey" => $this->privateKey,
            "lenguage" => "ES",
            "test" => true
        ]);

        $token = $epayco->token->create(array(
            "card[number]" => $request,
            "card[exp_year]" => "2017",
            "card[exp_month]" => "07",
            "card[cvc]" => "123"
        ));
        return $token;
    }

    private function confirmation($request)
    {
        $p_cust_id_cliente = '529645';
        $p_key             = '149d11f7f95a7bb07b7075ab12762c9a55acfcdd';

        $x_ref_payco      = $request['x_ref_payco'];
        $x_transaction_id = $request['x_transaction_id'];
        $x_amount         = $this->precio; // el precio debe coincidir hasta en el tipo de variable
        $x_currency_code  = $this->currency_code; // se deben usar los valores almacenados en la base de datos
        $x_signature      = $request['x_signature'];


        $signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code);

        $x_response     = $request['x_response'];
        $x_motivo       = $request['x_response_reason_text'];
        $x_id_invoice   = $request['x_id_invoice'];
        $x_autorizacion = $request['x_approval_code'];

        //Validamos la firma
        $success = false;
        if ($x_signature == $signature) {

            /*Si la firma esta bien podemos verificar los estado de la transacción*/

            $x_cod_response = $request['x_cod_response'];

            switch ((int) $x_cod_response) {
                case 1:
                    # code transacción aceptada
                    $message = 'transacción aceptada';
                    $success = true;
                    // crear la modificación en la base de datos
                    break;

                case 2:
                    # code transacción rechazada
                    $message = 'transacción rechazada';
                    break;

                case 3:
                    # code transacción pendiente
                    $message = 'transacción pendiente';
                    break;

                default:
                    # code transacción fallida
                    $message = 'transacción fallida';
                    break;
            }
        } else {
            $message = 'Firma no valida';
            $x_motivo = 'Datos de pago no coinciden';
        }

        return view('response', [
            'success' => $success,
            'message' => $message,
            'x_response' => $x_response,
            'x_motivo' => $x_motivo,
            'x_id_invoice' => $x_id_invoice,
            'x_autorizacion' => $x_autorizacion,
            'data' => $request
        ]);
    }

    private function getDetailsPayment($refEpayco)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://secure.epayco.co/validation/v1/reference/$refEpayco",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 10
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}
