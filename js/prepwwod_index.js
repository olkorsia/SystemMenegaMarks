    var id_predmet, semestr, group_id;

    $(function () {
        console.log("Work");
    });

    $("#listPredmet").change(function () {
        id_predmet = $("#listPredmet option:selected").val();
        alert(id_predmet);
        /*$.ajax({
         type: "POST",
         async: false,
         url: "../ajax/ajax_semestr.php",
         data: ({id_predmet: id_predmet})
         }).done(function (data) {
         $("#select_semestr").html(data);
         });*/
    });

    /*$("#listSemestr").change(function () {
     semestr = $("#listSemestr option:selected").val();
     $.ajax({
     type: "POST",
     async: false,
     url: "ajax_group.php",
     data: ({id_predmet: id_predmet, semestr: semestr})
     }).done(function (data) {
     $("#select_group").html(data);
     });
     });

     $("#listGroup").change(function () {
     group_id = $("#listGroup option:selected").val();
     $.ajax({
     type: "POST",
     async: false,
     url: "ajax_mainTable.php",
     data: ({id_predmet: id_predmet, semestr: semestr, group_id: group_id})
     }).done(function (data) {
     $("#mainPrepodTable").html(data);
     });
     });*/
