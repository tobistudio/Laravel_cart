    var productsSwiper = new Swiper(".products-swiper-wrapper .products-swiper", {
        slidesPerView: 4,
        spaceBetween: 24,
        pagination: {
        el: ".products-swiper-wrapper .swiper-pagination",
            clickable: true,
        },

        navigation: {
            nextEl: ".products-swiper-wrapper .swiper-button-next",
            prevEl: ".products-swiper-wrapper .swiper-button-prev",
        },

        breakpoints: {
            0: {
                slidesPerView: 2,
                loop: true,
            },
            
            768: {
                slidesPerView: 3,
            },
            
            1200: {
                slidesPerView: 4,
                loop: false
            },
        },
    });

    var popularBrandsSwiper = new Swiper(".popular-brands-swiper", {
        slidesPerView: 7,
        spaceBetween: 8,
        grid: {
            rows: 3,
            fill: "row",
        },
        pagination: {
        el: ".popular-brands-swiper .swiper-pagination",
            clickable: true,
        },

        navigation: {
            nextEl: ".popular-brands-swiper .swiper-button-next",
            prevEl: ".popular-brands-swiper .swiper-button-prev",
        },

        breakpoints: {
            0: {
                slidesPerView: 3,
            },

            768: {
                slidesPerView: 4,
            },
            
            1300: {
                slidesPerView: 7,
            },
        },
    });

    /* Product carousel fix */

    var section = document.getElementById("popular-products-carousel");

    document.querySelectorAll(".popular-products .product-card").forEach(elem => {
        elem.addEventListener("mouseover", () => {
            section.classList.add("on-hover");
        })

        elem.addEventListener("mouseout", () => {
            section.classList.remove("on-hover");
        })
    });