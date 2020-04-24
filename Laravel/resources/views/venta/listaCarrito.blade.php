<label id="CarritoCantidad" hidden>{{$cont}}</label>
<label id="CarritoCosto" hidden>{{$costo}}</label>
<label id="CarritoUnidades" hidden>{{$unidades}}</label>
<div class="box-body table-responsive no-padding">
    <table class="table table-hover ">
        <thead >
        <tr>
            <th style="border-color: #1fad83" >Cod</th>
            <th style="border-color: #1fad83">Descripcion</th>
            <th style="text-align: right;border-color: #1fad83;">unidad</th>
            <th style="text-align: right;border-color: #1fad83;">Precio unitario</th>
            <th style="text-align: right;border-color: #1fad83;">Total S/Descuento</th>
            <th style="text-align: right;border-color: #1fad83;">Descuento (%)</th>
            <th style="text-align: right;border-color: #1fad83;">Total con descuento</th>
            <th></th>
        </tr>
        </thead>
        <tbody >
        @foreach($carrito as $carr)
            <tr>
                <th>Art-{{$carr->id}} </th>
                <th>{{$carr->art_nombreGenerico}} - ( {{$carr->art_nombreComercial}} )</th>
                <th style="text-align: right;">{{$carr->cantidad}} u. </th>
                <th style="text-align: right;">{{$carr->art_costoVenta}} Bs.- </th>
                <th style="text-align: right;">{{$carr->costoSD}} Bs.</th>
                <th style="text-align: right;">{{$carr->descuento}}%</th>
                <th style="text-align: right;">{{$carr->costo}} Bs.</th>
                <th style="text-align: right;">
                  <span class="tooltip-area">
                      <a  class="btn btn-default btn-sm btn-xs" title="Eliminar" onclick="CarrElimiArt({{$carr->id}});"><i class="fa fa-trash-o"></i></a>
                  </span>
                        </th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

