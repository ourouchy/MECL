<template>
  <div>
    <div class="flex items-center justify-between mb-3">
      <h1 v-if="!loading" class="text-3xl font-semibold">
        {{ product.id ? `Update product: "${product.title}"` : 'Create new Product' }}
      </h1>
    </div>

    <div class="bg-white rounded-lg shadow animate-fade-in-down relative">
      <Spinner v-if="loading" class="absolute inset-0 flex items-center justify-center z-50 bg-white" />

      <form v-if="!loading" @submit.prevent="onSubmit">
        <div class="grid grid-cols-3">
          <div class="col-span-2 px-4 pt-5 pb-4">
            <!-- Product Title -->
            <CustomInput
              class="mb-2"
              v-model="product.title"
              label="Product Title"
              :errors="errors['title']"
            />

            <!-- Description -->
            <CustomInput
              type="richtext"
              class="mb-2"
              v-model="product.description"
              label="Description"
              :errors="errors['description']"
            />

            <!-- Price -->
            <CustomInput
              type="number"
              class="mb-2"
              v-model="product.price"
              label="Price"
              prepend="$"
              :disabled="displaySizes.length > 0"
              :errors="errors['price']"
            />
            <CustomInput
              type="number"
              class="mb-2"
              v-model="product.discount_percent"
              label="Discount (%)"
              :errors="errors['discount_percent']"
            />
            <p v-if="discountedLabel" class="text-sm text-green-600 mb-2">
              {{ discountedLabel }}
            </p>
            <!-- Quantity -->
            <CustomInput
              type="number"
              class="mb-2"
              v-model="product.quantity"
              label="Quantity"
              :disabled="displaySizes.length > 0"
              :errors="errors['quantity']"
            />
            <div v-if="displaySizes.length > 0" class="text-sm text-gray-600 mb-2">
              Price and Quantity are auto-calculated from the sizes.
            </div>

            <!-- Sizes & Prices (Treeselect) -->
            <div class="mb-2">
              <label class="block text-sm font-medium text-gray-700">
                Sizes & Prices
              </label>
              <treeselect
                :key="sizeOptionsKey"
                v-model="selectedSizeValues"
                :multiple="true"
                :options="sizeOptions"
              />
            </div>

            <!-- Add new size -->
            <div class="mt-2 flex space-x-2">
              <CustomInput
                v-model="newSizeName"
                placeholder="Enter a new size"
              />
              <button
                @click="addNewSize"
                type="button"
                class="px-3 py-2 bg-blue-600 text-white rounded-md"
              >
                Add Size
              </button>
            </div>

            <!-- Display Sizes with Price & Stock -->
            <div v-if="displaySizes.length" class="mt-2 border rounded-md p-3">
              <div
                v-for="(size, index) in displaySizes"
                :key="index"
                class="flex items-center space-x-4 mb-2"
              >
                <span class="w-1/3">{{ getSizeName(size) }}</span>
                <CustomInput
                  type="number"
                  v-model="size.price"
                  label="Price ($)"
                  prepend="$"
                  :errors="errors[`sizes.${index}.price`]"
                />
                <CustomInput
                  type="number"
                  v-model="size.stock"
                  label="Stock"
                  :errors="errors[`sizes.${index}.stock`]"
                />
              </div>
            </div>

            <!-- Published Checkbox -->
            <CustomInput
              type="checkbox"
              class="mb-2"
              v-model="product.published"
              label="Published"
              :errors="errors['published']"
            />
            <!-- Brand Selector -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
              <select
                v-model="product.brand_id"
                class="form-select w-full border-gray-300 rounded-md shadow-sm focus:ring-primary focus:border-primary"
              >
                <option :value="null">No Brand</option>
                <option
                  v-for="brand in brands"
                  :key="brand.id"
                  :value="brand.id"
                >
                  {{ brand.name }}
                </option>
              </select>
            </div>

            <!-- Categories Treeselect -->
            <treeselect
              v-model="product.categories"
              :multiple="true"
              :options="options"
              :errors="errors['categories']"
            />
          </div>

          <!-- Image Upload / Preview -->
          <div class="col-span-1 px-4 pt-5 pb-4">
            <image-preview
              v-model="product.images"
              :images="product.images"
              v-model:deleted-images="product.deleted_images"
              v-model:image-positions="product.image_positions"
            />
          </div>
        </div>

        <!-- Footer: Save, Save & Close, Cancel -->
        <footer class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <!-- Save button becomes disabled when new sizes are present -->
          <button
            type="submit"
            :disabled="hasNewSizes"
            :class="[
                      'mt-3 w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white',
                      hasNewSizes ? 'border-dashed bg-gray-400 cursor-not-allowed' : 'border-gray-300 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500'
                    ]"
                            >
            Save
          </button>

          <button
            type="button"
            @click="onSubmit($event, true)"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
          >
            Save &amp; Close
          </button>

          <router-link
            :to="{ name: 'app.products' }"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
            ref="cancelButtonRef"
          >
            Cancel
          </router-link>
        </footer>
      </form>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import store from '../../store/index.js'
