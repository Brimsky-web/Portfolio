<template>
    <div class="dark:bg-stone-900 min-h-screen p-8">
        <!-- Theme Toggle Button -->
        <button @click="toggleTheme"
                type="button" 
                class="fixed top-4 right-4 p-3 rounded-full bg-gray-200 dark:bg-stone-800 hover:bg-gray-300 dark:hover:bg-stone-700 transition-colors z-50">
            <i class="fas fa-sun text-yellow-500 dark:hidden text-xl"></i>
            <i class="fas fa-moon text-gray-300 hidden dark:block text-xl"></i>
        </button>

        <h1 class="dark:text-white font-bold font-Jura text-5xl text-center mb-12">Admin</h1>

        <!-- Projects Section -->
        <div class="mb-16 bg-white dark:bg-stone-800 rounded-lg p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold dark:text-white">Projects</h2>
                <button @click="showProjectForm = true" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                    Add Project
                </button>
            </div>

            <!-- Project Form -->
            <div v-if="showProjectForm" class="mb-8 bg-gray-50 dark:bg-stone-700 p-6 rounded-lg">
                <h3 class="text-2xl font-bold mb-4 dark:text-white">{{ editingProject ? 'Edit Project' : 'Add New Project' }}</h3>
                <form @submit.prevent="saveProject" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">Project Name</label>
                        <input v-model="projectForm.project_name" type="text" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">GitHub URL</label>
                        <input v-model="projectForm.github_repo_url" type="url" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">Technologies</label>
                        <input v-model="projectForm.technologies" type="text" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">Description</label>
                        <textarea v-model="projectForm.description" rows="3" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">Project Photo</label>
                        <input type="file" @input="handlePhotoInput" accept="image/*" class="mt-1 w-full">
                        <p class="text-sm text-gray-500 mt-1">Maximum file size: 5MB</p>
                        <div v-if="errors.photo" class="text-red-500 text-sm mt-1">{{ errors.photo }}</div>
                        <img v-if="projectForm.photo_preview" :src="projectForm.photo_preview" class="mt-2 max-w-xs rounded-lg shadow-md">
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">Save</button>
                        <button type="button" @click="cancelProjectEdit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Projects List -->
            <div class="grid gap-6">
                <div v-for="project in projects" :key="project.id" class="bg-gray-50 dark:bg-stone-700 p-6 rounded-lg">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold dark:text-white">{{ project.project_name }}</h3>
                        <div class="flex gap-2">
                            <button @click="editProject(project)" class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="deleteProject(project.id)" class="text-red-500 hover:text-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 dark:text-gray-300">{{ project.description }}</p>
                            <div class="mt-2">
                                <a :href="project.github_repo_url" target="_blank" class="text-blue-500 hover:text-blue-600">
                                    <i class="fab fa-github mr-2"></i>GitHub Repository
                                </a>
                            </div>
                            <div class="mt-2">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Technologies: {{ project.technologies }}</span>
                            </div>
                        </div>
                        <div v-if="project.photo" class="flex justify-end">
                            <img :src="project.photo" :alt="project.project_name" class="rounded-lg shadow-md max-h-48 object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificates Section -->
        <div class="mb-16 bg-white dark:bg-stone-800 rounded-lg p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold dark:text-white">Certificates</h2>
                <button @click="showCertificateForm = true" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                    Add Certificate
                </button>
            </div>

            <!-- Certificate Form -->
            <div v-if="showCertificateForm" class="mb-8 bg-gray-50 dark:bg-stone-700 p-6 rounded-lg">
                <h3 class="text-2xl font-bold mb-4 dark:text-white">{{ editingCertificate ? 'Edit Certificate' : 'Add New Certificate' }}</h3>
                <form @submit.prevent="saveCertificate" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">Certificate Name</label>
                        <input v-model="certificateForm.certificate_name" type="text" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                        <label class="block text-sm font-medium dark:text-gray-200">Provider</label>
                        <input v-model="certificateForm.provider" type="text" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                        <label class="block text-sm font-medium dark:text-gray-200">URL</label>
                        <input v-model="certificateForm.url" type="url" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                        <label class="block text-sm font-medium dark:text-gray-200">Date</label>
                        <input v-model="certificateForm.date" type="date" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">Save</button>
                        <button type="button" @click="cancelCertificateEdit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Certificates List -->
            <div class="grid gap-4">
                <div v-for="certificate in certificates" :key="certificate.id" class="bg-gray-50 dark:bg-stone-700 p-4 rounded-lg flex justify-between items-center">
                    <span class="dark:text-white">{{ certificate.certificate_name }}</span>
                    <div class="flex gap-2">
                        <button @click="editCertificate(certificate)" class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button @click="deleteCertificate(certificate.id)" class="text-red-500 hover:text-red-600">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacts Section -->
        <!-- <div class="mb-16 bg-white dark:bg-stone-800 rounded-lg p-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold dark:text-white">Contacts</h2>
                <button @click="showContactForm = true" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">
                    Add Contact
                </button>
            </div> -->

            <!-- Contact Form -->
            <!-- <div v-if="showContactForm" class="mb-8 bg-gray-50 dark:bg-stone-700 p-6 rounded-lg">
                <h3 class="text-2xl font-bold mb-4 dark:text-white">{{ editingContact ? 'Edit Contact' : 'Add New Contact' }}</h3>
                <form @submit.prevent="saveContact" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">Platform</label>
                        <input v-model="contactForm.platform" type="text" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">Icon (Font Awesome class)</label>
                        <input v-model="contactForm.icon" type="text" placeholder="fab fa-linkedin" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium dark:text-gray-200">URL</label>
                        <input v-model="contactForm.url" type="url" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-stone-600 dark:text-white dark:border-stone-500">
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition">Save</button>
                        <button type="button" @click="cancelContactEdit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Cancel</button>
                    </div>
                </form>
            </div> -->

            <!-- Contacts List -->
            <!-- <div class="grid gap-4">
                <div v-for="contact in contacts" :key="contact.id" class="bg-gray-50 dark:bg-stone-700 p-4 rounded-lg flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i :class="contact.icon" class="text-xl"></i>
                        <span class="dark:text-white">{{ contact.platform }}</span>
                    </div>
                    <div class="flex gap-2">
                        <button @click="editContact(contact)" class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button @click="deleteContact(contact.id)" class="text-red-500 hover:text-red-600">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div> -->
        <!-- </div> -->
    </div>
