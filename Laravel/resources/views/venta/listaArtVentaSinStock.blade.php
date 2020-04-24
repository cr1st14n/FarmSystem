
<div class="box-body table-responsive no-padding">
    <table class="table table-hover ">
        <thead>
        <tr>
            <th >Cod</th>
            <th>Descripcion</th>
            <th style="text-align: right;">Cantidad ingresada</th>
            <th style="text-align: right;">cantidad en Stock</th>
            <th></th>
        </tr>
        </thead>
        <tbody >
        @foreach($lista as $carr)
            <tr>
                <td>Art-{{$carr->id}} </td>
                <td>{{$carr->art_nombreGenerico}} - ( {{$carr->art_nombreComercial}} )</td>
                <td style="text-align: right;">{{$carr->cantidad}} u. </td>
                @if($carr->stock == 1)
                    <td style="text-align: right;">{{$carr->stock}} _unidad.</td>
                @else
                    <td style="text-align: right;">{{$carr->stock}} _unidades.</td>
                @endif
                {{--<td style="text-align: right;">{{$carr->art_costoVenta}} Bs.- </td>
                <td> </td>
                <td> </td>
                <td style="text-align: right;">{{$carr->costo}} Bs.</td>
                <td style="text-align: right;">
                  <span class="tooltip-area">
                      <a  class="btn btn-default btn-sm btn-xs" title="Eliminar" onclick="CarrElimiArt({{$carr->id}});"><i class="fa fa-trash-o"></i></a>
                  </span>
                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

