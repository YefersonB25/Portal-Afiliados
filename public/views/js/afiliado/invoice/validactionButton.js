let LoadData = function (Card) {
    let validacionButton = function (Card) {
        if (Card == "#oculto-por-pagar") {

            if ($("#oculto-por-pagar").css("display") == 'none')
                $("#oculto-por-pagar").show("slow");
            else
                $("#oculto-por-pagar").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-pagadas-con-novedad").css("display") != 'none')
                $("#oculto-pagadas-con-novedad").hide("slow");

            if ($("#facturas-en-transporte").css("display") != 'none')
                $("#facturas-en-transporte").hide("slow");

            if ($("#FacturasGenerales").css("display") != 'none')
                $("#FacturasGenerales").hide("slow");
        } else if (Card == "#oculto-pagadas-con-novedad") {

            if ($("#oculto-pagadas-con-novedad").css("display") == 'none')
                $("#oculto-pagadas-con-novedad").show("slow");
            else
                $("#oculto-pagadas-con-novedad").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-por-pagar").css("display") != 'none')
                $("#oculto-por-pagar").hide("slow");

            if ($("#facturas-en-transporte").css("display") != 'none')
                $("#facturas-en-transporte").hide("slow");

            if ($("#FacturasGenerales").css("display") != 'none')
                $("#FacturasGenerales").hide("slow");
        } else if (Card == "#FacturasGenerales") {
            if ($("#FacturasGenerales").css("display") == 'none')
                $("#FacturasGenerales").show("slow");
            else
                $("#FacturasGenerales").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-pagadas-con-novedad").css("display") != 'none')
                $("#oculto-pagadas-con-novedad").hide("slow");

            if ($("#oculto-por-pagar").css("display") != 'none')
                $("#oculto-por-pagar").hide("slow");

            if ($("#facturas-en-transporte").css("display") != 'none')
                $("#facturas-en-transporte").hide("slow");

        } else if (Card == "#facturas-en-transporte") {
            if ($("#facturas-en-transporte").css("display") == 'none')
                $("#facturas-en-transporte").show("slow");
            else
                $("#facturas-en-transporte").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-pagadas-con-novedad").css("display") != 'none')
                $("#oculto-pagadas-con-novedad").hide("slow");

            if ($("#FacturasGenerales").css("display") != 'none')
                $("#FacturasGenerales").hide("slow");

            if ($("#oculto-por-pagar").css("display") != 'none')
                $("#oculto-por-pagar").hide("slow");

        }
    }
}
