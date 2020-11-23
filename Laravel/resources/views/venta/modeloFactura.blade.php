<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="{{ asset('factura/style.css') }}">
</head>

<body id="seleccion">
  <div class="ticket">
    <div align="center">
      <img src="{{ asset('plantilla/dist/img/logoFarmacia.jpg') }}">
    </div>
    <p class="centrado">
      <h2 class="centrado ">FARMACIA "SANTI"</h2>
    </p>

    <hr style="background-color: : #000000">
    <h3 class="centrado">FACTURA</h3>

    <p class="centrado">
      NIT: 6845502013
      <br> Nro. FACTURA: {{$numFactura}}
      <br> Nro. AUTORIZACION: 271101800121905
    </p>
    <hr>
    <tr>
      <td>Actividad economica</td>
      <td>Servicios</td>
    </tr><br>
    <tr>
      <td>Fecha:</td>
      <td>{{$date}} / {{$time}}</td>
    </tr><br>
    <tr>
      <td>NIT/CI:</td>
      <td>{{$dni}} </td>
    </tr><br>
    <tr>
      <td>Señor(es):</td>
      <td>{{$cliente}} </td>
    </tr>
    <hr>
    <h3 style="text-align: center;">DETALLE DE COMPRA</h3>


    <table>
      <thead>
        <tr>
          <th class="cantidad">CANT</th>
          <th class="producto">PRODUCTO</th>
          <th class="precio">P./U</th>t
          <th class="precio">Desc</th>
          <th class="precio">Sub <br> Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($carrito as $carr)
        <tr>
          <td class="cantidad">{{$carr->cantidad}} u </td>
          <td class="producto">{{$carr->art_nombreComercial}}-({{$carr->art_nombreGenerico}}) </td>
          <td class="precio">{{$carr->art_costoVenta}}</td>
          <td class="precio">{{$carr->descuento}}%</td>
          <td class="precio">{{$carr->costo}}</td>
        </tr>
        @endforeach

      </tbody>
    </table>
    <hr>

    <p style="text-align: right;">Efectivo Recivido: {{$e1}} Bs.-</p>
    <p style="text-align: right;">Precio Total: {{$costoTotal}} Bs.-</p>
    <p style="text-align: right;">Cambio Entregado: {{$e2}} Bs.-</p>
    <div class="" style="text-align:center">
      {!! QrCode::size(200)->generate($qr); !!}
    </div>
    <p class="centrado">
      Codigo de control:55-55-55-55 <br>
      Fecha limite de emicion dd-mm-yyyy <br>
      Ley # 453:Tienes derecho a un trato equitativo sin discriminacion en la oferta de servicios.
    </p>
  </div>
  <script src="{{ asset('plantilla/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script type="text/javascript">
    // $(document).ready(function(){
    //   window.print();
    setTimeout(() => {
      window.close();
    }, 300);
    // });
  </script>
</body>

</html>