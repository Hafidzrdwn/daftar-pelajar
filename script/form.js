const inputPass = document.querySelector(".passForm");
const showPass = document.querySelector(".showPass");
const hidePass = document.querySelector(".hidePass");

    showPass.addEventListener("click", () => {
      inputPass.type = 'text';
      showPass.style.display = "none";
      hidePass.style.display = "initial";
    });
    hidePass.addEventListener("click", () => {
      inputPass.type = 'password';
      showPass.style.display = "initial";
      hidePass.style.display = "none";
    });