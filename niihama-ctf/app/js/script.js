const loginModal = document.getElementById("loginModal");
const signupModal = document.getElementById("signupModal");
const loginBtn = document.getElementById("loginBtn");
const signupBtn = document.getElementById("signupBtn");

// モーダルを開く
loginBtn.onclick = function () {
  loginModal.style.display = "block";
};
signupBtn.onclick = function () {
  signupModal.style.display = "block";
};

// モーダルを閉じる (Xボタンと外側クリック)
const closeButtons = document.querySelectorAll(".close"); // All close buttons

closeButtons.forEach((closeButton) => {
  closeButton.onclick = function () {
    // Find the parent modal and close it:
    closeButton.closest(".modal").style.display = "none";
  };
});

window.onclick = function (event) {
  if (event.target == loginModal) {
    loginModal.style.display = "none";
  }
  if (event.target == signupModal) {
    signupModal.style.display = "none";
  }
};
