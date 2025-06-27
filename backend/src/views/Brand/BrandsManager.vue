<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Brands</h1>

    <!-- Create Form -->
    <form @submit.prevent="submitBrand" class="mb-8 bg-white p-6 rounded shadow space-y-4">
      <h2 class="text-lg font-semibold">Add Brand</h2>

      <div>
        <label class="block mb-1 font-medium">Name</label>
        <input v-model="form.name" type="text" class="form-input w-full" required />
      </div>

      <div>
        <label class="block mb-1 font-medium">Image (optional)</label>
        <input type="file" @change="handleFileUpload" class="form-input w-full" />
      </div>

      <button type="submit" class="btn bg-primary text-white hover:bg-primary-600 px-4 py-2">
        {{ form.id ? 'Update' : 'Create' }}
      </button>
    </form>

    <!-- Brands List -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold mb-4">All Brands</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="brand in brands" :key="brand.id" class="border rounded p-4 relative">
          <img
            v-if="brand.image"
            :src="brand.image"
            alt="Brand image"
            class="h-16 object-contain mb-2"
          />
          <h3 class="font-semibold text-lg">{{ brand.name }}</h3>

          <button
            @click="deleteBrand(brand)"
            class="absolute top-2 right-2 text-red-600 hover:text-red-800"
            title="Delete"
          >
            &times;
          </button>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import { ref, onMounted } from 'vue';
import axiosClient from '../../axios.js';

export default {
  name: 'BrandsManager',
  setup() {
    const brands = ref([]);
    const form = ref({
      id: null,
      name: '',
      image: null,
    });

    const fetchBrands = () => {
      axiosClient.get('/brands').then(({ data }) => {
        brands.value = data;
      });
    };

    const submitBrand = () => {
      const payload = new FormData();
      payload.append('name', form.value.name);
      if (form.value.image) {
        payload.append('image', form.value.image);
      }

      const method = form.value.id ? 'post' : 'post';
      const url = form.value.id ? `/brands/${form.value.id}` : '/brands';

      if (form.value.id) {
        payload.append('_method', 'PUT');
      }

      axiosClient[method](url, payload).then(() => {
        fetchBrands();
        resetForm();
      });
    };

    const deleteBrand = (brand) => {
      if (confirm(`Delete brand "${brand.name}"?`)) {
        axiosClient.delete(`/brands/${brand.id}`).then(() => {
          fetchBrands();
        });
      }
    };

    const resetForm = () => {
      form.value = { id: null, name: '', image: null };
    };

    const handleFileUpload = (event) => {
      form.value.image = event.target.files[0];
    };

    const getImageUrl = (path) => {
      return `/storage/${path}`;
    };

    onMounted(() => {
      fetchBrands();
    });

    return {
      brands,
      form,
      submitBrand,
      deleteBrand,
      handleFileUpload,
      getImageUrl,
    };
  },
};

</script>

<style scoped>
.form-input {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 8px;
}
</style>
