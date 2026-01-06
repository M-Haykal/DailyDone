import axios from 'axios';
import Sortable from 'sortablejs';
import Sortable from 'sortablejs/modular/sortable.complete.esm.js';

window.Sortable = Sortable;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