import axiosClient from '../../axios.js'

// Components
import Spinner from '../../components/core/Spinner.vue'
import CustomInput from '../../components/core/CustomInput.vue'
import ImagePreview from '../../components/ImagePreview.vue'
import Treeselect from 'vue3-treeselect'
import 'vue3-treeselect/dist/vue3-treeselect.css'

/**
 * Define data references
 */
const originalDiscount = ref(null); // 🆕
const route = useRoute()
const router = useRouter()

const product = ref({
  id: null,
  title: null,
  images: [],
  deleted_images: [],
  image_positions: {},
  description: '',
  price: null,
  quantity: null,
  published: false,
  categories: [],
  brand_id: null,
  original_price: null,
  discount_percent: null
})

// Sizes handling
const selectedSizeValues = ref([]) // For treeselect selection
const displaySizes = ref([]) // Full array of size objects
const sizeOptions = ref([]) // List of all possible sizes (from DB)
const newSizeName = ref('') // For adding a new size
const hasNewSizes = computed(() => {
  return displaySizes.value.some(size => size.isNew);
});
const sizeOptionsKey = computed(() => sizeOptions.value.length);
// Error & loading states
const errors = ref({})
const loading = ref(false)

// Category tree
const options = ref([])

const emit = defineEmits(['update:modelValue', 'close'])
const discountedLabel = computed(() => {
  const discount = parseFloat(product.value.discount_percent);
  const original = parseFloat(product.value.price);

  if (
    !isNaN(discount) &&
    !isNaN(original) &&
    discount > 0 &&
    discount < 100
  ) {
    const after = original * (1 - discount / 100);
    return `Final Price After Discount: £${after.toFixed(2)}`;
  }
  return null;
});
/**
 * Load product data (if editing) + load categories & size options
 */
onMounted(() => {
  // If we have an ID, load the product
  if (route.params.id) {
    loading.value = true
    store.dispatch('getProduct', route.params.id)
      .then(response => {
        loading.value = false

        // The API returns { product: { ... }, sizes: [...], images: [...] }
        // So we pick the `product` key:
        product.value = response.data.product
        recalculateDiscount();
        originalDiscount.value = product.value.discount_percent;
        if (response.data.product.original_price && response.data.product.price) {
          const original = parseFloat(response.data.product.original_price);
          const current = parseFloat(response.data.product.price);
          const percent = 100 * (original - current) / original;
          response.data.product.discount_percent = parseFloat(percent.toFixed(1));
        }
        originalDiscount.value = product.value.discount_percent;
        console.log('Submitting product with:', {
          price: product.value.price,
          original_price: product.value.original_price,
          discount_percent: product.value.discount_percent
        });
        // If we have size data from the response
        if (response.data.sizes && response.data.sizes.length) {
          displaySizes.value = response.data.sizes.map(size => ({
            id: size.id,
            label: size.name,
            price: size.price,
            stock: size.stock
          }))
          // Mark them as selected
          selectedSizeValues.value = displaySizes.value.map(size => size.id)
        }
      })
      .catch(err => {
        loading.value = false
        console.error('Error fetching product:', err)
      })
  }

  // Fetch category tree
  axiosClient.get('/categories/tree')
    .then(result => {
      options.value = result.data
    })
    .catch(err => {
      console.error('Error fetching categories:', err)
    })

  // Fetch all possible sizes
  axiosClient.get('/sizes')
    .then(result => {
      sizeOptions.value = result.data.map(size => ({
        id: size.id,
        label: size.name
      }))
    })
    .catch(error => {
      console.error('Error fetching sizes:', error)
    })
})
const brands = ref([])

axiosClient.get('/brands')
  .then(res => {
    brands.value = res.data
  })
  .catch(err => {
    console.error('Error loading brands:', err)
  })
/**
 * Watch the selected size values to update displaySizes accordingly
 */
watch(
  selectedSizeValues,
  newValues => {
    // Gather existing IDs from displaySizes
    const existingIds = displaySizes.value.map(s => s.id)

    // Remove sizes that are no longer selected
    displaySizes.value = displaySizes.value.filter(size =>
      newValues.includes(size.id)
    )

    // Add newly selected sizes
    newValues.forEach(id => {
      if (!existingIds.includes(id)) {
        const option = sizeOptions.value.find(opt => opt.id === id)
        if (option) {
          displaySizes.value.push({
            id: option.id,
            label: option.label,
            price: product.value.price || 0,
            stock: 0
          })
        }
      }
    })
  },
  { deep: true }
)

/**
 * Return size's display name
 */
function getSizeName(size) {
  // If the object itself has a label
  if (size.label) return size.label

  // If not, try to find from the sizeOptions
  if (size.id) {
    const option = sizeOptions.value.find(opt => opt.id === size.id)
    if (option) return option.label
  }
  return 'Unknown Size'
}

