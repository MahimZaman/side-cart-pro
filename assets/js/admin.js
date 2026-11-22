jQuery(function ($) {
  $(".scp-tabs button").on("click", function () {
    const tab = $(this).data("tab");

    $(".scp-tabs button").removeClass("active");
    $(this).addClass("active");

    $(".scp-panel").removeClass("active");
    $('.scp-panel[data-panel="' + tab + '"]').addClass("active");
  });
});

jQuery(document).ready(function ($) {
  $(".scp-color-field").wpColorPicker();
});
