<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotización</title>
    <style>
        /**
        * Set the margins of the PDF to 0
        * so the background image will cover the entire page.
        **/
        @page {
            margin: 0cm 0cm;
            font-family: 'Times New Roman', Times, serif;
        }

        /**
        * Define the real margins of the content of your PDF
        * Here you will fix the margins of the header and footer
        * Of your background image.
        **/
        body {
            margin-top:    3.5cm;
            margin-bottom: 1cm;
            margin-left:   1cm;
            margin-right:  1cm;
            color: #374957
        }

        /**
        * Define the width, height, margins and position of the watermark.
        **/
        #watermark {
            position: fixed;
            bottom:   0px;
            left:     0px;
            /** The width and height may change
                according to the dimensions of your letterhead
            **/
            width:    210mm;
            height:   297mm;

            /** Your watermark should be behind every content**/
            z-index:  -1000;
        }
         .titulo{
            color: #9f0f28;
            font-size: 40px;
            position: fixed;
            top: 30mm;
            left: 130mm;
        }
        .tabla-cabecera{
            position: fixed;
            top: 45mm;
            left: 130mm;
            font-size: 20px
        }
        .tabla-cabecera  table th {
            text-align: left;
            width: 30mm;
        }
        .tabla-cabecera  table  td{
            text-align: right;
        }

        .tabla-detalle table{

            /* font-size: 18px; */
            /* border-collapse:separate;
            border-spacing: 0 2em; */

        }
        .tabla-detalle table thead{
            font-size: 20px;
            color: #9f0f28;
            font-weight: bold;
            text-align: left;
        }
        .tabla-detalle table thead th{
            text-align: left;
        }
        .tabla-detalle td{
            /* padding-top: 15px;
            padding-bottom: 15px; */
            padding: 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #374957;
        }
        th.numero{
            width: 10mm;
        }
        th.detalle{
            width: 55mm;
        } th.cantidad{
            width: 24mm;
        }
        header{

        }
        footer {
            position: fixed;
            bottom: 4cm;
            left: 1cm;
            right: 1cm;
            height: 2cm;
            /* background-color: #2a0927;
            color: white; */
            text-align: left;
            line-height: 35px;
        }
        main{
            font-size: 20px;
            width: 170mm;
            height: 160mm;
            max-height: 160mm;
            position: fixed;
            top: 75mm;
            left: 20mm;
        }
        .tabla-totales{
            font-size: 20px;
            position: relative;
            left: 115mm;
            margin-top: 1cm;
        }
        .tabla-totales th{
            width: 30mm;
            text-align: left
        }
        .tabla-totales td{
            text-align: right
        }
    </style>
</head>

<body>
    <div id="watermark">
        {{-- <img src="http://cotizador.test/img/bg-cotiz.png" height="100%" width="100%" /> --}}
        <img src="{{ $background }}" height="100%" width="100%" />
    </div>
    <header>
        <h1 class="titulo">COTIZACIÓN</h1>
        <div class="tabla-cabecera">
            <table >
                <tbody>
                    <tr>
                        <th>Numero#</th>
                        <td>00001</td>
                    </tr>
                    <tr>
                        <th>Fecha</th>
                        <td>{{$cotizacion->fecha}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </header>
    <main>


        <div >
            <table class="tabla-detalle">
                <thead>
                    <tr>
                        <th class="numero">N°</th>
                        <th class="detalle">Producto</th>
                        <th class="cantidad">Cant.</th>
                        <th class="cantidad">Precio</th>
                        <th class="cantidad">Iva</th>
                        <th class="cantidad">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotizacion->detalles as $d)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$d->producto->nombre}}</td>
                        <td>{{$d->cantidad}}</td>
                        <td>$ {{$d->valorunitario}}</td>
                        <td>{{$d->iva}}%</td>
                        <td>$ {{$d->cantidad * $d->valorunitario}}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <div>
                <table class="tabla-totales">
                    <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>$ {{$cotizacion->valorsubtotal}}</td>
                        </tr>
                        @if ($cotizacion->valordescuento > 0)
                        <tr>
                            <th>Desc. {{ $cotizacion->descuento}}%</th>
                            <td>$ {{$cotizacion->valordescuento}}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Iva 12%</th>
                            <td>$ {{$cotizacion->valoriva}}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>$ {{$cotizacion->valortotal}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer>
        <p>Esta cotización tiene una validez de siete días a partir de su fecha de emisión.</p>
    </footer>
</body>
</html>
