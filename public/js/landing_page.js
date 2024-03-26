let navbar = document.querySelector('.header .navbar');
document.querySelector('#Menu').onclick = () => {
    navbar.classList.add('active');
};
document.querySelector('#Close').onclick = () => {
    navbar.classList.remove('active');
};
document.addEventListener('mousemove', move);
function move(e) {
    this.querySelectorAll('.move').forEach(layer => {
        const speed = layer.getAttribute('data-speed');
        const x = (window.innerWidth - e.pageX * speed) / 120;
        const y = (window.innerHeight - e.pageY * speed) / 120;
        layer.style.transform = `translateX(${x}px) translateY(${y}px)`;
    });
}
document.addEventListener("DOMContentLoaded", function() {
    const homeLink = document.querySelector('.logo[href="#Home"]');
    homeLink.addEventListener('click', function(event) {
        event.preventDefault();
        const homeSection = document.querySelector('.home');
        homeSection.scrollIntoView({
            behavior: 'smooth'
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const aboutUsLink = document.querySelector('.nav_item[href="#AboutUs"]');
    aboutUsLink.addEventListener('click', function(event) {
        event.preventDefault();
        const aboutUsSection = document.querySelector('.about_us');
        aboutUsSection.scrollIntoView({
            behavior: 'smooth'
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const aimsLink = document.querySelector('.nav_item[href="#Aims"]');
    aimsLink.addEventListener('click', function(event) {
        event.preventDefault();
        const aimsSection = document.querySelector('.aims');
        aimsSection.scrollIntoView({
            behavior: 'smooth'
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const aboutUsLink = document.querySelector('.btn[href="#AboutUs"]');
    aboutUsLink.addEventListener('click', function(event) {
        event.preventDefault();
        const aboutUsSection = document.querySelector('.about_us');
        aboutUsSection.scrollIntoView({
            behavior: 'smooth'
        });
    });
});