function navigate(event) {
    event.preventDefault();
    const url = event.target.href;
    history.pushState({ url: url }, '', url);
    loadContent(url);
}

function loadContent(url) {
    console.log('Cargando URL:', url);
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la petición: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('content').innerHTML = data.content;
        document.querySelectorAll('.nav-link-client').forEach(link => {
            link.removeEventListener('click', navigate);
            link.addEventListener('click', navigate);
        });
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('content').innerHTML = '<p>Error al cargar: ' + error.message + '</p>';
    });
}

// Solo asignar eventos al cargar, sin cargar contenido inicial
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nav-link-client').forEach(link => {
        link.addEventListener('click', navigate);
    });
});

window.onpopstate = (event) => {
    const url = event.state ? event.state.url : '/';
    loadContent(url);
};