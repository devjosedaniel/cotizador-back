<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ url('css/pdfcotiza.css') }}"> --}}
    <title>Cotización</title>
    <style>
        @page {
                margin: 0cm 0cm 0cm 0cm;
                font-size: 1em;
                 color: #374957;
            }

            body {
                margin: 8cm 2cm 8cm;
            }

            #watermark {
                position: fixed;
                bottom: 0px;
                left: 0px;
                width: 210mm;
                height: 297mm;
                z-index: -1000;
            }

            .page-break {
                page-break-after: always;
            }

            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 7cm;
                text-align: center;
                line-height: 30px;
            }

            footer {
                position: fixed;
                bottom: 0cm;
                left: 2cm;
                right: 0cm;
                height: 8cm;
                text-align: left;
                /* line-height: 35px; */
            }
            /* css de contenido */

            .titulo{
                color: #9f0f28;
                font-size: 35px;
                position: fixed;
                top: 30mm;
                left: 140mm;
            }
            table.tabla-cabecera{
                position: fixed;
                top: 45mm;
                left: 130mm;
                font-size: 20px
            }
            table.tabla-cabecera   th {
                text-align: left;
                width: 2.5cm;
            }
            table.tabla-cabecera    td{
                text-align: right;
                width: 3cm;
            }
            .container {
                width: 100%;
                padding-right: var(--bs-gutter-x, .75rem);
                padding-left: var(--bs-gutter-x, .75rem);
                margin-right: auto;
                margin-left: auto;
            }
             table.tabla-detalle{
                width: 100%!important;
            }
            table.tabla-detalle  thead{
                font-size: 20px;
                color: #9f0f28;
                font-weight: bold;
                text-align: left;
            }
            table.tabla-detalle  thead th{
                 text-align: center;
             }
            table.tabla-detalle td{
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
            }
            th.cantidad{
                width: 24mm;
            }
            table.tabla-totales{
                font-size: 20px;
                position: relative;
                left: 115mm;
                margin-top: 0cm;
                margin-bottom: 0cm;
            }
            table.tabla-totales th{
                width: 30mm;
                text-align: left
            }
            table.tabla-totales td{
                text-align: right
            }
    </style>
</head>
<body>
    <div id="watermark">
        <img src="{{ url('img/bg-cotiz.jpg') }}" height="100%" width="100%" />
    </div>
    <header>
        <h1 class="titulo">COTIZACIÓN</h1>
            <table class="tabla-cabecera">
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

    </header>
    <div class="container">
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

    </div>
    <footer>
        <table  class="tabla-totales">
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
        <p>Esta cotización tiene una validez de siete días a partir de su fecha de emisión.</p>
    </footer>
    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 720, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>
</body>
</html>
