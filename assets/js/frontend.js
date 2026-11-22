console.log("Frontend.js");

jQuery(function ($) {
  function updateCart(key, qty = null, action = "scp_update_qty") {
    $.post(
      scpAjax.ajax_url,
      {
        action: action,
        nonce: scpAjax.nonce,
        key: key,
        qty: qty,
      },
      function (res) {
        console.log(res);
        if (res.success) {
          //$(".scp-side-cart").replaceWith(res.data.html);
          loadCart();
          $(".scp-count").html(res.data.count);
          $(document.body).trigger("wc_fragment_refresh");
        }
      },
    );
  }

  function loadCart() {
    $(".scp-cart-items").html(`<div class="scp-skeleton-loader">
                <div class="scp-skeleton-item">
                    <div class="scp-image-skeleton"></div>
                    <div class="scp-detail-skeleton">
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                    </div>
                </div>
                <div class="scp-skeleton-item">
                    <div class="scp-image-skeleton"></div>
                    <div class="scp-detail-skeleton">
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                    </div>
                </div>
                <div class="scp-skeleton-item">
                    <div class="scp-image-skeleton"></div>
                    <div class="scp-detail-skeleton">
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                        <span class="scp-detail-skeleton-line"></span>
                    </div>
                </div>
            </div>`);
    $.ajax({
      url: scpAjax.ajax_url,
      type: "POST",
      data: {
        action: "scp_load_cart",
      },
      success: function (res) {
        if (res.success) {
          $(".scp-cart-items").html(res.data.cart);
        } else {
          scpToast("Something went wrong!", "danger");
        }
      },
    });
  }

  $(document).on("mousedown", function (e) {
    const $cart = $(".scp-side-cart"); // your cart container
    const $toggleBtn = $(".scp-cart-toggle"); // optional: button that opens cart

    // If click is NOT inside cart AND NOT on toggle button
    if (
      !$cart.is(e.target) &&
      $cart.has(e.target).length === 0 &&
      !$(e.target).closest(".scp-cart-toggle").length
    ) {
      $cart.removeClass("open"); // or whatever class hides it
    }
  });

  $(document).ready(function () {
    loadCart();
  });

  // Open / Close cart
  $(document).on("click", ".scp-cart-toggle", function () {
    $(".scp-side-cart").addClass("open");
  });

  // Open / Close cart
  $(document).on("click", ".scp-close", function () {
    $(".scp-side-cart").removeClass("open");
  });

  // Quantity plus
  $(document).on("click", ".scp-qty-plus", function () {
    const input = $(this).siblings(".scp-qty-input");
    input[0].stepUp();
    input.change();
  });

  // Quantity minus
  $(document).on("click", ".scp-qty-minus", function () {
    const input = $(this).siblings(".scp-qty-input");
    let qty = parseInt(input.val()) - 1;
    input[0].stepDown();
    input.change();
  });

  // Manual input
  $(document).on("change", ".scp-qty-input", function () {
    updateCart($(this).data("key"), $(this).val());
  });

  // Remove item
  $(document).on("click", ".scp-remove", function () {
    $(this).closest(".scp-cart-item").css({
      opacity: 0.5,
      cursor: "not-allowed",
    });
    updateCart($(this).data("key"), null, "scp_remove_item");
  });

  $(document).on("scp_load_cart", loadCart);
});
