<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Drive & Loc</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Space Grotesk', sans-serif;
        }

        .car-gradient {
            background: linear-gradient(90deg, #FF0000 0%, #000000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hover-grow {
            transition: transform 0.3s ease;
        }

        .hover-grow:hover {
            transform: scale(1.02) translateY(-5px);
        }

        .tag-filter.active {
            background-color: #dc2626; /* Red background for active tag */
            color: white;
        }
    </style>
</head>
<body class="bg-black text-white overflow-x-hidden">
    <nav class="bg-black fixed w-full z-50 top-0">
        <div class="mx-8 md:mx-16 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-12 bg-red-600"></div>
                    <a href="/" class="text-2xl font-bold tracking-wider">Drive & Loc</a>
                </div>

            </div>
        </div>
    </nav>

    <section class="py-32 mx-8 md:mx-16">
        <h1 class="text-4xl font-bold mb-8">Explore Our Blog</h1>

        <!-- Blog Category/Theme Navigation -->
        <div class="mb-8">
            <ul class="flex space-x-4">
                <li><a href="/blog" class="hover:text-red-500 transition-colors">All</a></li>
                <!-- Loop through blog categories here -->
                <li><a href="/blog?category=1" class="hover:text-red-500 transition-colors">Theme 1</a></li>
                <li><a href="/blog?category=2" class="hover:text-red-500 transition-colors">Theme 2</a></li>
            </ul>
        </div>

        <!-- Tag Filtering -->
        <div class="mb-8">
            <ul class="flex flex-wrap gap-2" id="tagFilters">
                <li><button class="bg-gray-800 text-gray-400 px-3 py-1 rounded-full text-sm hover:bg-gray-700 transition-colors tag-filter" data-tag="all">All Tags</button></li>
                <li><button class="bg-gray-800 text-gray-400 px-3 py-1 rounded-full text-sm hover:bg-gray-700 transition-colors tag-filter" data-tag="travel">Travel</button></li>
                <li><button class="bg-gray-800 text-gray-400 px-3 py-1 rounded-full text-sm hover:bg-gray-700 transition-colors tag-filter" data-tag="cars">Cars</button></li>
                <li><button class="bg-gray-800 text-gray-400 px-3 py-1 rounded-full text-sm hover:bg-gray-700 transition-colors tag-filter" data-tag="roadtrip">Road Trip</button></li>
                <!-- More tags will be added here dynamically using JavaScript -->
            </ul>
        </div>

        <!-- Search Bar -->
        <div class="mb-8">
            <form action="/blog" method="GET">
                <input type="text" name="search" placeholder="Search articles..." class="bg-gray-800 text-white px-4 py-2 rounded w-full md:w-1/2">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-2 md:mt-0">Search</button>
            </form>
        </div>

        <!-- Blog Post Listings -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="blogPosts">
            <!-- Loop through blog posts here -->
            <div class="bg-gray-900 p-4 rounded-lg hover-grow" data-tags="travel,cars">
                <h2 class="text-xl font-bold mb-2"><a href="/blog/post/1" class="hover:text-red-500 transition-colors">Post Title 1: Exploring Scenic Routes</a></h2>
                <p class="text-gray-400 mb-4">Discover breathtaking landscapes and hidden gems on your next road trip adventure.</p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">By John Doe | 2023-10-27</span>
                    <div class="flex space-x-2">
                        <span class="bg-gray-800 text-gray-400 px-2 py-1 rounded-full text-xs">Travel</span>
                        <span class="bg-gray-800 text-gray-400 px-2 py-1 rounded-full text-xs">Cars</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 p-4 rounded-lg hover-grow" data-tags="cars,maintenance">
                <h2 class="text-xl font-bold mb-2"><a href="/blog/post/2" class="hover:text-red-500 transition-colors">Post Title 2: Essential Car Maintenance Tips</a></h2>
                <p class="text-gray-400 mb-4">Keep your vehicle in top condition with these easy-to-follow maintenance tips.</p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">By Jane Smith | 2023-10-26</span>
                    <div class="flex space-x-2">
                        <span class="bg-gray-800 text-gray-400 px-2 py-1 rounded-full text-xs">Cars</span>
                        <span class="bg-gray-800 text-gray-400 px-2 py-1 rounded-full text-xs">Maintenance</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 p-4 rounded-lg hover-grow" data-tags="travel,roadtrip">
                <h2 class="text-xl font-bold mb-2"><a href="/blog/post/3" class="hover:text-red-500 transition-colors">Post Title 3: Planning the Perfect Road Trip</a></h2>
                <p class="text-gray-400 mb-4">From choosing your destination to packing essentials, make your next road trip unforgettable.</p>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">By Peter Jones | 2023-10-25</span>
                    <div class="flex space-x-2">
                        <span class="bg-gray-800 text-gray-400 px-2 py-1 rounded-full text-xs">Travel</span>
                        <span class="bg-gray-800 text-gray-400 px-2 py-1 rounded-full text-xs">Road Trip</span>
                    </div>
                </div>
            </div>
             <!-- More blog post listings -->
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            <button class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Previous</button>
            <span class="text-gray-400">Page 1 of N</span>
            <button class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">Next</button>
        </div>
    </section>

    <footer class="bg-gray-900 py-12">
        <div class="mx-8 md:mx-16 text-center text-gray-400">
            © <?php echo date("Y"); ?> Drive & Loc. All rights reserved.
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const blogPostsContainer = document.getElementById('blogPosts');
            const blogPosts = Array.from(blogPostsContainer.children);
            const tagFiltersContainer = document.getElementById('tagFilters');
            const tagFilters = Array.from(tagFiltersContainer.querySelectorAll('.tag-filter'));

            let activeTags = new Set();

            function filterPosts() {
                blogPosts.forEach(post => {
                    const postTags = post.dataset.tags ? post.dataset.tags.split(',') : [];
                    const shouldShow = activeTags.size === 0 || [...activeTags].every(tag => postTags.includes(tag));
                    post.style.display = shouldShow ? 'block' : 'none';
                });
            }

            tagFilters.forEach(filter => {
                filter.addEventListener('click', function() {
                    const tag = this.dataset.tag;

                    if (tag === 'all') {
                        activeTags.clear();
                    } else {
                        if (activeTags.has(tag)) {
                            activeTags.delete(tag);
                        } else {
                            activeTags.add(tag);
                        }
                    }

                    // Update active class for tag filters
                    tagFilters.forEach(f => {
                        if (f.dataset.tag === 'all') {
                            f.classList.toggle('active', activeTags.size === 0);
                        } else {
                            f.classList.toggle('active', activeTags.has(f.dataset.tag));
                        }
                    });

                    filterPosts();
                });
            });

            // Initialize "All Tags" as active
            const allTagsFilter = tagFiltersContainer.querySelector('[data-tag="all"]');
            if (allTagsFilter) {
                allTagsFilter.classList.add('active');
            }
        });
    </script>
</body>
</html>