function validateForm() {
    let status = true;

        document.querySelector('#error-message').classList.add('d-none');
        document.querySelector('#error-message').innerHTML = '';

        const title = document.querySelector('#title').value;
        if (!title.match(/.*[^\s]{5,}.*/)) {
            document.querySelector('#error-message').innerHTML += 'Naslov mora da ima vise od pet vidljivih karaktera!<br>';
            document.querySelector('#error-message').classList.remove('d-none');
            status = false;
        }

        const description = document.querySelector('#description').value;
        if (!description.match(/.*[^\s]{10,}.*/)) {
            document.querySelector('#error-message').innerHTML += 'Opis mora da ima vise od 10 vidljivih karaktera <br>';
            document.querySelector('#error-message').classList.remove('d-none');
            status = false;
        }

        const description = document.querySelector('#description').value;
        if (!description.match(/.*[^\s]{10,}.*/)) {
            document.querySelector('#error-message').innerHTML += 'Opis mora da ima vise od 10 vidljivih karaktera <br>';
            document.querySelector('#error-message').classList.remove('d-none');
            status = false;
        }
        
        return status;
    }