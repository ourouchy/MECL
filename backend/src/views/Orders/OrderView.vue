<template>
  <div v-if="order">

    <!--  Order Details-->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
      <h2 class="flex justify-between items-center text-xl font-semibold pb-2 border-b border-gray-300">
        Order Details
        <OrderStatus :order="order" />
      </h2>
      <table class="w-full mt-2">
        <tbody>
        <tr>
          <td class="font-bold py-1 px-2 w-1/4">Order #</td>
          <td>{{ order.id }}</td>
        </tr>
        <tr>
          <td class="font-bold py-1 px-2">Order Date</td>
          <td>{{ formatDate(order.created_at) }}</td>
        </tr>
        <tr>
          <td class="font-bold py-1 px-2">Order Status</td>
          <td>
            <select
              v-model="order.status"
              @change="onStatusChange"
              class="border border-gray-300 rounded px-2 py-1"
            >
              <option v-for="status of orderStatuses" :key="status" :value="status">{{status}}</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="font-bold py-1 px-2">SubTotal</td>
          <td>{{ $filters.currencyUSD(order.total_price) }}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <!--/  Order Details-->

    <!--  Customer Details-->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
      <h2 class="text-xl font-semibold pb-2 border-b border-gray-300">Customer Details</h2>
      <table class="w-full mt-2">
        <tbody>
        <tr>
          <td class="font-bold py-1 px-2 w-1/4">Full Name</td>
          <td>{{ order.customer.first_name }} {{ order.customer.last_name }}</td>
        </tr>
        <tr>
          <td class="font-bold py-1 px-2">Email</td>
          <td>{{ order.customer.email }}</td>
        </tr>
        <tr>
          <td class="font-bold py-1 px-2">Phone</td>
          <td>{{ order.customer.phone }}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <!--/  Customer Details-->

    <!--  Addresses Details-->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white rounded-lg shadow-sm p-4">
        <h2 class="text-xl font-semibold pb-2 border-b border-gray-300">Billing Address</h2>
        <!--  Billing Address Details-->
        <div class="mt-2">
          {{ order.customer.billingAddress.address1 }}
          <span v-if="order.customer.billingAddress.address2">, {{ order.customer.billingAddress.address2 }}</span> <br>
          {{ order.customer.billingAddress.city }}, {{ order.customer.billingAddress.zipcode }} <br>
          {{ order.customer.billingAddress.state }}, {{ order.customer.billingAddress.country }} <br>
        </div>
        <!--/  Billing Address Details-->
      </div>
      <div class="bg-white rounded-lg shadow-sm p-4">
        <h2 class="text-xl font-semibold pb-2 border-b border-gray-300">Shipping Address</h2>
        <!--  Shipping Address Details-->
        <div class="mt-2">
          {{ order.customer.shippingAddress.address1 }}
          <span v-if="order.customer.shippingAddress.address2">, {{ order.customer.shippingAddress.address2 }}</span> <br>
          {{ order.customer.shippingAddress.city }}, {{ order.customer.shippingAddress.zipcode }} <br>
          {{ order.customer.shippingAddress.state }}, {{ order.customer.shippingAddress.country }} <br>
        </div>
        <!--/  Shipping Address Details-->
      </div>
    </div>
    <!--/  Addresses Details-->

    <!--    Order Items-->
    <!--    Order Items-->
    <div>
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Order Items</h2>
        <span class="text-sm font-medium px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Grouped by size</span>
      </div>

      <!-- Size tabs -->
      <div v-if="Object.keys(groupedItems).length > 1" class="mb-4">
        <div class="flex overflow-x-auto border-b border-gray-200">
          <button
            v-for="(items, sizeName) in groupedItems"
            :key="sizeName"
            @click="activeSize = sizeName"
            class="py-2 px-4 font-medium focus:outline-none"
            :class="activeSize === sizeName ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-600 hover:text-gray-900'"
          >
            {{ sizeName }}
          </button>
        </div>
      </div>

      <!-- Items by size -->
      <div v-for="(items, sizeName) in groupedItems" :key="sizeName" v-show="activeSize === sizeName">
        <div v-for="item of items" :key="item.id">
          <!-- Order Item -->
          <div class="flex flex-col sm:flex-row items-center gap-4">
            <a href="#"
               class="w-36 h-32 flex items-center justify-center overflow-hidden">
              <img :src="item.product.image" class="object-cover" alt=""/>
            </a>
            <div class="flex flex-col justify-between flex-1">
              <div class="flex justify-between mb-3">
                <h3>
                  {{ item.product.title }}
                </h3>
              </div>
              <div class="flex justify-between items-center">
                <div class="flex items-center">Qty: {{ item.quantity }}</div>
                <span class="text-lg font-semibold"> {{ $filters.currencyUSD(item.unit_price) }} </span>
              </div>
            </div>
          </div>
          <!--/ Order Item -->
          <hr class="my-3"/>
        </div>
      </div>
    </div>
    <!--/    Order Items-->    <!--/    Order Items-->

  </div>
