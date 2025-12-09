let slideIndex = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlides() {
    // Ẩn tất cả các slide
    slides.forEach(slide => {
        slide.classList.remove('active');
    });

    // Tăng chỉ số slide, nếu vượt quá số lượng thì quay về 0
    slideIndex++;
    if (slideIndex > totalSlides) {
        slideIndex = 1; 
    }

    // Hiển thị slide hiện tại (chỉ số mảng bắt đầu từ 0)
    slides[slideIndex - 1].classList.add('active'); 

    // Gọi lại hàm sau một khoảng thời gian (ví dụ: 3000ms = 3 giây)
    setTimeout(showSlides, 3000); 
}

// Bắt đầu chuyển banner sau 100ms (để đảm bảo DOM đã load)
setTimeout(showSlides, 100);
// Swiper initialization
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 4,        // Hiển thị 4 sản phẩm trên desktop
  spaceBetween: 20,        // Khoảng cách giữa các card
  loop: true,              // Cho phép trượt vòng
  grabCursor: true,        // Con trỏ bàn tay
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    576: { slidesPerView: 2 },
    992: { slidesPerView: 3 },
    1200: { slidesPerView: 4 }
  }
});
// ====================== AJAX ADD TO CART ======================
document.addEventListener("DOMContentLoaded", function () {

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll(".add-to-cart").forEach(btn => {
        btn.addEventListener("click", function () {

            let id = this.dataset.id;

            fetch("/cart/add-ajax", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ id: id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {

                    // cập nhật số lượng ở icon giỏ hàng
                    let badge = document.querySelector(".cart-count-badge");
                    if (badge) badge.textContent = data.cartCount;

                    // Cập nhật mini-cart (nếu bạn có)
                    if (document.getElementById("mini-cart")) {
                        document.getElementById("mini-cart").innerHTML = data.miniCart;
                    }

                    alert(data.message);
                }
            })
            .catch(err => console.error("AJAX ERROR:", err));
        });
    });

});
// ====================== UPDATE CART QUANTITY ======================
document.addEventListener("DOMContentLoaded", function () {

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll(".cart-qty").forEach(input => {

        input.addEventListener("change", function () {

            let id = this.dataset.id;
            let newQty = this.value;

            fetch("/cart/update-ajax", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({
                    id: id,
                    quantity: newQty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {

                    // cập nhật subtotal
                    document.querySelector(`#subtotal-${id}`).textContent =
                        data.subtotal + " ₫";

                    // cập nhật tổng
                    document.querySelector("#cart-total").textContent =
                        data.total + " ₫";

                    // cập nhật icon giỏ hàng
                    const badge = document.querySelector(".cart-count-badge");
                    if (badge) badge.textContent = data.cartCount;
                }
            })
            .catch(err => console.error("UPDATE AJAX ERROR:", err));
        });
    });

});
document.addEventListener("DOMContentLoaded", function () {

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Apply coupon
    let applyBtn = document.getElementById("apply-coupon");

    if (applyBtn) {
        applyBtn.addEventListener("click", function () {
            let code = document.getElementById("coupon-code").value;

            fetch("/apply-coupon", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ coupon: code })
            })
            .then(res => res.json())
            .then(data => {

                alert(data.message);

                if (data.success) {
                    document.getElementById("discount-area").style.display = "block";
                    document.getElementById("discount-amount").textContent = data.discount;
                    document.getElementById("final-total").textContent = data.final_total + " ₫";
                }
            })
        });
    }
});

