import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

let page = 0;
let loading = false;
let lastPage = false;

const blogs = document.getElementById("blogs");
const gameFilter = document.getElementById('gameFilter');

const loadMore = async () => {
    if (!blogs) {
        return;
    }

    if (loading) {
        return;
    }

    loading = true;
    page++;

    if (lastPage && page > lastPage) {
        return;
    }

    console.log(`load page ${page}`);

    let link;

    if (blogs && blogs.getAttribute("data-form")) {
        link = `api/posts?page=${page}&search=${blogs.getAttribute("data-form")}`;
    } else {
        link = `api/posts?page=${page}`;
    }

    const response = await fetch(link);
    const data = await response.json();
    console.log(data);

    lastPage = data.last_page;

    data.data.forEach((post) => {
        const postElement = document.createElement("div");
        postElement.classList.add('blog-post', 'border', 'border-r', 'overflow-hidden', 'hover:shadow-lg');
        postElement.setAttribute('data-game-id', post.game.id);
        postElement.innerHTML = `
        <div class="max-w-full mx-auto overflow-hidden shadow-md p-4 mb-4 flex flex-col md:flex-row">
    <a href="/post/${post.id}" data-game-id="${post.game.id}" class="flex-shrink-0 mb-4 md:mb-0 md:mr-4">
        <img class="w-full h-40 object-cover rounded" src="/storage/${post.image}" alt="${post.title}">
    </a>
    <div class="flex-grow">
        <h1 class="text-xl font-semibold mb-2">
            <a href="/post/${post.id}" class="text-blue-500 hover:underline">${post.title}</a>
        </h1>
        <p class="text-gray-600 dark:text-gray-400">${post.description}</p>
        <div class="flex items-center mt-2">
            <a href="/user/${post.user.id}" class="flex items-center gap-2 hover:text-blue-500">
                <img class="rounded-full w-8 h-8" src="/storage/${post.user.profile_image}" alt="">
                <p>${post.user.firstname} ${post.user.lastname}</p>
            </a>
        </div>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Game: ${post.game.title}</p>
        <p class="text-gray-600 dark:text-gray-400">Category: ${post.category?.title ?? ''}</p>
    </div>
</div>


    `;

        blogs.appendChild(postElement);
    });

    loading = false;
    filterPosts();
};

window.addEventListener("DOMContentLoaded", () => {
    loadMore();
});

window.addEventListener("scroll", () => {
    const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
    if (scrollTop + clientHeight >= scrollHeight - 5 && !loading) {
        loadMore();
    }
});
