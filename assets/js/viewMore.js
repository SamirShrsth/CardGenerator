function toggleTemplates() {
  const hiddenTemplates = document.querySelectorAll(".template-item.hidden");
  const viewMoreButton = document.querySelector(".view-more");


  if (
    hiddenTemplates.length > 0 &&
    hiddenTemplates[0].classList.contains("hidden")
  ) {
    // Show all hidden templates
    hiddenTemplates.forEach((template) => {
      template.classList.remove("hidden");
      setTimeout(() => {
        template.style.opacity = "1";
      }, 10);
    });
    viewMoreButton.textContent = "View Less";
  } else {
    const allTemplates = document.querySelectorAll(".template-item");
    allTemplates.forEach((template, index) => {
      if (index >= 4) {
        template.style.opacity = "0";
        setTimeout(() => {
          template.classList.add("hidden");
        }, 500);
      }
    });
    viewMoreButton.textContent = "View More";
  }
}
