console.log("upsell js");

function scpLoadUpsells() {
  jQuery.post(
    scpUpsell.ajax_url,
    {
      action: "scp_get_upsell_loop",
      nonce: scpUpsell.nonce,
    },
    function (html) {
      jQuery("#scp-upsell-container").html(html);

      new Swiper(".scp-upsell-slider", {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: {
          el: ".swiper-pagination",
        },
        breakpoints: {
          768: { slidesPerView: 1 },
          480: { slidesPerView: 1 },
        },
      });
    },
  );
}

jQuery(function ($) {
  scpLoadUpsells();

  $(document.body).on("wc_fragment_refresh", function () {
    scpLoadUpsells();
  });

  $(document).on("click", ".scp-add-to-cart", function () {
    let item = $(this).closest(".scp-upsell-item");
    let productId = item.data("product-id");
    let type = item.data("product-type");

    $(this).find(".scp-btn-loader").css({
      display: "inline-block",
    });

    if (type === "simple") {
      $.post(
        scpUpsell.ajax_url,
        {
          action: "scp_add_to_cart",
          product_id: productId,
          nonce: scpUpsell.nonce,
        },
        function (res) {
          $(document.body).trigger("wc_fragment_refresh");
          $(".scp-add-to-cart").find(".scp-btn-loader").css({
            display: "none",
          });
          $(document).trigger("scp_load_cart");
        },
      );
    }

    if (type === "variable") {
      $.post(
        scpUpsell.ajax_url,
        {
          action: "scp_load_variations",
          product_id: productId,
          nonce: scpUpsell.nonce,
        },
        function (html) {
          scpOpenPopup(html);
          $(".scp-add-to-cart").find(".scp-btn-loader").css({
            display: "none",
          });
        },
      );
    }
  });

  window.scpOpenPopup = function (content) {
    let popup = $(
      '<div class="scp-popup"><div class="scp-popup-inner"></div></div>',
    );
    popup.find(".scp-popup-inner").html(content);
    $("body").append(popup);
  };

  $(document).on("submit", ".variations_form", function (e) {
    e.preventDefault();

    let form = $(this);

    $.post(
      scpUpsell.ajax_url,
      {
        action: "scp_add_to_cart",
        product_id: form.find("input[name=product_id]").val(),
        variation_id: form.find("input[name=variation_id]").val(),
        variations: form.serializeArray(),
        nonce: scpUpsell.nonce,
      },
      function () {
        $(".scp-popup").remove();
        $(document.body).trigger("wc_fragment_refresh");
      },
    );
  });

  $(document).on("change", ".scp-variation-select", function () {
    let form = $(this).closest(".scp-variation-form");
    let variations = form.data("variations");
    let selected = {};

    form.find(".scp-variation-select").each(function () {
      let name = $(this).attr("name");
      let val = $(this).val();
      if (val) selected[name] = val;
    });

    let match = null;

    $.each(variations, function (i, variation) {
      let isMatch = true;

      $.each(variation.attributes, function (attr, val) {
        if (selected[attr] !== val) {
          isMatch = false;
        }
      });

      if (isMatch) {
        match = variation;
        return false;
      }
    });

    if (match) {
      form.find("input[name=variation_id]").val(match.variation_id);
    }
  });

  $(document).on("submit", ".scp-variation-form", function (e) {
    e.preventDefault();

    let form = $(this);
    let variationId = form.find("input[name=variation_id]").val();

    if (!variationId) {
      alert("Please select options");
      return;
    }

    $.post(
      scpUpsell.ajax_url,
      {
        action: "scp_add_to_cart",
        product_id: form.data("product_id"),
        variation_id: variationId,
        nonce: scpUpsell.nonce,
      },
      function () {
        $(".scp-popup").remove();
        $(document.body).trigger("wc_fragment_refresh");
      },
    );
  });
});
