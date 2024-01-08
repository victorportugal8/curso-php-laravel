const { default: axios } = require('axios');

window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

//interceptar os requests da aplicação
axios.interceptors.request.use( //Espera 2 métodos de callback; 1º método: define as configurações da requisição, antes que a requisição seja feita; 2º método: recupera por parâmetro o erro - caso aconteça
    config =>{
        //definir para todas as requisições os parâmetros de Accept e Authorization
        config.headers['Accept'] = 'application/json'

        //recuperando o token de autorização dos cookies
        let token = document.cookie.split(';').find(indice =>{
            return indice.includes('token=')
        })
        token = token.split('=')[1]
        token = 'Bearer ' + token

        config.headers.Authorization = token

        return config
    },
    error =>{
        return Promise.reject(error)
    }
)

//interceptar os responses da aplicação
axios.interceptors.response.use( //1º método: trata a resposta recebida da requisição; 2º método: trata os erros - caso aconteça algum
    response =>{
        return response
    },
    error =>{
        if(error.response.status == 401 && error.response.data.message == 'Token has expired'){
            console.log('Fazer uma nova requisição para a rota refresh')
            axios.post('http://localhost:8000/api/refresh')
                .then(response =>{
                    document.cookie = 'token='+response.data.token
                    window.location.reload()
                })
        }
        return Promise.reject(error)
    }
)