<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <TransitionRoot as="template" :show="show">
    <Dialog as="div" class="relative z-10" @close="show = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                       leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity"/>
      </TransitionChild>

      <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300"
                           enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                           enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                           leave-from="opacity-100 translate-y-0 sm:scale-100"
                           leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel
              class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">
              <Spinner v-if="loading"
                       class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"/>
              <header class="py-3 px-4 flex justify-between items-center">
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                  {{ category.id ? `Update category: "${props.category.name}"` : 'Create new Category' }}
                </DialogTitle>
                <button
                  @click="closeModal()"
                  class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </header>
              <form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">
                  <CustomInput class="mb-2" v-model="category.name" label="Name" :errors="errors['name']"/>
                  <CustomInput type="select"
                               :select-options="parentCategories"
                               class="mb-2"
                               v-model="category.parent_id"
                               label="Parent" :errors="errors['parent_id']"/>
                  <CustomInput type="checkbox" class="mb-2" v-model="category.active" label="Active"  :errors="errors['active']"/>
                  <CustomInput
                  class="mb-4"
                  type="textarea"
                  v-model="category.description"
                  label="Description"
                  :errors="errors['description']"
                />
                  <!-- Banner Image -->
                  <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Banner Image</label>
                    <input type="file" @change="onFileChange($event, 'banner_image')" accept="image/*" class="border p-2 rounded w-full" />
                  </div>

                  <!-- Selection Image -->
                  <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Selection Image</label>
                    <input type="file" @change="onFileChange($event, 'selection_image')" accept="image/*" class="border p-2 rounded w-full" />
                  </div>
                </div>
                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <button type="submit"
                          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                          text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                    Submit
                  </button>
                  <button type="button"
                          class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                          @click="closeModal" ref="cancelButtonRef">
                    Cancel
                  </button>
                </footer>
              </form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {computed, onUpdated, ref} from 'vue'
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {ExclamationIcon} from '@heroicons/vue/outline'
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";

const loading = ref(false)
const errors = ref({})

const props = defineProps({
  modelValue: Boolean,
  category: {
    required: true,
    type: Object,
  }
})

const category = ref({
  id: props.category.id,
  name: props.category.name,
  active: props.category.active,
  parent_id: props.category.parent_id,
  description: props.category.description || '',
  banner_image: null,
  selection_image: null,
})

const emit = defineEmits(['update:modelValue', 'close'])

const show = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})
const parentCategories = computed(() => {
  return [
    {key: '', text: 'Select Parent Category'},
    ...store.state.categories.data
      .filter(c => {
        if (category.value.id) {
          return c.id !== category.value.id
        }
        return true;
      })
      .map(c => ({key: c.id, text: c.name}))
      .sort((c1, c2) => {
        if (c1.text < c2.text) return -1;
        if (c1.text > c2.text) return 1;
        return 0;
      })
  ]
})

onUpdated(() => {
  category.value = {
    id: props.category.id,
    name: props.category.name,
    active: props.category.active,
    parent_id: props.category.parent_id,
    description: props.category.description,
    banner_image: null,
    selection_image: null,
  }
})

function closeModal() {
  show.value = false
  emit('close')
  errors.value = {};
}

function onSubmit() {
  loading.value = true
  category.value.active = category.value.active === true || category.value.active === 'true' || category.value.active === 1 ? 1 : 0;
  if (category.value.id) {
    const formData = buildFormData(category.value)
    store.dispatch('updateCategory', formData)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          store.commit('showToast', 'Category was successfully updated');
          store.dispatch('getCategories')
          closeModal()
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors
      })
  } else {
    const formData = buildFormData(category.value)
    store.dispatch('createCategory', formData)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          store.commit('showToast', 'Category was successfully created');
          store.dispatch('getCategories')
          closeModal()
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors
      })
  }
}
function buildFormData(dataObj) {
  const formData = new FormData()
  Object.entries(dataObj).forEach(([key, value]) => {
    if (value !== null && value !== undefined) {
      formData.append(key, value)
    }
  })
  return formData
}
function onFileChange(event, field) {
  const file = event.target.files[0];
  if (file) {
    category.value[field] = file;
  }
}
</script>
