<template>
    <div class="container mx-auto">
        <div class="mx-auto max-w-screen-lg px-3 py-6">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col items-center gap-x-8 rounded-md bg-slate-800 p-3 md:flex-row md:flex-wrap">
                    <div class="w-full flex flex-col flex-wrap items-center gap-y-2 md:flex-row  md:justify-between">
                        <p class="text-xl font-semibold">{{ movie.title }} / {{ movie.reviews_count }} Reviews <span v-if="averageRating>0">/ {{averageRating}} Star</span></p>
                        <p class="mt-3 text-gray-400 w-full">{{ movie.tagline }}</p>
                    </div>
                    <div class="w-full mt-4 mb-4">
                        {{ movie.overview }}
                    </div>
                    
                    <div class="hover:text-cyan-400 text-xl font-semibold border-b border-cyan-400 pb-2 mb-4">
                        Reviews
                    </div>
                    <div class="p-3 w-full mt-4 bg-slate-700" v-for="review in movie.reviews">
                        <div v-if="review.rating == 1">*</div>
                        <div v-if="review.rating == 2">* *</div>
                        <div v-if="review.rating == 3">* * *</div>
                        <div v-if="review.rating == 4">* * * *</div>
                        <div v-if="review.rating == 5">* * * * *</div>
                        <div class="text-gray-200">
                            {{ review.review }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-6 mt-5">
                <p class="bg-red-100 border border-red-400 text-red-700" v-if="errors.length">
                    <b>Error(s):</b>
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </p>
                <p class="bg-green-100 border border-green-400 text-green-700" v-if="successMessage.length">
                    <b class="p-2">{{successMessage}}</b>
                </p>
                <label class="block" for="review">
                    <span>Review</span>
                    <textarea v-model="review" required id="review" name="review" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black" rows="3" spellcheck="true"></textarea>
                </label>
                <label class="block" for="rating">
                    <span>Rating</span>
                    <select v-model="rating" name="rating" id="rating" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black">
                        <option value="1">1 star</option>
                        <option value="2">2 star</option>
                        <option value="3" selected>3 star</option>
                        <option value="4">4 star</option>
                        <option value="5">5 star</option>
                    </select>
                </label>
                <button @click="submit" type="button" class="ml-auto mr-2 shrink-0 rounded-full bg-gradient-to-br from-sky-500 to-cyan-400 px-3 py-1 text-sm font-medium hover:from-sky-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/50">Add Review</button>
            </div>
        </div>
    </div>

    
</template>


<script setup>

import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const movie = ref({});
let review = ref('');
let errors = ref([]);
let rating = ref(3);
let successMessage = ref('');
let averageRating = ref(0);

onMounted(() => {
    const id = route.params.id;
    getMovie(route.params.id);
})

const getMovie = async (movieId) => {
    const { data } = await axios.get(`/api/movies/${movieId}`);
    movie.value = data.movie;
    calculateAverageRating();
}

const submit = async() => {
    // data validation
    successMessage.value = '';
    errors.value = [];
    let hasErrors = false;
    if (!review.value) {
        errors.value.push('Review required.');
        hasErrors = true;
    }
    if (!rating.value) {
        errors.value.push('Rating required.');
        hasErrors = true;
    }

    if (!hasErrors) {
        errors.value = []; // reset validation errors

        let movieId = route.params.id;
        const response = await axios.post(`/api/reviews/${movieId}`, {
            review: review.value,
            rating: rating.value
        });

        if (response.data == true) {
            movie.value.reviews_count += 1;
            movie.value.reviews.push({review: review.value, rating: rating.value});
            calculateAverageRating();
            successMessage.value = 'Your review has been submitted successfully.';
        } else {
            errors.value.push('A server error has occurred. Please try again later.');
        }

        // reset to default values
        review.value = '';
        rating.value = 3;
    }
}

const calculateAverageRating = () => {
    const totalRatings = movie.value.reviews.reduce((acc, { rating }) => acc += Number(rating), 0)
    averageRating = (totalRatings / movie.value.reviews_count).toFixed(2);
}
</script>