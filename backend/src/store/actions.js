import axiosClient from "../axios";

export function getCurrentUser({commit}, data) {
  return axiosClient.get('/user', data)
    .then(({data}) => {
      commit('setUser', data);
      return data;
    })
}

export function login({commit}, data) {
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user);
      commit('setToken', data.token)
      return data;
    })
}

export function logout({commit}) {
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)

      return response;
    })
}

export function getCountries({commit}) {
  return axiosClient.get('countries')
    .then(({data}) => {
      commit('setCountries', data)
    })
}

export function getOrders({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setOrders', [true])
  url = url || '/orders'
  const params = {
    per_page: state.orders.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setOrders', [false, response.data])
    })
    .catch(() => {
      commit('setOrders', [false])
    })
}

export function getOrder({commit}, id) {
  return axiosClient.get(`/orders/${id}`)
}

export function getProducts({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setProducts', [true])
  url = url || '/products'
  const params = {
    per_page: state.products.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setProducts', [false, response.data])
    })
    .catch(() => {
      commit('setProducts', [false])
    })
}

export function getProduct({commit}, id) {
  return axiosClient.get(`/products/${id}`)
}

export function createProduct({ commit }, product) {
  // Always build FormData for creation
  const form = new FormData();

  form.append('title', product.title);
  form.append('description', product.description || '');
  form.append('published', product.published ? 1 : 0);
  form.append('price', product.price ?? 0);

  // Append images (if any)
  if (product.images && product.images.length) {
    product.images.forEach((im) => {
      form.append('images[]', im);
    });
  }

  // Append categories
  if (product.categories && Array.isArray(product.categories)) {
    product.categories.forEach((catId) => {
      form.append('categories[]', catId);
    });
  }

  // Append sizes data
  if (product.sizes && Array.isArray(product.sizes)) {
    product.sizes.forEach((size, index) => {
      if (size.id != null && !size.isNew) {
        form.append(`sizes[${index}][id]`, size.id);
      } else {
        form.append(`sizes[${index}][id]`, '');
        form.append(`sizes[${index}][name]`, size.name || '');
      }
      form.append(`sizes[${index}][price]`, size.price);
      form.append(`sizes[${index}][stock]`, size.stock);
    });
  }

  // Append quantity (which is computed in onSubmit if sizes exist)
  if (product.quantity !== undefined && product.quantity !== null) {
    form.append('quantity', product.quantity);
  }

  return axiosClient.post('/products', form);
}
export function updateProduct({ commit }, product) {
  const id = product.id;

  // If there are images, we switch to FormData:
  if (product.images && product.images.length) {
    const form = new FormData();
    form.append('id', product.id);
    form.append('title', product.title);
    form.append('description', product.description || '');
    form.append('published', product.published ? 1 : 0);
    form.append('price', product.price ?? 0);

    // Images
    product.images.forEach((im) => {
      // If `im` is already a File/Blob, you can do:
      // form.append('images[]', im)
      // If you are re-using `images[im.id]`, you might need:
      // form.append(`images[${im.id}]`, im)
      form.append('images[]', im);
    });

    // If you have deleted images
    if (product.deleted_images && product.deleted_images.length) {
      product.deleted_images.forEach((imageId) =>
        form.append('deleted_images[]', imageId)
      );
    }

    // If you have image positions
    if (product.image_positions) {
      for (let imgId in product.image_positions) {
        form.append(`image_positions[${imgId}]`, product.image_positions[imgId]);
      }
    }

    // Categories
    if (product.categories && Array.isArray(product.categories)) {
      product.categories.forEach((catId) => {
        form.append('categories[]', catId);
      });
    }

    // ✅ Append SIZES
    if (product.sizes && Array.isArray(product.sizes)) {
      product.sizes.forEach((size, index) => {
        // If an existing size in DB:
        if (size.id != null && !size.name) {
          form.append(`sizes[${index}][id]`, size.id);
        } else {
          // If a newly created size (has name)
          form.append(`sizes[${index}][id]`, '');
          form.append(`sizes[${index}][name]`, size.name || '');
        }
        form.append(`sizes[${index}][price]`, size.price);
        form.append(`sizes[${index}][stock]`, size.stock);
      });
    }

    // If quantity:
    if (product.quantity !== undefined && product.quantity !== null) {
      form.append('quantity', product.quantity);
    }

    // For Laravel PUT
    form.append('_method', 'PUT');

    product = form;
  } else {
    // If no images, we can just do JSON
    // But STILL need to pass `sizes` if we want to update them
    product._method = 'PUT';
  }

  return axiosClient.post(`/products/${id}`, product);
}

export function deleteProduct({commit}, id) {
  return axiosClient.delete(`/products/${id}`)
}

export function getUsers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setUsers', [true])
  url = url || '/users'
  const params = {
    per_page: state.users.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setUsers', [false, response.data])
    })
    .catch(() => {
      commit('setUsers', [false])
    })
}

export function createUser({commit}, user) {
  return axiosClient.post('/users', user)
}

export function updateUser({commit}, user) {
  return axiosClient.put(`/users/${user.id}`, user)
}

export function getCustomers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setCustomers', [true])
  url = url || '/customers'
  const params = {
    per_page: state.customers.limit,
  }
  return axiosClient.get(url, {
    params: {
      ...params,
      search, per_page, sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setCustomers', [false, response.data])
    })
    .catch(() => {
      commit('setCustomers', [false])
    })
}

export function getCustomer({commit}, id) {
  return axiosClient.get(`/customers/${id}`)
}

export function createCustomer({commit}, customer) {
  return axiosClient.post('/customers', customer)
}

export function updateCustomer({commit}, customer) {
  return axiosClient.put(`/customers/${customer.id}`, customer)
}

export function deleteCustomer({commit}, customer) {
  return axiosClient.delete(`/customers/${customer.id}`)
}
export function deleteUser({commit}, user) {
  return axiosClient.delete(`/users/${user.id}`)
}

export function getCategories({commit, state}, {sort_field, sort_direction} = {}) {
  commit('setCategories', [true])
  return axiosClient.get('/categories', {
    params: {
      sort_field, sort_direction
    }
  })
    .then((response) => {
      commit('setCategories', [false, response.data])
    })
    .catch(() => {
      commit('setCategories', [false])
    })
}

export function createCategory({ commit }, formData) {
  return axiosClient.post('/categories', formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
}

export function updateCategory({ commit }, formData) {
  // Important: Laravel expects PUT method via POST with `_method=PUT` when using FormData
  formData.append('_method', 'PUT')

  return axiosClient.post(`/categories/${formData.get('id')}`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
}

export function deleteCategory({commit}, category) {
  return axiosClient.delete(`/categories/${category.id}`)
}


export function getBrands({commit}, { sort_field, sort_direction } = {}) {
  commit('setBrands', [true])
  return axiosClient.get('/brands', {
    params: { sort_field, sort_direction }
  })
    .then((res) => commit('setBrands', [false, res.data]))
    .catch(() => commit('setBrands', [false]))
}

export function createBrand({ commit }, formData) {
  return axiosClient.post('/brands', formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
}

export function updateBrand({ commit }, formData) {
  formData.append('_method', 'PUT')
  return axiosClient.post(`/brands/${formData.get('id')}`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
}

export function deleteBrand({ commit }, brand) {
  return axiosClient.delete(`/brands/${brand.id}`)
}
