"use strict"

// Get Device width
let deviceWidth = window.innerWidth;

// 07. Header 3
let header = document.querySelector(".header");
if (header) {
    window.onscroll = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    };
}

// Gsap Animation Initials

// Header Section
TweenMax.from(".nav-logo", 1, {
    opacity: 0,
    x: -20,
    ease: Expo.easeInOut
})
// TweenMax.staggerFrom(".banner-btn", 1, {
//     opacity: 0,
//     x: -20,
//     ease: Power3.easeInOut
// }, 0.08)

// Banner Section
let tl = gsap.timeline();
tl.from(".banner-left > h1", { x: -100, duration: 1, opacity: 0 })
tl.from(".banner-left > p", { x: -50, duration: 0.5, opacity: 0 })
tl.staggerFrom(".banner-btn", 1, { duration: 1, x: -50, autoAlpha: 0, stagger: 0.05 }, "-=1")

TweenMax.from(".customer-slider", 1, {
    opacity: 0,
    y: -30,
    duration: 1,
    ease: Expo.easeInOut
}, 0.08)


let bannerImg = document.querySelector(".banner_img")
gsap.set(bannerImg, {
    opacity: 0,
    y: 50
})
tl.to(bannerImg, 1, { opacity: 1, y: 0, duration: 1.2, ease: "power2.out" }, "-=1");


// Section Title
let splitTitle = gsap.utils.toArray(".title-anim");

splitTitle.forEach(splitTitle => {
    const tl = gsap.timeline({
        scrollTrigger: {
            trigger: splitTitle,
            start: 'top 100%',
            end: 'bottom 60%',

            scrub: false,
            markers: false,
            toggleActions: 'play none resume  none'
        }
    });

    const itemSplitted = new SplitText(splitTitle, { type: "words, lines" });
    gsap.set(splitTitle, { perspective: 400 });
    itemSplitted.split({ type: "lines" })
    tl.from(itemSplitted.lines, { duration: 1, delay: 0.3, opacity: 0, rotationX: -80, force3D: true, transformOrigin: "top center -50", stagger: 0.1 });
});

// About US
gsap.set(".fade-bottom", { y: 30, opacity: 0 });
if (deviceWidth < 1023) {
    const fadeArray = gsap.utils.toArray(".fade-bottom")
    fadeArray.forEach((item, i) => {
        let fadeTl = gsap.timeline({
            scrollTrigger: {
                trigger: item,
                start: "top center+=200",
            }
        })
        fadeTl.to(item, {
            y: 0,
            opacity: 1,
            ease: "power2.out",
            duration: 1.5,
        })
    })
}
else {
    gsap.to(".fade-bottom", {
        scrollTrigger: {
            trigger: ".fade-bottom",
            start: "top center+=300",
            markers: false
        },
        y: 0,
        opacity: 1,
        ease: "power2.out",
        duration: 1,
        stagger: {
            each: 0.2
        }
    })
}


// Features
let featureItem = gsap.utils.toArray(".feature-items .feature-item")
gsap.set(featureItem, {
    opacity: 0,
    x: -30,
})

if (featureItem) {
    if (deviceWidth < 1023) {
        featureItem.forEach((item, i) => {
            gsap.to(item, {
                scrollTrigger: {
                    trigger: item,
                    start: "top center+=200",
                    markers: false
                },
                opacity: 1,
                x: -0,
                ease: "power2.out",
                duration: 1,
                stagger: {
                    each: 0.4
                }
            })
        })
    }
    else {
        gsap.to(".feature-item", {
            scrollTrigger: {
                trigger: ".feature-item",
                start: "top center+=200",
                markers: false
            },
            opacity: 1,
            x: 0,
            ease: "power2.out",
            duration: 1,
            stagger: {
                each: 0.4
            }
        })
    }
}

// Choose Us
gsap.set(".model-img", { opacity: 0, scale: 0.5 });
gsap.to(".model-img", {
    scrollTrigger: {
        trigger: ".model-img > img",
        start: "top center+=100",
        markers: false
    },
    opacity: 1,
    scale: 1,
    x: 20,
    ease: "power2.out",
    duration: 1.5,
})


// Faqs Items
// gsap.set(".accordion-item", { y: 100 });
// ScrollTrigger.batch(".accordion-item", {
//     interval: 0.1,
//     batchMax: 2,
//     onEnter: batch => gsap.to(batch, { opacity: 1, y: 0, overwrite: true }),
//     start: "50px bottom",
//     end: "top top"
// });
// ScrollTrigger.addEventListener("refreshInit", () => gsap.set(".accordion-item", { y: 0 }));



// Customer Slider With Slick
$('.customer-slider').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 400,
    responsive: [
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 4,
            }
        },
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 3,
            }
        },
    ]
});



// Active menu dynamiclly
const sections = document.querySelectorAll("section[id]");
window.addEventListener("scroll", navHighlighter);

function navHighlighter() {
    let scrollY = window.pageYOffset;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 80;
        const sectionId = current.getAttribute("id");

        if (
            scrollY > sectionTop &&
            scrollY <= sectionTop + sectionHeight
        ) {
            document.querySelector(".nav-menu-item a[href*=" + sectionId + "]").classList.add("menu-item-active");
        } else {
            document.querySelector(".nav-menu-item a[href*=" + sectionId + "]").classList.remove("menu-item-active");
        }
    });
}


// mobile menu side bar
const menuBtn = document.querySelector(".bars")
const mainNav = document.querySelector(".main-nav");

if (mainNav != null) {
    const navMenu = mainNav.querySelector(".nav-menu-wrap");
    const closeSidebar = mainNav.querySelector(".close-sidebar");
    const overlay = mainNav.querySelector(".main-nav-overlay");

    menuBtn.addEventListener("click", () => {
        navMenu.classList.add("show-menu-wrap")
        mainNav.classList.add("show-main-nav")
        overlay.style.display = "block"
        if (mainNav.classList.contains("show-main-nav")) {
            overlay.addEventListener("click", () => {
                navMenu.classList.remove("show-menu-wrap")
                mainNav.classList.remove("show-main-nav")
                overlay.style.display = "none"
            })
            closeSidebar.addEventListener("click", () => {
                navMenu.classList.remove("show-menu-wrap")
                mainNav.classList.remove("show-main-nav")
                overlay.style.display = "none"
            })
        }
    })
}