/**
 * Add a brand-new size that doesn't exist in DB yet
 */
function addNewSize() {
  if (!newSizeName.value.trim()) return

  const tempId = `new-${Date.now()}`

  const newSize = {
    id: tempId,
    label: newSizeName.value.trim(),
    price: product.value.price || 0,
    stock: 0,
    isNew: true
  }

  // Add to sizeOptions
  sizeOptions.value.push(newSize)
  // Add to display
  displaySizes.value.push(newSize)
  // Mark as selected
  selectedSizeValues.value.push(tempId)

  // Clear the input
  newSizeName.value = ''
}

/**
 * Submit form (create or update product)
 * @param {Event} $event
 * @param {Boolean} close - whether to close the form after saving
 */
function onSubmit($event, close = false) {
  loading.value = true;
  errors.value = {};

  // If sizes exist, compute total quantity and minimum price
  if (displaySizes.value.length > 0) {
    const totalStock = displaySizes.value.reduce((sum, size) => sum + Number(size.stock), 0);
    product.value.quantity = totalStock;

    if (displaySizes.value.length > 0) {
      const discountedPrices = displaySizes.value.map(size => {
        const original = size.original_price || size.price; // fallback if original_price missing
        const discount = parseFloat(product.value.discount_percent) || 0;
        const finalPrice = discount > 0 ? original * (1 - discount / 100) : original;
        return Number(finalPrice);
      });

      product.value.price = Math.min(...discountedPrices);
    }
  } else {
    product.value.quantity = product.value.quantity || null;
  }

  const discountChanged = product.value.discount_percent !== originalDiscount.value;

  // Apply discount only if user changed it
  if (discountChanged && product.value.discount_percent && product.value.price) {
    applyDiscountToProductAndSizes();
  }

  // Map sizes
  product.value.sizes = displaySizes.value.map(size => ({
    id: (size.isNew && String(size.id).startsWith("new-")) ? null : parseInt(size.id),
    ...(size.isNew ? { name: size.label } : {}),
    price: Number(size.price),
    stock: Number(size.stock),
    original_price: size.original_price ?? null,
  }));

  // 🛠️ Final payload: Clone and clean
  const payload = { ...product.value };

  // Remove frontend-only fields
  if (!product.value.discount_percent || isNaN(product.value.discount_percent) || product.value.discount_percent <= 0 || product.value.discount_percent >= 100) {
    delete payload.discount_percent;
  }
  // Ensure original_price exists if needed
  if (!payload.original_price && displaySizes.value.length === 0) {
    payload.original_price = payload.price;
  }

  // 🛠️ Make sure brand_id is preserved
  if (!payload.brand_id) {
    payload.brand_id = null; // No brand selected is still valid
  }

  // Create or Update
  if (product.value.id) {
    // Update product
    store.dispatch('updateProduct', payload)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          product.value = response.data;
          recalculateDiscount(); // 🆕 Recalculate after update
          originalDiscount.value = product.value.discount_percent; // 🆕 Reset
          store.commit('showToast', 'Product was successfully updated');
          store.dispatch('getProducts');
          if (close) {
            router.push({ name: 'app.products' });
          }
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response?.data?.errors || {};
      });
  } else {
    // Create new product
    store.dispatch('createProduct', payload)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          product.value = response.data;
          store.commit('showToast', 'Product was successfully created');
          store.dispatch('getProducts');

          if (close) {
            router.push({ name: 'app.products' });
          } else {
            router.push({ name: 'app.products.edit', params: { id: response.data.id } });
          }
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response?.data?.errors || {};
      });
  }
}

function applyDiscountToProductAndSizes() {
  const discount = parseFloat(product.value.discount_percent);
  const originalPrice = parseFloat(product.value.original_price || product.value.price);

  if (!isNaN(discount) && !isNaN(originalPrice) && discount > 0 && discount < 100) {
    // Save original_price if missing
    if (!product.value.original_price) {
      product.value.original_price = originalPrice;
    }

    // Always calculate from originalPrice
    const discountedPrice = originalPrice * (1 - discount / 100);
    product.value.price = parseFloat(discountedPrice.toFixed(2));

    // Apply discount to each size price based on original_price
    displaySizes.value.forEach(size => {
      const sizeOriginalPrice = size.original_price || size.price;
      if (!size.original_price) {
        size.original_price = sizeOriginalPrice;
      }
      size.price = parseFloat((size.original_price * (1 - discount / 100)).toFixed(2));
    });
  }
}
function recalculateDiscount() {
  const original = parseFloat(product.value.original_price);
  const current = parseFloat(product.value.price);

  if (!isNaN(original) && !isNaN(current) && original > 0 && current > 0 && current < original) {
    const percent = 100 * (original - current) / original;
    product.value.discount_percent = parseFloat(percent.toFixed(1));
  } else {
    product.value.discount_percent = null; // No valid discount
  }
}
</script>
