<template>
    <div class="container mx-auto">
        <div class="mx-auto max-w-screen-lg px-3 py-6">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col items-center gap-x-8 rounded-md bg-slate-800 p-3 md:flex-row md:flex-wrap">
                    <div class="w-full flex flex-col flex-wrap items-center gap-y-2 md:flex-row  md:justify-between">
                        <p class="text-xl font-semibold">{{ movie.title }} / {{ movie.reviews_count }} Reviews</p>
                        <p class="mt-3 text-gray-400 w-full">{{ movie.tagline }}</p>
                    </div>
                    <div class="w-full mt-4 mb-4">
                        {{ movie.overview }}
                    </div>
                    
                    <div class="hover:text-cyan-400 text-xl font-semibold border-b border-cyan-400 pb-2 mb-4">
                        Reviews
                    </div>
                    <div class="p-3 w-full mt-4 bg-slate-700" v-for="review in movie.reviews">
                        <div class="text-gray-200">
                            {{ review.review }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-6 mt-5">
                <label class="block" for="review">
                    <span>Review</span>
                    <textarea required id="review" name="review" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black" rows="3" spellcheck="true"></textarea>
                </label>
                <label class="block" for="rating">
                    <span>Rating</span>
                    <select name="rating" id="rating" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-black">
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

onMounted(() => {
    const id = route.params.id;
    getMovie(route.params.id);
})

const getMovie = async (movieId) => {
    const { data } = await axios.get(`/api/movies/${movieId}`);
    movie.value = data.movie
}

// Handle the submit button to send review and rating
const submit = async () => {
    let review = document.getElementById('review').value;
    let rating = document.getElementById('rating').value;
    //TODO: validation required here
    let movieId = route.params.id;

    const isSuccess = await axios.post(`/api/reviews/${movieId}`, {
        review: review,
        rating: rating
    });
}

</script>