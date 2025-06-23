const options = document.getElementsByClassName('option');

for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const link = option.getAttribute('data-link');
    option.addEventListener('click', () => {
        window.location = link;
    })
}