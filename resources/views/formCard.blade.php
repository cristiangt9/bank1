<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Ingrese sus datos de pago</title>
    <script src="https://checkout.epayco.co/epayco.min.js"></script>
</head>

<body>
    <div class="container" class="p-5">
    <form method="POST" action="{{route('savePaymentInformation')}}" id="customer-form">
        @csrf
        <div class="card-errors"></div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Nombres</label>
            <input type="text" class="form-control" data-epayco="card[name]" placeholder="Cristian Gonzalez" name="nombre" value="Cristian Gonzalez">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Correo Electrónico</label>
            <input type="email" class="form-control" data-epayco="card[email]" placeholder="name@example.com">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Número de Tarjeta</label>
            <input type="text" class="form-control" data-epayco="card[number]" placeholder="4242424242424242"
                maxlength="16" minlength="15">
        </div>
        <div class="form-group">
            <label>Fecha de Vencimiento(MM/AAAA)</label>
            <div>
                <select class="form-control" id="exp_month" data-epayco="card[exp_month]" style="width:100px; display: inline-block">
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>06</option>
                    <option>07</option>
                    <option>08</option>
                    <option>09</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                </select>
                <select class="form-control" id="exp_year" data-epayco="card[exp_year]" style="width:100px; display: inline-block">
                    <option>2021</option>
                    <option>2022</option>
                    <option>2023</option>
                    <option>2024</option>
                    <option>2025</option>
                </select>
        </div>

        </div>
        <div class="form-group">
            <label>CVC</label>
            <input type="password" class="form-control" data-epayco="card[cvc]" placeholder="123"
                maxlength="4" minlength="3">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Guardar</button>
    </form>
        </div>
</body>
<script>
    ePayco.setPublicKey('{{$publicKey}}');
    $('#customer-form').submit(function(event) {
        //detiene el evento automático del formulario
        event.preventDefault();
        //captura el contenido del formulario
        var $form = $(this);
        //deshabilita el botón para no acumular peticiones
        $form.find("button").prop("disabled", true);
        //hace el llamado al servicio de tokenización
        ePayco.token.create($form, function(error, token) {
            //habilita el botón al obtener una respuesta
            $form.find("button").prop("disabled", false);
            if(!error) {
                //si la petición es correcta agrega un input "hidden" con el token como valor
                $form.append($("<input type='hidden' name='epaycoToken'>").val(token));
                //envia el formulario para que sea procesado
                $form.get(0).submit();
            } else {
                //muestra errores que hayan sucedido en la transacción
                $('.customer-errors').text(error.data.description);
            }
        });
    });
</script>

</html>