let navbar = document.querySelector('.header .navbar');

document.querySelector('#menu').onclick = () =>{
    navbar.classList.add('active');
};

document.querySelector('#close').onclick = () =>{
    navbar.classList.remove('active');
};

// Mouse image move
document.addEventListener('mousemove', move);

function move(e){
    this.querySelectorAll('.move').forEach(layer => {
        const speed = layer.getAttribute('data-speed');
        const x = (window.innerWidth - e.pageX * speed) / 120;
        const y = (window.innerHeight - e.pageY * speed) / 120;
        layer.style.transform = `translateX(${x}px) translateY(${y}px)`;
    });
}

document.addEventListener("DOMContentLoaded", function() {
    const aboutUsLink = document.querySelector('.btn');
    aboutUsLink.addEventListener('click', function(event) {
        event.preventDefault();
        const aboutUsSection = document.querySelector('.about_us');
        aboutUsSection.scrollIntoView({ behavior: 'smooth' });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const aboutUsLink = document.querySelector('.nav_item[href="#about_us"]');
    aboutUsLink.addEventListener('click', function(event) {
        event.preventDefault();
        const aboutUsSection = document.querySelector('.about_us');
        aboutUsSection.scrollIntoView({ behavior: 'smooth' });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const logoLink = document.querySelector('.logo');
    logoLink.addEventListener('click', function(event) {
        event.preventDefault();
        const homeSection = document.querySelector('#home');
        homeSection.scrollIntoView({ behavior: 'smooth' });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const aimsLink = document.querySelector('.nav_item[href="#aims"]');
    aimsLink.addEventListener('click', function(event) {
        event.preventDefault();
        const aimsSection = document.querySelector('#aims');
        aimsSection.scrollIntoView({ behavior: 'smooth' });
    });
});

gsap.from('.navbar .nav_item', {opacity: 1, duration: 1, delay: 1, y:30, stagger: 0.2})

gsap.from('.title', {opacity: 1, duration: 1, delay: 1.6, y:30})
gsap.from('.btn', {opacity: 1, duration: 1, delay: 1.8, y:30})
gsap.from('.description', {opacity: 1, duration: 1, delay: 2.1, y:30})
gsap.from('.image', {opacity: 1, duration: 1, delay: 2.6, y:30})

