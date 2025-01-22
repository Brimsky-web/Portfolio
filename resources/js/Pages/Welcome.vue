<template>
    <div class="min-h-screen bg-gray-100 dark:bg-stone-900 relative pointer-events-auto">
        <button @click="toggleTheme"
                type="button" 
                class="fixed top-4 right-4 p-3 rounded-full bg-gray-200 dark:bg-stone-800 hover:bg-gray-300 dark:hover:bg-stone-700 transition-colors z-50">
                <i class="fas fa-sun text-yellow-500 dark:hidden text-xl"></i>
            <i class="fas fa-moon text-gray-300 hidden dark:block text-xl"></i>
        </button>

        <div class="flex flex-col md:flex-row items-center justify-center relative pt-28 px-4 md:px-0">
            <img src="/img/IMG_2233.png" alt="Janis" class="w-48 md:w-auto md:max-w-md rounded-lg shadow-lg mb-8 md:mb-0" loading="lazy">
            <div class="text-center md:text-left md:p-24">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white p-2">Hi, I'm</h2>
                <h1 class="dark:text-white font-bold font-Jura text-4xl md:text-6xl text-gray-900">Janis Strazdins</h1>
                <h3 class="dark:text-white font-bold font-Jura text-2xl md:text-3xl py-3 md:py-6 px-3">Web developer</h3>
                <h3 class="dark:text-white font-bold font-Jura text-2xl md:text-3xl py-3 md:py-6 px-3">Building things for web</h3>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 md:mt-32 mb-16 md:mb-32">
            <h1 class="dark:text-white font-bold font-Jura text-4xl md:text-5xl text-center mb-8 md:mb-16">Brightest works</h1>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 mb-8 md:mb-16">
                <div v-for="project in props.projects" 
                     :key="project.id" 
                     class="cursor-pointer">
                    <div class="text-center">
                        <h2 @click="toggleProject(project.id)"
                            class="dark:text-white text-gray-800 font-Jura text-xl md:text-2xl mb-4 hover-underline-animation">
                            {{ project.project_name }}
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
                    <div class="p-4 md:p-8">
                        <div class="flex flex-col md:flex-row gap-6 md:gap-12">
                            <div class="w-full md:w-1/2 transform"
                                :class="{ 
                                    'animate-slide-up': selectedProjectId && !isClosing,
                                    'animate-slide-down': isClosing
                                }">
                                <img v-if="selectedProject.photo" 
                                     :src="selectedProject.photo"
                                     :alt="selectedProject.project_name" 
                                     class="rounded-lg shadow-lg w-full">
                                <div v-else class="rounded-lg shadow-lg w-full h-48 md:h-64 bg-gray-200 dark:bg-stone-700 flex items-center justify-center">
                                    <i class="fas fa-image text-3xl md:text-4xl text-gray-400 dark:text-gray-600"></i>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-1/2 dark:text-white transform"
                                 :class="{ 
                                     'animate-slide-up-delayed': selectedProjectId && !isClosing,
                                     'animate-slide-down-delayed': isClosing
                                 }">
                                <h2 class="font-Jura text-2xl md:text-3xl font-bold mb-4 md:mb-6">{{ selectedProject.project_name }}</h2>
                                <div class="space-y-4 md:space-y-6">
                                    <div>
                                        <h3 class="font-Jura text-xl md:text-2xl font-bold mb-2">Github repo:</h3>
                                        <a :href="selectedProject.github_repo_url" 
                                           target="_blank" 
                                           class="text-blue-500 hover:text-blue-600 flex items-center gap-2">
                                            <i class="fab fa-github"></i>
                                            <span>View Repository</span>
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="font-Jura text-xl md:text-2xl font-bold mb-2">Technologies:</h3>
                                        <ul class="list-disc list-inside space-y-2">
                                            <li>{{ selectedProject.technologies }}</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h3 class="font-Jura text-xl md:text-2xl font-bold mb-2">Description:</h3>
                                        <p>{{ selectedProject.description }}</p>
                                    </div>
                                </div>
                                
                                <button @click="closeProject" 
                                        class="mt-6 md:mt-8 bg-gray-200 dark:bg-stone-700 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-stone-600 transition-colors w-full md:w-auto">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16 md:mt-48">
            <h1 class="dark:text-white font-bold font-Jura text-4xl md:text-5xl text-center mb-12 md:mb-24 animate-fade-in">Certificates</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 md:gap-12">
                <div v-for="(cert, index) in props.certificates" 
                    :key="cert.title"
                    class="bg-white dark:bg-stone-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 animate-slide-up relative group"
                    :style="`animation-delay: ${index * 200}ms`">
                    <div class="p-4 md:p-6 h-full flex flex-col justify-between">
                        <div>
                            <h3 class="font-Jura text-lg md:text-xl font-bold text-gray-800 dark:text-white mb-2">{{ cert.certificate_name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ cert.provider }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-4 gap-2">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">{{ cert.date }}</span>
                            <a :href="cert.url"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="text-blue-500 hover:text-blue-600 flex items-center gap-2 z-30 relative">
                                View Certificate
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-48">
            <h1 class="dark:text-white font-bold font-Jura text-5xl text-center mb-24 animate-fade-in">Technologies</h1>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8 md:gap-16">
                <div v-for="(tech, index) in ['Python', 'C#', 'C++', 'PHP', 'SQL', 'JavaScript', 'HTML', 'CSS']" 
                     :key="tech"
                     class="text-center transform hover:scale-110 transition-all duration-300"
                     :style="{ animationDelay: `${index * 100}ms` }"
                     :class="'animate-slide-up'">
                    <h2 class="dark:text-white text-gray-800 font-Jura text-xl md:text-2xl hover-underline-animation">
                        {{ tech }}
                    </h2>
                </div>
            </div>

            <h1 class="dark:text-white font-bold font-Jura text-4xl md:text-5xl text-center mb-12 md:mb-24 mt-16 md:mt-48 animate-fade-in">Frameworks</h1>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-8 md:gap-16 mb-16 md:mb-32">
                <div v-for="(framework, index) in ['Laravel', 'Tailwind', 'Node.js', 'Bootstrap', 'Vue.js', 'Next.js']" 
                     :key="framework"
                     class="text-center transform hover:scale-110 transition-all duration-300"
                     :style="{ animationDelay: `${(index * 100) + 800}ms` }"
                     :class="'animate-slide-up'">
                    <h2 class="dark:text-white text-gray-800 font-Jura text-xl md:text-2xl hover-underline-animation">
                        {{ framework }}
                    </h2>
                </div>
            </div>
        </div>
        <footer class="bg-white dark:bg-stone-800 mt-16 md:mt-48 relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-16">
                <div class="text-center mb-6 md:mb-8">
                    <h3 class="font-Jura text-xl md:text-2xl font-bold text-gray-800 dark:text-white mb-4">Contact</h3>
                    <div class="flex justify-center">
                        <a href="mailto:janis.strazdinsh@gmail.com" 
                           class="text-gray-600 dark:text-gray-300 hover:text-blue-500 transition-colors text-sm md:text-base">
                            janis.strazdinsh@gmail.com
                        </a>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center gap-4 md:gap-8 mb-6 md:mb-8">
                    <a v-for="link in socialLinks" 
                       :key="link.id"
                       :href="link.url"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="group flex items-center gap-2 px-3 py-2 md:px-4 md:py-2 rounded-lg transition-colors hover:bg-gray-100 dark:hover:bg-stone-700 relative z-30">
                        <i :class="`text-xl md:text-2xl ${link.icon} group-hover:text-blue-500`"></i>
                        <span class="text-sm group-hover:text-blue-500">{{ link.name }}</span>
                    </a>
                </div>

                <div class="text-center text-gray-600 dark:text-gray-400 text-sm">
                    {{ new Date().getFullYear() }} Janis Strazdins. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted, defineProps } from 'vue';

const props = defineProps({
    projects: {
        type: Array,
        required: true
    },
    certificates: {
        type: Array,
        required: true
    },
    contacts: {
        type: Array,
        required: true
    }
});

const isDark = ref(
    localStorage.getItem('theme') === 'dark' || 
    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
);

const socialLinks = [
  {
    id: 1,
    name: "GitHub",
    url: "https://github.com/Brimsky",
    icon: "fab fa-github"
  },
  {
    id: 2,
    name: "LinkedIn",
    url: "https://www.linkedin.com/in/j%C4%81nis-strazdi%C5%86%C5%A1-2a033b33b/",
    icon: "fab fa-linkedin"
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
        selectedProject.value = props.projects.find(p => p.id === projectId);
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
    animation: slideUp 0.5s ease forwards;
    opacity: 0;
    transform: translateY(20px);

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

a[href] {
  position: relative;
  cursor: pointer !important;
  display: inline-flex;
  align-items: center;
  text-decoration: none !important;
  outline: none !important;
}
footer a[href] {
  display: flex !important;
  position: relative;
  z-index: 10;
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
