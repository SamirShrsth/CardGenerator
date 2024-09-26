function toggleTemplates() {
  const hiddenTemplates = document.querySelectorAll(".template-item.hidden");
  const viewMoreButton = document.querySelector(".view-more");

  // Check if any hidden templates are currently visible
  if (
    hiddenTemplates.length > 0 &&
    hiddenTemplates[0].classList.contains("hidden")
  ) {
    // Show all hidden templates
    hiddenTemplates.forEach((template) => {
      template.classList.remove("hidden"); // Start showing them
      setTimeout(() => {
        template.style.opacity = "1"; // Fade in
      }, 10); // Delay to allow the transition to start
    });
    viewMoreButton.textContent = "View Less";
  } else {
    // Hide the additional templates
    const allTemplates = document.querySelectorAll(".template-item");
    allTemplates.forEach((template, index) => {
      if (index >= 4) {
        // Assuming the first 4 are always visible
        template.style.opacity = "0"; // Fade out
        setTimeout(() => {
          template.classList.add("hidden"); // Hide after fade
        }, 500); // Match the CSS transition duration
      }
    });
    viewMoreButton.textContent = "View More";
  }
}
