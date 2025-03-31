import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: process.env.MIX_REVERB_APP_KEY,
    wsHost: process.env.MIX_REVERB_HOST,
    wsPort: process.enc.MIX_REVERB_PORT,
    wssPort: process.env.MIX_REVERB_PORT,
    forceTLS: (process.env.MIX_REVERB_SCHEME === 'https'),
    enabledTransports: ['ws', 'wss']
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';