</template>

<script setup>
import { ref, defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    projects: Array,
    certificates: Array,
    contacts: Array
});

// Theme toggle
const isDark = ref(
    localStorage.getItem('theme') === 'dark' || 
    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
);

const toggleTheme = () => {
    isDark.value = !isDark.value;
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark');
};

// Projects
const showProjectForm = ref(false);
const editingProject = ref(null);
const projectForm = ref({
    project_name: '',
    github_repo_url: '',
    technologies: '',
    description: '',
    photo: null,
    photo_preview: null
});

const errors = ref({});

const handlePhotoInput = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Check file size (5MB = 5 * 1024 * 1024 bytes)
        if (file.size > 5 * 1024 * 1024) {
            errors.value.photo = 'The photo must not be larger than 5MB';
            event.target.value = ''; // Clear the input
            return;
        }
        
        projectForm.value.photo = file;
        // Create preview URL
        projectForm.value.photo_preview = URL.createObjectURL(file);
        errors.value.photo = null;
    }
};

const editProject = (project) => {
    editingProject.value = project;
    projectForm.value = { 
        ...project,
        photo: null,
        photo_preview: project.photo
    };
    showProjectForm.value = true;
};

const cancelProjectEdit = () => {
    showProjectForm.value = false;
    editingProject.value = null;
    projectForm.value = {
        project_name: '',
        github_repo_url: '',
        technologies: '',
        description: '',
        photo: null,
        photo_preview: null
    };
    errors.value = {};
};

const saveProject = () => {
    errors.value = {}; // Clear previous errors
    let formData = new FormData();
    formData.append('project_name', projectForm.value.project_name);
    formData.append('github_repo_url', projectForm.value.github_repo_url);
    formData.append('technologies', projectForm.value.technologies);
    formData.append('description', projectForm.value.description);
    
    if (projectForm.value.photo instanceof File) {
        formData.append('photo', projectForm.value.photo);
    }

    const options = {
        onSuccess: () => {
            cancelProjectEdit();
            router.reload();
        },
        onError: (errors) => {
            console.error('Error:', errors);
            errors.value = errors;
        }
    };

    if (editingProject.value) {
        formData.append('_method', 'POST');
        router.post(`/projects/update/${editingProject.value.id}`, formData, options);
    } else {
        router.post('/projects/store', formData, options);
    }
};

const deleteProject = (id) => {
    if (confirm('Are you sure you want to delete this project?')) {
        router.get(`/projects/destroy/${id}`, {
            onSuccess: () => router.reload()
        });
    }
};

// Certificates
const showCertificateForm = ref(false);
const editingCertificate = ref(null);
const certificateForm = ref({
    certificate_name: '',
    provider: '',
    url: '',
    date: ''
});

const editCertificate = (certificate) => {
    editingCertificate.value = certificate;
    certificateForm.value = { ...certificate };
    showCertificateForm.value = true;
};

const cancelCertificateEdit = () => {
    editingCertificate.value = null;
    certificateForm.value = { 
        certificate_name: '',
        provider: '',
        url: '',
        date: ''
     };
    showCertificateForm.value = false;
};

const saveCertificate = () => {
    if (editingCertificate.value) {
        router.post(`/certificates/update/${editingCertificate.value.id}`, certificateForm.value, {
            onSuccess: () => {
                cancelCertificateEdit();
                router.reload();
            }
        });
    } else {
        router.post('/certificates/store', certificateForm.value, {
            onSuccess: () => {
                cancelCertificateEdit();
                router.reload();
            }
        });
    }
};

const deleteCertificate = (id) => {
    if (confirm('Are you sure you want to delete this certificate?')) {
        router.get(`/certificates/destroy/${id}`, {
            onSuccess: () => router.reload()
        });
    }
};

// Contacts
const showContactForm = ref(false);
const editingContact = ref(null);
const contactForm = ref({
    platform: '',
    url: '',
    icon: ''
});

const editContact = (contact) => {
    editingContact.value = contact;
    contactForm.value = { ...contact };
    showContactForm.value = true;
};

const cancelContactEdit = () => {
    editingContact.value = null;
    contactForm.value = { 
        platform: '', 
        url: '', 
        icon: '' 
    };
    showContactForm.value = false;
};

const saveContact = () => {
    if (editingContact.value) {
        router.post(`/contacts/update/${editingContact.value.id}`, contactForm.value, {
            onSuccess: () => {
                cancelContactEdit();
                router.reload();
            }
        });
    } else {
        router.post('/contacts/store', contactForm.value, {
            onSuccess: () => {
                cancelContactEdit();
                router.reload();
            }
        });
    }
};

const deleteContact = (id) => {
    if (confirm('Are you sure you want to delete this contact?')) {
        router.get(`/contacts/destroy/${id}`, {
            onSuccess: () => router.reload()
        });
    }
};
</script>