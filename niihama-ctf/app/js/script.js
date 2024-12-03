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

// 通知を表示する関数
function showNotification(message) {
  const notification = document.querySelector('.notification');
  notification.textContent = message;
  notification.classList.add('show');

  //  1 一定時間後に非表示にする
  setTimeout(() => {
    notification.classList.remove('show');
  }, 3000); // 3秒後に非表示
}

// 例: 5秒後に通知を表示
setTimeout(() => {
  showNotification('新しいお知らせがあります！');
}, 5000);