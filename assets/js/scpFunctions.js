function scpToast(message, type = "primary", duration = 3000) {
  const icons = {
    primary: "ri-information-line",
    secondary: "ri-file-list-3-line",
    success: "ri-checkbox-circle-line",
    danger: "ri-close-circle-line",
    warning: "ri-error-warning-line",
    info: "ri-information-line",
    dark: "ri-moon-line",
    light: "ri-sun-line",
  };

  if (!$("#scp-toast-container").length) {
    $("body").append('<div id="scp-toast-container"></div>');
  }

  const toast = $(`
        <div class="scp-toast scp-${type}">
            <div style="display:flex; align-items:center;">
                <i class="${icons[type] || icons.primary}"></i>
                <span>${message}</span>
            </div>
            <span class="scp-toast-close">&times;</span>
        </div>
    `);

  $("#scp-toast-container").append(toast);

  let timeout;

  function startTimer() {
    timeout = setTimeout(() => {
      toast.fadeOut(300, () => toast.remove());
    }, duration);
  }

  function stopTimer() {
    clearTimeout(timeout);
  }

  // Start auto dismiss
  startTimer();

  // Pause on hover
  toast.hover(stopTimer, startTimer);

  // Manual close
  toast.find(".scp-toast-close").on("click", function () {
    toast.fadeOut(300, () => toast.remove());
  });
}
