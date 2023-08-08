const toggleModalVisibility = async (modalId, svgId) => {
  const modal = document.getElementById(modalId);
  const svg = svgId ? document.getElementById(svgId) : null;
  const mobileModal = document.getElementById("modal-mobile");  
  if (svg) {
    svg.classList.toggle("rotate-180", !svg.classList.contains("rotate-180"));
  }
  if (window.innerWidth >= 768) {
    modal.classList.toggle("is-hidden");
  } else {
    mobileModal.classList.add("is-hidden");
    modal.classList.toggle("is-hidden");
  }
};
const toggleModal = async () => {
  await toggleModalVisibility("modal", "rotate");
};
const toggleModalContact = async () => {
  await toggleModalVisibility("modal-contact", "rotate-contact");
};
const toggleMobileModal = async () => {
  const modalMobile = document.getElementById("modal-mobile");
  modalMobile.classList.toggle("is-hidden");
};
const closeModalOnOutsideClick = async (event, modalId, svgId) => {
  const modal = document.getElementById(modalId);
  const svg = document.getElementById(svgId);
  if (event.target === modal) {
    modal.classList.add("is-hidden");
    svg.classList.remove("rotate-180");
  }
};
window.addEventListener("click", (event) => {
  closeModalOnOutsideClick(event, "modal", "rotate");
  closeModalOnOutsideClick(event, "modal-contact", "rotate-contact");
});
const lazyImages = document.querySelectorAll('img[loading="lazy"]');
const onImageIntersection = (entries, observer) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      const lazyImage = entry.target;
      lazyImage.setAttribute("loading", "auto");
      observer.unobserve(lazyImage);
    }
  });
};
const imageObserver = new IntersectionObserver(onImageIntersection);
lazyImages.forEach((lazyImage) => {
  imageObserver.observe(lazyImage);
});