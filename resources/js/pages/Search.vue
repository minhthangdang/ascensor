<template>
    <div class="container mx-auto">
        <form class="rounded-md bg-slate-800 px-4 py-2 focus-within:ring-2 focus-within:ring-cyan-600 hover:ring-2 hover:ring-cyan-600" @submit.prevent="sendSearch(1)">
            <input class="w-full appearance-none bg-slate-800 focus:outline-none" type="text" v-model="searchTerm">
            <input type="submit" hidden />
            <button class="mt-2 ml-2 shrink-0 rounded-full bg-gradient-to-br from-sky-500 to-cyan-400 px-3 py-1 text-sm font-medium hover:from-sky-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/50" type="submit">Search</button>
        </form>
        <div class="text-2xl text-white text-center pt-8 px-8 pb-4" v-if="searchResults.length">
            Search term: {{ searchTerm }}
            <div class="text-lg text-white text-center p-3">
                Search results: {{ total }}
            </div>
        </div>
        <div v-if="totalPages > 0" class="w-full flex flex-col gap-6 mt-8">
            <nav class="flex justify-center" aria-label="Search results pagination">
                <ul class="inline-flex -space-x-px">
                    <li v-for="pageNumber in totalPages" :key="pageNumber">
                        <a @click="sendSearch(pageNumber)" href="#" class="px-3 py-2 leading-tight bg-white border hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            :class="[pageNumber != currentPage ? 'text-gray-500 bg-gray-100' : 'text-blue-600 bg-blue-100']">
                            {{pageNumber}}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="w-full flex flex-col gap-6 mt-8">
            <div class="flex flex-col items-center gap-x-8 rounded-md bg-slate-800 p-3 md:flex-row md:flex-wrap" v-for="result in searchResults" :key="result.id">
                <div class="w-full flex flex-col items-center gap-y-2 md:flex-row  md:justify-between">
                    <router-link class="hover:text-cyan-400" :to="{name: 'Movie', params: {id: result.id}}">
                        <div class="text-xl font-semibold">{{ result.title }}</div>
                    </router-link>
                    <div class="ml-auto">
                        <a href="" class="text-xl font-semibold">{{ result.reviews_count }} Reviews / {{ averageRating(result) }}</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script setup>

import { ref } from 'vue';

const searchTerm = ref('');
const searchResults = ref([]);
const currentPage = ref(1);
const totalPages = ref(0);
const total = ref(0);

const sendSearch = async (page) => {
    currentPage.value = page;
    const { data } = await axios.post('/api/movies/search?page=' + currentPage.value, { 
        searchParam: searchTerm.value
    });
    searchResults.value = data.data;
    totalPages.value = data.last_page;
    total.value = data.total;
}

</script>