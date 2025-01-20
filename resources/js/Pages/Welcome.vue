<template>
    <div class="min-h-screen bg-gray-100 dark:bg-stone-900 relative">
        <button @click="toggleTheme"
                type="button" 
                class="fixed top-4 right-4 p-3 rounded-full bg-gray-200 dark:bg-stone-800 hover:bg-gray-300 dark:hover:bg-stone-700 transition-colors z-50">
                <i class="fas fa-sun text-yellow-500 dark:hidden text-xl"></i>
            <i class="fas fa-moon text-gray-300 hidden dark:block text-xl"></i>
        </button>

        <div class="flex items-center justify-center flex-grid relative pt-28">
            <img src="/img/IMG_2233.png" alt="Janis" class="position-left max-w-md rounded-lg shadow-lg" loading="lazy">
            <div class="p-24">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white p-2">Hi, I'm</h2>
                <h1 class="dark:text-white font-bold font-Jura text-6xl text-gray-900">Janis Strazdins</h1>
                <h3 class="dark:text-white font-bold font-Jura text-3xl py-6 px-3">Web developer</h3>
                <h3 class="dark:text-white font-bold font-Jura text-3xl py-6 px-3">Building things for web</h3>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-32 mb-32">
            <h1 class="dark:text-white font-bold font-Jura text-5xl text-center mb-16">Brightest works</h1>
            
            <div class="grid grid-cols-3 gap-8 mb-16">
                <div v-for="project in projects" 
                     :key="project.id" 
                     class="cursor-pointer">
                    <div class="text-center">
                        <h2 @click="toggleProject(project.id)"
                            class="dark:text-white text-gray-800 font-Jura text-2xl mb-4 hover-underline-animation">
                            {{ project.name }}
                        </h2>
                    </div>
                </div>
            </div>

            <transition
                @before-leave="startLeaveAnimation"
                enter-active-class="transition-all duration-700 ease-out"
                enter-from-class="opacity-0 max-h-0"
                enter-to-class="opacity-100 max-h-[1000px]"
                leave-active-class="transition-all duration-700 ease-in"
                leave-from-class="opacity-100 max-h-[1000px]"
                leave-to-class="opacity-0 max-h-0"
            >
                <div v-if="selectedProjectId" 
                     class="project-details-container overflow-hidden">
                    <div class="p-8">
                        <div class="flex gap-12">
                            <div class="w-1/2 transform"
                                :class="{ 
                                    'animate-slide-up': selectedProjectId && !isClosing,
                                    'animate-slide-down': isClosing
                                }">
                                <img :src="selectedProject.image" 
                                     :alt="selectedProject.name" 
                                     class="rounded-lg shadow-lg w-full">
                            </div>
                            
                            <div class="w-1/2 dark:text-white transform"
                                 :class="{ 
                                     'animate-slide-up-delayed': selectedProjectId && !isClosing,
                                     'animate-slide-down-delayed': isClosing
                                 }">
                                <h2 class="font-Jura text-3xl font-bold mb-6">{{ selectedProject.name }}</h2>
                                <div class="space-y-6">
                                    <div>
                                        <h3 class="font-Jura text-2xl font-bold mb-2">Github repo:</h3>
                                        <a :href="selectedProject['github-repo']" 
                                           target="_blank" 
                                           class="text-blue-500 hover:text-blue-600 flex items-center gap-2">
                                            <i class="fab fa-github"></i>
                                            <span>View Repository</span>
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="font-Jura text-2xl font-bold mb-2">Technologies:</h3>
                                        <ul class="list-disc list-inside space-y-2">
                                            <li v-for="tech in selectedProject.technologies" 
                                                :key="tech">{{ tech }}</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h3 class="font-Jura text-2xl font-bold mb-2">Description:</h3>
                                        <p>{{ selectedProject.description }}</p>
                                    </div>
                                </div>
                                
                                <button @click="closeProject" 
                                        class="mt-8 bg-gray-200 dark:bg-stone-700 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-stone-600 transition-colors">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-48">
            <h1 class="dark:text-white font-bold font-Jura text-5xl text-center mb-24 animate-fade-in">Technologies</h1>
            <div class="grid grid-cols-4 gap-16">
                <div v-for="(tech, index) in ['Python', 'C#', 'C++', 'PHP', 'SQL', 'JavaScript', 'HTML', 'CSS']" 
                     :key="tech"
                     class="text-center transform hover:scale-110 transition-all duration-300"
                     :style="{ animationDelay: `${index * 100}ms` }"
                     :class="'animate-slide-up'">
                    <h2 class="dark:text-white text-gray-800 font-Jura text-2xl hover-underline-animation">
                        {{ tech }}
                    </h2>
                </div>
            </div>

            <h1 class="dark:text-white font-bold font-Jura text-5xl text-center mb-24 mt-48 animate-fade-in">Frameworks</h1>
            <div class="grid grid-cols-4 gap-16 mb-32">
                <div v-for="(framework, index) in ['Laravel', 'Tailwind', 'Node.js', 'Bootstrap', 'Vue.js', 'Next.js']" 
                     :key="framework"
                     class="text-center transform hover:scale-110 transition-all duration-300"
                     :style="{ animationDelay: `${(index * 100) + 800}ms` }"
                     :class="'animate-slide-up'">
                    <h2 class="dark:text-white text-gray-800 font-Jura text-2xl hover-underline-animation">
                        {{ framework }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-48">
            <h1 class="dark:text-white font-bold font-Jura text-5xl text-center mb-24 animate-fade-in">Certificates</h1>
            <div class="grid grid-cols-3 gap-12">
                <div class="bg-white dark:bg-stone-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 animate-slide-up">
                    <div class="p-6">
                        <h3 class="font-Jura text-xl font-bold text-gray-800 dark:text-white mb-2">Full Stack Web Development</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">Udemy</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">December 2023</span>
                            <a :href="'https://www.udemy.com/certificate/UC-12345678-9/'" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-blue-500 hover:text-blue-600 flex items-center gap-2 cursor-pointer">
                                View Certificate
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-stone-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 animate-slide-up" style="animation-delay: 200ms">
                    <div class="p-6">
                        <h3 class="font-Jura text-xl font-bold text-gray-800 dark:text-white mb-2">Advanced JavaScript</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">Codecademy</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">November 2023</span>
                            <a :href="'https://www.codecademy.com/profiles/brimsky/certificates/1234567890abcdef'" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-blue-500 hover:text-blue-600 flex items-center gap-2 cursor-pointer">
                                View Certificate
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-stone-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 animate-slide-up" style="animation-delay: 400ms">
                    <div class="p-6">
                        <h3 class="font-Jura text-xl font-bold text-gray-800 dark:text-white mb-2">Vue.js 3 Complete Guide</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">Vue School</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">October 2023</span>
                            <a :href="'https://vueschool.io/certificates/1234567890abcdef'" 
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-blue-500 hover:text-blue-600 flex items-center gap-2 cursor-pointer">
                                View Certificate
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-white dark:bg-stone-800 mt-48">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="text-center mb-8">
                    <h3 class="font-Jura text-2xl font-bold text-gray-800 dark:text-white mb-4">Contact</h3>
                    <a href="mailto:janis.strazdinsh@gmail.com" 
                         class="inline-block text-gray-600 dark:text-gray-300 hover:text-blue-500 transition-colors cursor-pointer">
                        janis.strazdinsh@gmail.com
                    </a>
                </div>

                <div class="flex justify-center gap-8 mb-8">
                    <a v-for="link in socialLinks" 
                        :key="link.id"
                        :href="link.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-blue-500 transition-colors cursor-pointer">
                        <i :class="[link.name === 'GitHub' ? 'fab fa-github' : 'fab fa-linkedin', 'text-2xl group-hover:scale-110 transition-transform']"></i>
                        <span class="text-sm group-hover:text-blue-500">{{ link.name }}</span>
                    </a>
                </div>

                <div class="text-center text-gray-600 dark:text-gray-400">
                    {{ new Date().getFullYear() }} Janis Strazdins. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isDark = ref(
    localStorage.getItem('theme') === 'dark' || 
    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
);

const socialLinks = [
    {
        id: 1,
        name: "GitHub",
        url: "https://github.com/Brimsky",
    },
    {
        id: 2,
        name: "LinkedIn",
        url: "https://www.linkedin.com/in/j%C4%81nis-strazdi%C5%86%C5%A1-2a033b33b/",
    }
]
const projects = [
    {
        id: "1",
        name: "TimberChart.lv",
        "github-repo": "https://github.com/Brimsky/statstream_core_features",
        image: "/img/timberchart.png",
        technologies: ["Vue.js", "Laravel", "Tailwind CSS", "MySQL"],
        description: "A web application for analyzing and visualizing timber market data in Latvia."
    },
    {
        id: "2",
        name: "RSS.lv",
        "github-repo": "url",
        image: "/img/rss.png",
        technologies: ["Vue.js", "Node.js", "Express", "MongoDB"],
        description: "RSS feed aggregator and reader with customizable categories and notifications."
    },
    {
        id: "3",
        name: "Timber web scraper",
        "github-repo": "url",
        image: "/img/scraper.png",
        technologies: ["Python", "BeautifulSoup", "Selenium", "PostgreSQL"],
        description: "Automated web scraping tool for collecting timber price data from various sources."
    }
];

const selectedProjectId = ref(null);
const isClosing = ref(false);

const selectedProject = ref(null);

const startLeaveAnimation = () => {
    isClosing.value = true;
    setTimeout(() => {
        isClosing.value = false;
    }, 700); 
};

const closeProject = () => {
    startLeaveAnimation();
    setTimeout(() => {
        selectedProjectId.value = null;
    }, 50); 
};

const toggleProject = (projectId) => {
    if (selectedProjectId.value === projectId) {
        closeProject();
    } else {
        selectedProjectId.value = projectId;
        selectedProject.value = projects.find(p => p.id === projectId);
    }
};

const toggleTheme = () => {
    isDark.value = !isDark.value;
    updateTheme();
};

const updateTheme = () => {
    if (isDark.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    }
};

onMounted(() => {
    updateTheme();
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Jura:wght@300;400;500;600;700&display=swap');
html {
    scroll-behavior: smooth;
}

.font-Jura {
    font-family: 'Jura', sans-serif;
}

.position-left {
    max-width: 400px;
    height: auto;
    object-fit: cover;
}

.dark {
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
}

.hover-underline-animation {
    display: inline-block;
    position: relative;
    cursor: pointer;
}

.hover-underline-animation::after {
    content: '';
    position: absolute;
    width: 100%;
    transform: scaleX(0);
    height: 2px;
    bottom: -4px;
    left: 0;
    background: linear-gradient(90deg, #3B82F6, #6366F1);
    transform-origin: center;
    transition: transform 0.25s ease-out;
}

.dark .hover-underline-animation::after {
    background: linear-gradient(90deg, #60A5FA, #818CF8);
}

.hover-underline-animation:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
}

.project-details-container {
    margin-top: 2rem;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(30px);
    }
}

.animate-slide-up {
    animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.animate-slide-up-delayed {
    animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.1s forwards;
}

.animate-slide-down {
    animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.animate-slide-down-delayed {
    animation: slideDown 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.1s forwards;
}

.animate-fade-in {
    opacity: 0;
    animation: fadeIn 1s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

a {
    position: relative;
    cursor: pointer;
}

a:hover {
    opacity: 1;
}

a.hover-underline {
    position: relative;
    display: inline-block;
}

a.hover-underline::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: currentColor;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
}

a.hover-underline:hover::after {
    transform: scaleX(1);
    transform-origin: left;
}

.group {
    pointer-events: auto;
}

.group * {
    pointer-events: auto;
}

.bg-white.dark\:bg-stone-800 {
    position: relative;
    backface-visibility: hidden;
    will-change: transform;
}

.bg-white.dark\:bg-stone-800::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: inherit;
    box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.2);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.bg-white.dark\:bg-stone-800:hover::before {
    opacity: 1;
}

.bg-white.dark\:bg-stone-800::after {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: inherit;
    padding: 2px;
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.bg-white.dark\:bg-stone-800:hover::after {
    opacity: 1;
}

.mt-48 {
    margin-top: 12rem;
}

.mb-32 {
    margin-bottom: 8rem;
}

.mb-24 {
    margin-bottom: 6rem;
}
a {
    -webkit-tap-highlight-color: transparent;
    text-decoration: none;
}

.cursor-pointer {
    cursor: pointer !important;
}

/* Improve link hover states */
.hover\:text-blue-500:hover {
    color: #3B82F6 !important;
}
</style>