</template>

<script setup>
import {computed, onMounted, ref, watch} from "vue";
import store from "../../store";
import { useRoute } from "vue-router";
import axiosClient from "../../axios.js";
import OrderStatus from "./OrderStatus.vue";

const route = useRoute();
const order = ref(null);
const orderStatuses = ref([]);
const activeSize = ref('');
const sizeOptions = ref([]);

const groupedItems = computed(() => {
  if (!order.value || !order.value.items) return {};

  // Group items by size
  const grouped = {};

  for (const item of order.value.items) {
    const sizeName = getSizeName(item);
    if (!grouped[sizeName]) {
      grouped[sizeName] = [];
    }
    grouped[sizeName].push(item);
  }

  return grouped;
});
watch(() => order.value, (newOrder) => {
  if (newOrder && newOrder.items && newOrder.items.length > 0) {
    // Set active size to the first size in the list
    activeSize.value = getSizeName(newOrder.items[0]);
  }
}, { immediate: true });


// Set active size when order loads
onMounted(() => {
  store.dispatch('getOrder', route.params.id)
    .then(({data}) => {
      order.value = data;
      // Set active size to first size in the list
      if (order.value && order.value.items.length > 0) {
        const firstItem = order.value.items[0];
        activeSize.value = getSizeName(firstItem);
      }
    });

  axiosClient.get(`/orders/statuses`)
    .then(({data}) => orderStatuses.value = data);
  axiosClient.get('/sizes')
    .then(result => {
      sizeOptions.value = result.data.map(size => ({
        id: size.id,
        label: size.name
      }));
    })
    .catch(error => {
      console.error('Error fetching sizes:', error);
    });

});

function onStatusChange() {
  axiosClient.post(`/orders/change-status/${order.value.id}/${order.value.status}`)
    .then(({data}) => {
      store.commit('showToast', `Order status was successfully changed into "${order.value.status}"`);
    });
}

function getSizeName(item) {
  // If the item has a size object with a label property
  if (item.size && item.size.label) {
    return item.size.label;
  }

  // If the item has a size with a name property
  if (item.size && item.size.name) {
    return item.size.name;
  }

  // If the item has a size_id, try to find it in the sizeOptions
  if (item.size_id && sizeOptions.value.length) {
    const option = sizeOptions.value.find(opt => opt.id === item.size_id);
    if (option) return option.label;
  }

  // Fallback to a default value
  return 'No Size';
}

function formatDate(dateString) {
  if (!dateString) return '';
  const date = new Date(dateString);
  return new Intl.DateTimeFormat('fr-FR', {
    dateStyle: 'medium',
    timeStyle: 'short'
  }).format(date);
}
</script>

<style scoped>
/* Optional: Add any specific styles here */
</style>
