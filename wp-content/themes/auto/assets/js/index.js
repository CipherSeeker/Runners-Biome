const toggleModal = () => {
  const modal = document.getElementById("modal");
  const svg = document.getElementById("rotate");
  const mobileModal = document.getElementById("modal-mobile");

  if (!svg.classList.contains("rotate-180")) {
    svg.classList.add("rotate-180", "transition-all");
  } else {
    svg.classList.remove("rotate-180");
  }

  if (window.innerWidth >= 768) {
    modal.classList.toggle("is-hidden");
  } else {
    mobileModal.classList.add("is-hidden");
    modal.classList.toggle("is-hidden");
  }
};

const toggleModalContact = () => {
  const modalContact = document.getElementById("modal-contact");
  const svg = document.getElementById("rotate-contact");
  const mobileModal = document.getElementById("modal-mobile");

  if (!svg.classList.contains("rotate-180")) {
    svg.classList.add("rotate-180", "transition-all");
  } else {
    svg.classList.remove("rotate-180");
  }

  if (window.innerWidth >= 768) {
    modalContact.classList.toggle("is-hidden");
  } else {
    mobileModal.classList.add("is-hidden");
    modalContact.classList.toggle("is-hidden");
  }
};

const toggleMobileModal = () => {
  const modalMobile = document.getElementById("modal-mobile");
  modalMobile.classList.toggle("is-hidden");
};

const contactModalClickHandler = (event) => {
  const modalContact = document.getElementById("modal-contact");
  const svg = document.getElementById("rotate-contact");

  if (event.target === modalContact) {
    modalContact.classList.add("is-hidden");
    svg.classList.remove("rotate-180");
  }
};

window.addEventListener("click", contactModalClickHandler);
