document.querySelectorAll('#close-popup')[0].addEventListener('click', () => {
    disappear();
});

setTimeout(disappear, 3000)

function disappear() {
    const popup = document.querySelectorAll('#error-popup')[0];
    popup.style.transform = 'translateY(-80px)';
    setTimeout(() => {
        popup.style.opacity = '0';
    }, 100)
}