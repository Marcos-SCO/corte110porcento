document.addEventListener('scroll', () => {

  (window.pageYOffset >= 300)
    ? window.addEventListener('scroll', document.getElementById('NavHeader').classList.add('fixed-top'))
    
    : window.addEventListener('scroll', document.getElementById('NavHeader').classList.remove('fixed-top'));
});