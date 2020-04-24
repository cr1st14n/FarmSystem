<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="{{ asset('factura/style.css') }}">
  
</head>

<body id="seleccion">
  <div >Este texto es lo que se imprimirá cuando se pulse el enlace.</div>
  <a href="javascript:imprSelec('tabla')" >Imprimir texto</a>
  <div class="ticket">
    <img src="{{ asset('plantilla/dist/img/user2-160x160.jpg') }}" alt="Logotipo" class="centrado">
    <p class="centrado">TICKET DE VENTA
      <br>New New York
      <br>17/10/2017 02:22 a.m.</p>
    <table >
      <thead>
        <tr>
          <th class="cantidad">CANT</th>
          <th class="producto">PRODUCTO</th>
          <th class="precio">$$</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="cantidad">1.00</td>
          <td class="producto">CHEETOS VERDES 80 G</td>
          <td class="precio">$8.50</td>
        </tr>
        <tr>
          <td class="cantidad">2.00</td>
          <td class="producto">KINDER DELICE</td>
          <td class="precio">$10.00</td>
        </tr>
        <tr>
          <td class="cantidad">1.00</td>
          <td class="producto">COCA COLA 600 ML</td>
          <td class="precio">$10.00</td>
        </tr>
        <tr>
          <td class="cantidad"></td>
          <td class="producto">TOTAL</td>
          <td class="precio">$28.50</td>
        </tr>
      </tbody>
    </table>
    <p class="centrado">¡GRACIAS POR SU COMPRA!
      <br>parzibyte.me</p>
  </div>
  <div class="ticket" >
    <img src="" alt="Logotipo">
    <p class="centrado">TICKET DE VENTA
      <br>New New York
      <br>17/10/2017 02:22 a.m.</p>
    <table >
      <thead>
        <tr>
          <th class="cantidad">CANT</th>
          <th class="producto">PRODUCTO</th>
          <th class="precio">$$</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="cantidad">1.00</td>
          <td class="producto">CHEETOS VERDES 80 G</td>
          <td class="precio">$8.50</td>
        </tr>
        <tr>
          <td class="cantidad">2.00</td>
          <td class="producto">KINDER DELICE</td>
          <td class="precio">$10.00</td>
        </tr>
        <tr>
          <td class="cantidad">1.00</td>
          <td class="producto">COCA COLA 600 ML</td>
          <td class="precio">$10.00</td>
        </tr>
        <tr>
          <td class="cantidad"></td>
          <td class="producto">TOTAL</td>
          <td class="precio">$28.50</td>
        </tr>
      </tbody>
    </table>
    <p class="centrado">¡GRACIAS POR SU COMPRA!
      <br>parzibyte.me</p>
  </div>
  <button class="oculto-impresion" id="btnImprimirDiv">Imprimir</button>
<script src="{{ asset('factura/script2.js') }}"></script>

</body>
</html>