const FormAjax = document.querySelectorAll(".Formjax");

function sendFormAjax(e){
    e.preventDefault();

    let send = confirm("¿Quieres enviar el formulario?");

    if(send){
        let data = new FormData(this);
        let method = this.getAttribute('method');
        let action = this.getAttribute('action');

        let headers = new Headers();

        let config = {
            method: method,
            headers: headers,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        }
        
        fetch(action,config)
        .then(response => response.text())
        .then(response => {
            let container = document.querySelector('.form-rest');
            container.innerHTML = response;
        })
    }

};

FormAjax.forEach(form => {
    form.addEventListener('submit', sendFormAjax);
});