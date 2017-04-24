var idPredmet, semestr;

$("#listPredmet").change(function () {
    idPredmet = $("#listPredmet option:selected").val();
    $.ajax({
        type: "POST",
        async: false,
        url: "../ajax/ajax_semestr.php",
        data: ({id_predmet: idPredmet})
    }).done(function (data) {
        $("#listSemestr").html(data);
    });
});

$("#listSemestr").change(function () {
    semestr = $("#listSemestr option:selected").val();
    $.ajax({
        type: "POST",
        async: false,
        url: "../ajax/ajax_group.php",
        data: ({id_predmet: idPredmet, semestr: semestr})
    }).done(function (data) {
        $("#listGroup").html(data);
    });
});

$("#listGroup").change(function () {
    mainId = $("#listGroup option:selected").val();
    $.ajax({
        type: "POST",
        async: false,
        url: "../ajax/ajax_mainTable.php",
        data: ({main_id: mainId})
    }).done(function (data) {
        $("#mainPrepodTable").html(data);
    });
});