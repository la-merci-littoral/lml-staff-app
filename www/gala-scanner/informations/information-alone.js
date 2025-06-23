console.log("-- Alone --")

document.getElementById('form-payment').addEventListener('submit', (event) => {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const formObject = Object.fromEntries(formData.entries());
    const totalPrice = formObject.totalPrice;
    const id = document.querySelectorAll('.code-display')[0].getAttribute('data-totalId');

    const hasPaid = document.getElementById('confirm-payment').getAttribute('data-hasPaid');

    if (hasPaid == 1) {
        const fname = document.getElementById('fname').innerText;
        const errorMsg = `${fname} a déjà payé.`;
        const parent = document.getElementById('error-message-wrapper')
        createErrorMessage(errorMsg, parent);
        return;
    }

    fetch(`./handleConfirmDBChange.php?id=${id}`)
        .then(res => res.json())
        .then(data => console.log(data))
        .then(() => window.location = `./informations.php?id=${id}`)
})



function updateConfirmButtons() {
    const submitButton = document.getElementById('confirm-payment');
    const hasPaid = submitButton.getAttribute('data-hasPaid');
    if (hasPaid == 1) {
        submitButton.style.backgroundImage = 'url(../../img/confirmed-icon.png)';
    }
}

async function closeErrorMessage() {
    const msgWrapper = document.getElementById('error-message-wrapper');
    const msg = msgWrapper.getElementsByClassName('error-message')[0];
    msg.style.transition = "400ms ease-in";
    msg.style.transform = "translateY(-100px)";
    msg.style.opacity = "0.2";
    await sleep(400);
    msgWrapper.innerHTML = '';
}

function createErrorMessage(errorText, parentElem) {
    parentElem.innerHTML = '';

    console.log(errorText, parentElem)
    const newMsg = document.createElement('div');
    newMsg.classList.add('error-message');
    const html = `
        <h2>Erreur :</h2>
        <p>${errorText}</p>
        <img src="../../img/close-icon.png" onclick="closeErrorMessage()">
    `;
    newMsg.innerHTML = html;
    parentElem.appendChild(newMsg);
    parentElem.style.display = 'flex';
}

updateConfirmButtons();