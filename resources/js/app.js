// app.js
import './bootstrap';

import {createApp} from 'vue'

import router from './router';

import App from './App.vue'

var mixin = {
    methods: {
        averageRating: function(movie) {
            if (movie.reviews_count > 0) {
                const totalRatings = movie.reviews.reduce((acc, { rating }) => acc += Number(rating), 0)
                return (totalRatings / movie.reviews_count).toFixed(2) + ' Star';
            } else {
                return 'No rating yet';
            }
        }
    }
}

createApp(App)
    .mixin(mixin)
    .use(router)
    .mount("#app")