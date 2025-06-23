console.log("Heartwarming welcome.");

const errorMsg = document.getElementById('error-msg-wrapper');
errorMsg.querySelectorAll('img')[0].addEventListener('click', () => {
    errorMsg.style.opacity = '0.2';
    errorMsg.style.transform = 'translateY(-120px)';
    setTimeout(() => {
        errorMsg.style.display = 'none'
    }, 500)
})