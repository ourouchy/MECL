<template>
  <div class="p-6">
    <h2 class="text-xl font-bold mb-4">Gestion du Carrousel</h2>

    <!-- Upload Image -->
    <input type="file" @change="onFileChange" class="mb-4 border p-2" />
    <input type="text" v-model="newLink" placeholder="Lien du bouton (optionnel)" class="mb-4 border p-2 w-full" />
    <input type="text" v-model="newButtonText" placeholder="Texte du bouton (ex: Voir l'offre)" class="mb-4 border p-2 w-full" />

    <button @click="uploadImage"
            :disabled="isUploading"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
      <span v-if="isUploading">Envoi en cours...</span>
      <span v-else>Ajouter une image</span>
    </button>

    <!-- Chargement des images -->
    <div v-if="loading" class="mt-4 text-gray-500">Chargement des images...</div>

    <!-- Liste des images -->
    <div v-if="!loading" class="grid grid-cols-3 gap-4 mt-4">
      <div v-for="image in images" :key="image.id" class="relative">
        <img :src="image.image" class="w-full h-32 object-cover rounded-lg" />
        <p class="mt-2 text-sm text-gray-700">{{ image.button_text }}</p>
        <a v-if="image.link" :href="image.link" target="_blank" class="block text-blue-500 underline mt-2">
          Voir le lien
        </a>
        <button @click="deleteImage(image.id)" class="absolute top-2 right-2 bg-red-500 text-white px-2 py-1 text-xs rounded">
          X
        </button>
      </div>
    </div>
  </div>
</template>

<script>
// Remplacez cette ligne

// Par celle-ci
import axiosClient from '../../axios.js';

export default {
  data() {
    return {
      images: [],
      selectedFile: null,
      newLink: '',
      newButtonText: '',
      isUploading: false,
      loading: false
    };
  },
  mounted() {
    this.fetchImages();
  },
  methods: {
    async fetchImages() {
      try {
        this.loading = true;
        // Utilisez axiosClient au lieu d'axios
        const response = await axiosClient.get('/carousel-images');
        this.images = response.data;
      } catch (error) {
        console.error("❌ Erreur lors du chargement des images :", error);
      } finally {
        this.loading = false;
      }
    },
    onFileChange(event) {
      this.selectedFile = event.target.files[0];
    },
    async uploadImage() {
      if (!this.selectedFile) {
        alert("❌ Veuillez sélectionner une image");
        return;
      }

      let formData = new FormData();
      formData.append("image", this.selectedFile);
      formData.append("link", this.newLink || '');
      formData.append("button_text", this.newButtonText || 'Voir plus');

      try {
        this.isUploading = true;
        // Utilisez axiosClient au lieu d'axios
        const response = await axiosClient.post('/carousel-images', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        });

        console.log("✅ Image ajoutée :", response.data);
        this.newLink = '';
        this.newButtonText = '';
        this.selectedFile = null;

        this.fetchImages();
      } catch (error) {
        console.error("❌ Erreur lors de l'upload :", error);
        // Ajoutez plus de détails sur l'erreur pour le débogage
        if (error.response) {
          console.error("Status:", error.response.status);
          console.error("Data:", error.response.data);
        }
      } finally {
        this.isUploading = false;
      }
    },
    async deleteImage(id) {
      try {
        // Utilisez axiosClient au lieu d'axios
        await axiosClient.delete(`/carousel-images/${id}`);
        this.fetchImages();
      } catch (error) {
        console.error("❌ Erreur lors de la suppression de l'image :", error);
      }
    }
  }
};
</script>
