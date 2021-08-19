<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title> Resultado Transacción </title>
    <link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <!--[if lt IE 9]>
        <script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
        <script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
    <![endif]-->
</head>

<body>
    <header id='main-header' style='margin-top:20px'>
        <div class='row'>
            <div class='col-lg-12 franja'>
                <img 
                    class='center-block' 
                    src='https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/logo1.png' 
                    alt='logo'
                >
            </div>
        </div>
    </header>
    <div class=' container'>
        <div class='row' style='margin-top:20px'>
            <div class='col-lg-8 col-lg-offset-2 '>
                <h4 style='text-align:left'> Resultado de la Transacción </h4>
                <hr>
            </div>
            <div class='col-lg-8 col-lg-offset-2'>
                @if ($success)
                    <div class='table-responsive'>
                        <table class='table table-bordered'>
                            <tbody>
                                <tr>
                                    <td> Referencia </td>
                                    <td id='referencia'>{{$data["x_id_invoice"]}}</td>
                                </tr>
                                <tr>
                                    <td> No. de Autorización </td>
                                    <td id='respuesta'>{{$data["x_approval_code"]}}</td>
                                </tr>
                                <tr>
                                    <td class='bold'> Fecha </td>
                                    <td id='fecha' class=''>{{$data["x_transaction_date"]}}</td>
                                </tr>
                                <tr>
                                    <td> Respuesta </td>
                                    <td id='respuesta'>{{$data["x_response"]}}</td>
                                </tr>
                                <tr>
                                    <td> Motivo </td>
                                    <td id='motivo'>{{$data["x_response_reason_text"]}}</td>
                                </tr>
                                <tr>
                                    <td class='bold'> Banco </td>
                                    <td id='banco'>{{$data["x_bank_name"]}}</td>
                                </tr>
                                <tr>
                                    <td class='bold'> Recibo </td>
                                    <td id='recibo'>{{$data["x_transaction_id"]}}</td>
                                </tr>
                                <tr>
                                    <td class='bold'> Total </td>
                                    <td id=total>{{$data["x_amount"]}} {{$data["x_currency_code"]}}</td>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else 
                    <div> <b>Estado:</b> <p>{{$message}}</p></div>
                    <div> <b>Motivo:</b> <p>{{$x_motivo}}</p></div>

                @endif
            </div>
        </div>
    </div>
    <footer>
        <div class='row'>
            <div class='container'>
                <div class='col-lg-8 col-lg-offset-2'>
                    <img
                        src='https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/pagos_procesados_por_epayco_260px.png'
                        alt='Procesado por epayco'
                        style='margin-top:10px; float:left'
                    >
                    <img 
                        src='https://369969691f476073508a-60bf0867add971908d4f26a64519c2aa.ssl.cf5.rackcdn.com/btns/epayco/credibancologo.png'
                        alt='Credibanco logo'
                        height='40px'
                        style='margin-top:10px; float:right'
                    >
                </div>
            </div>
        </div>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js'> </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'> </script>
</body>

</html>
