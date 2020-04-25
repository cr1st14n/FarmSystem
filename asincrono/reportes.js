$(function () {
  //activacion para select articulo
  $("#ventaGeneralTipo").on("change", ventaGeneralTipoDivs);
  $("#selectFechaVenta").on("change", onVerfechasVenta);
  $("#VGBuscar").on("keload", onVentaGeneralBuscar);
});

$(document).ready(function () {
  var table = $("#repArtGen").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
    },
    searching: false,
    processing: true,
    serverSide: false,
    scrollY: "50vh",
    scrollCollapse: true,
    paging: false,
    //"ajax": "/api/listRegistroVentas/",
    ajax: {
      url: "/FarmSystem/api/listArticulos/",
      type: "POST",
    },
    columns: [
      { data: "id" },
      { data: "art_nombreGenerico" },
      { data: "art_nombreComercial" },
      { data: "art_laboratorio" },
      { data: "art_proveedor" },
      { data: "art_costoProveedor" },
      { data: "art_costoVenta" },
      { data: "sto_cantidad" },
    ],
  });
});

$(document).ready(function () {
  $.get("/FarmSystem/api/listProvAticulo/", function (prov) {
    $("#listProvArticulo").html("");
    for (var i = prov.length - 1; i >= 0; i--) {
      var tr =
        `<tr>
                <td>Art-` +
        prov[i].id +
        `</td>
                <td>` +
        prov[i].prov_nombre +
        `</td>
                <td>` +
        prov[i].prov_direccion +
        `</td>
                <td>` +
        prov[i].prov_telf +
        ` Bs.-</td>
                <td>` +
        prov[i].prov_empresa +
        ` Bs.-</td>
                <td>` +
        prov[i].art_nombreGenerico +
        `</td>
                <td>` +
        prov[i].art_nombreComercial +
        `</td>
                
                </tr>`;
      $("#listProvArticulo").append(tr);
      //   console.log(prov[i]);
    }
  });
});

function ventaGeneralTipoDivs() {
  var cod = $(this).val();
  var div1 = document.getElementById("DVG1");
  var div2 = document.getElementById("DVG2");
  if (cod == 1) {
    div1.style.display = "block";
    div2.style.display = "none";
  }
  if (cod == 2) {
    div1.style.display = "none";
    div2.style.display = "block";
  }
}
function onVerfechasVenta() {
  var sel = $(this).val();
  var fecha0 = document.getElementById("fechaSimpleVenta");
  var fecha1 = document.getElementById("fechaRangoVenta");
  if (sel == 1) {
    fecha0.style.display = "block";
    fecha1.style.display = "none";
    $("#inpfecha0").setAttribute("required");
  }
  if (sel == 2) {
    fecha0.style.display = "none";
    fecha1.style.display = "block";
    $("#inpfecha1").setAttribute("required");
    $("#inpfecha2").setAttribute("required");
  }
}

function onVentaGeneralBuscar() {
  var VGtipoBusqueda = document.getElementById("ventaGeneralTipo").value;
  var fecha1 = document.getElementById("VGfecha1").value;
  var fecha2 = document.getElementById("VGfecha2").value;
  var fecha3 = document.getElementById("VGfecha3").value;

  if (VGtipoBusqueda == 1) {
    $("#tablaVG").dataTable().fnDestroy();
    var table = $("#tablaVG").DataTable({
      ajax: {
        url: "/FarmSystem/api/listVentaGeneralSinple/" + fecha1,
      },
      columns: [
        { data: "id" },
        { data: "vent_canTipoArticulos" },
        { data: "vent_canArticulosTotal" },
        { data: "vent_efectivoTotal" },
      ],
    });
  }
  if (VGtipoBusqueda == 2) {
    $("#tablaVG").dataTable().fnDestroy();
    var table = $("#tablaVG").DataTable({
      ajax: {
        url: "/FarmSystem/api/listVentaGeneralRango/" + fecha2 + "/" + fecha3,
      },
      columns: [
        { data: "id" },
        { data: "vent_canTipoArticulos" },
        { data: "vent_canArticulosTotal" },
        { data: "vent_efectivoTotal" },
      ],
    });
  }
}

$("#formCreateReporteVentas").submit(function (e) {
  e.preventDefault();
  console.log($(this).serialize());
  $("#md_view_reporte").modal("show");

  // var html= `<embed src="generarReporteVenta?${$(this).serialize()}" type="application/pdf" width="100%" height="1000px" frameborder="0" allowfullscreen >`;
  // $('#secpdf').html(html);
  $.ajax({
    type: "get",
    url: "generarReporteVenta",
    data: $(this).serialize(),
    success: function (response) {
      var pdf = new jsPDF("p", "pt", "letter");
      var canvas = pdf.canvas;
      canvas.height = 72 * 11;
      canvas.width = 72 * 8.5;
      // var width = 400;
      var html2 = response;
      var html1 = `<ul>
                <li>UL Item (default)</li>
                <li style='list-style-type: circle'>UL Item (circle)</li>
                <li style='list-style-type: square'>UL Item (square)</li>
                <li style='list-style-type: disc'>UL Item (disc)</li>
                <li style='list-style-type: none'>OL Item (none)</li>
            </ul>`;
      var specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        "#bypassme": function (element, renderer) {
          // true = "handled elsewhere, bypass text extraction"
          return true;
        },
      };
      var margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 522,
      };
      pdf.fromHTML(
        html2, 
        margins.left,
        margins.top,
        {
            // y coord
            width: margins.width, // max width of content on PDF
            elementHandlers: specialElementHandlers,
          },
          margins 
        );
      var ht = `<embed src="${pdf.output(
        "bloburl"
      )}" type="application/pdf" width="100%" height="1000px" frameborder="0" allowfullscreen >`;
      $("#view_reporte").html(ht);
      html2pdf(html2, pdf, function (canvas) {
        // document.getElementById('view_reporte').innerHTML(ht);
        //   var iframe = document.createElement('iframe');
        //   iframe.setAttribute('style','position:absolute;right:0; top:0; bottom:0; height:800px; width:100%');
        //   iframe.src = pdf.output('datauristring');
      });
    },
  });
});

/* function demoFromHTML() {
  var pdf = new jsPDF("p", "pt", "letter");
  // source can be HTML-formatted string, or a reference
  // to an actual DOM element from which the text will be scraped.
  source = $("#customers")[0];

  // we support special element handlers. Register them with jQuery-style
  // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
  // There is no support for any other type of selectors
  // (class, of compound) at this time.
  specialElementHandlers = {
    // element with id of "bypass" - jQuery style selector
    "#bypassme": function (element, renderer) {
      // true = "handled elsewhere, bypass text extraction"
      return true;
    },
  };
  margins = {
    top: 80,
    bottom: 60,
    left: 40,
    width: 522,
  };
  // all coords and widths are in jsPDF instance's declared units
  // 'inches' in this case
  pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top,
    {
      // y coord
      width: margins.width, // max width of content on PDF
      elementHandlers: specialElementHandlers,
    },

    function (dispose) {
      // dispose: object with X, Y of the last line add to the PDF
      //          this allow the insertion of new lines after html
      pdf.save("Test.pdf");
    },
    margins
  );
} */
