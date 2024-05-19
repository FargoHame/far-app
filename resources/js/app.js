require("./bootstrap");

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

window.$ = require("jquery");
let $ = window.$;
require("./ion.rangeSlider.min.js");
// hide or show password content on password field
window.$(".password-field svg").click(function () {
    let attr = window.$(this).parent().find(".password").attr("type");
    window
        .$(this)
        .parent()
        .find(".password")
        .attr("type", attr !== "text" ? "text" : "password");
});
// new type user selector registration page
$(".user-type .user").click(function () {
    if ($(this).text() === "As a Preceptor") {
        $("#role").val("preceptor");
        $(".user-type .user").removeClass("active-left");
        $(this).addClass("active-right");
    } else {
        $("#role").val("student");
        $(".user-type .user").removeClass("active-right");
        $(this).addClass("active-left");
    }
    const e = new Event("change");
    const element = document.querySelector("#role");
    element.dispatchEvent(e);
});
