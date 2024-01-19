<nav class="flex items-center justify-between p-4 md:p-8 text-white">
    <a href="/" class="text-2xl font-bold"><img src="{{ Storage::url("/images/logo.png") }}" alt=""></a>
    <div class="hidden md:block">
        <a href="" class="ml-4">Bugs</a>
        <a href="" class="ml-4">New versions/Features</a>
    </div>
    
    <div class="block md:hidden">
        <button id="menuToggle" class="text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
</nav>

<div id="mobileMenu" class="hidden md:hidden text-white p-4">
    <a href="" class="block mb-2">Bugs</a>
    <a href="" class="block">New versions/Features</a>
</div>

<script>
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
</script>