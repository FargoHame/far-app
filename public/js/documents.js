$('input[type="checkbox"]').change(function () {
    $(".document-" + this.value + "").hide();
});

$(".updatefile").change(function (e) {
    $(this)
        .parent()
        .parent()
        .parent()
        .find(".titlefield")
        .text(e.target.files[0].name);
    $(this)
        .parent()
        .parent()
        .parent()
        .find(".titlefield")
        .removeClass("text-gray-500");
    $(this).parent().find(".name").text(e.target.files[0].name);
});
$(".updatefileMobile").change(function (e) {
    $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".titlefield")
        .text(e.target.files[0].name);
    $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .find(".titlefield")
        .removeClass("text-gray-500");
    $(this).parent().find(".name").text(e.target.files[0].name);
});
