import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'
import {get, post} from "./http.js";

Alpine.plugin(collapse)

window.Alpine = Alpine;

document.addEventListener("alpine:init", async () => {
  Alpine.data("sidebar", () => ({
    active: false,
    position: "",
    bodyDirection: "",
    init() {
      this.position = this.$el.getAttribute("data-position");
      this.bodyDirection = this.position === "left" ? "body:right" : "body:left";
    },
    setup: {
      ["x-show"]() {
        return this.active;
      },
      ["@click.away"]() {
        this.close();
        console.log("Sidebar clicked away");
      },
      [":class"]() {
        return {
          "left-0 -translate-x-full md:-translate-x-120": this.position === "left",
          "right-0 translate-x-full md:translate-x-120": this.position === "right"
        };
      }
    },
    open() {
      this.active = true;
      this.$dispatch(this.bodyDirection);
      this.$dispatch("overlay:open");
      console.log("Sidebar open");
    },
    close() {
      this.$dispatch("body:reset");
      this.$dispatch("overlay:close");
      setTimeout(() => {
        this.active = false;
      }, 500);
      console.log("Sidebar closed");
    }
  }));


  Alpine.data("toast", () => ({
    visible: false,
    delay: 5000,
    percent: 0,
    interval: null,
    timeout: null,
    message: null,
    type: null,
    close() {
      this.visible = false;
      clearInterval(this.interval);
    },
    show(message, type = 'success') {
      this.visible = true;
      this.message = message;
      this.type = type;

      if (this.interval) {
        clearInterval(this.interval);
        this.interval = null;
      }
      if (this.timeout) {
        clearTimeout(this.timeout);
        this.timeout = null;
      }

      this.timeout = setTimeout(() => {
        this.visible = false;
        this.timeout = null;
      }, this.delay);
      const startDate = Date.now();
      const futureDate = Date.now() + this.delay;
      this.interval = setInterval(() => {
        const date = Date.now();
        this.percent = ((date - startDate) * 100) / (futureDate - startDate);
        if (this.percent >= 100) {
          clearInterval(this.interval);
          this.interval = null;
        }
      }, 30);
    },
  }));
  Alpine.data('liveSearchComponent', () => ({
    // State Variables
    searchTerm: '',
    results: [],
    showDropdown: false,

    // Fetch matching products from /api/products
    async fetchResults() {
      // If user cleared the input, hide dropdown
      if (!this.searchTerm) {
        this.results = []
        this.showDropdown = false
        return
      }

      this.showDropdown = true // Show dropdown while loading

      try {
        // e.g. GET /api/products?search=someKey
        const response = await axios.get('/api/products', {
          params: {
            search: this.searchTerm,
            per_page: 5,  // optionally limit results
          }
        })

        // The JSON returned is typically { data: [ { id, slug, title, price... }, ... ] }
        this.results = response.data.data || []
      } catch (error) {
        console.error('Search failed:', error)
      }
    },

    // Add to Cart => Calls /add/{product.slug} with POST

  }));
  Alpine.data("search-bar", () => ({
    isActive: false,
    search: "",

    open() {
      this.isActive = true;
      console.log("Search bar opened");
    },

    close() {
      this.isActive = false;
      console.log("Search bar closed");
    },

    clear() {
      this.search = "";
      console.log("Search bar cleared");
    },

    setup: {
      ["x-show"]() {
        return this.isActive;
      },
      ["@search-bar:open.window"]() {
        this.open();
      },
      ["@search-bar:close.window"]() {
        this.close();
      },
      ["@click.away"]() {
        this.close();
        console.log("Search bar clicked away");
      },
      [":class"]() {
        return {
          "translate-y-0 visible opacity-100": this.isActive,
          "-translate-y-full invisible opacity-0": !this.isActive
        };
      }
    }
  }));
  Alpine.data("productItem", (product) => {
    return {
      product,
      selectedSizeId: "",
      sizeWarningShown: false,
      showSizes: false,  // New property to control dropdown visibility

      get selectedSize() {
        if (!this.selectedSizeId || !Array.isArray(this.product.sizes)) {
          return null;
        }
        return this.product.sizes.find((sz) => sz.id == this.selectedSizeId) || null;
      },
      get displayedPrice() {
        if (this.selectedSize) {
          return parseFloat(this.selectedSize.price).toFixed(2);
        }
        return parseFloat(this.product.price).toFixed(2);
      },

      get displayedOriginalPrice() {
        if (this.selectedSize?.originalPrice && this.selectedSize.originalPrice > this.selectedSize.price) {
          return parseFloat(this.selectedSize.originalPrice).toFixed(2);
        }

        if (this.product.originalPrice && this.product.originalPrice > this.product.price) {
          return parseFloat(this.product.originalPrice).toFixed(2);
        }

        return null;
      },
      get minPrice() {
        return this.product.sizes.length
          ? Math.min(...this.product.sizes.map(s => parseFloat(s.price)))
          : parseFloat(this.product.price);
      },
      get maxPrice() {
        return this.product.sizes.length
          ? Math.max(...this.product.sizes.map(s => parseFloat(s.price)))
          : parseFloat(this.product.price);
      },

      get minOriginalPrice() {
        return this.product.sizes.length && this.product.sizes.some(s => s.originalPrice)
          ? Math.min(...this.product.sizes
            .filter(s => s.originalPrice && parseFloat(s.originalPrice) > 0)
            .map(s => parseFloat(s.originalPrice)))
          : parseFloat(this.product.original_price || 0);
      },
      get maxOriginalPrice() {
        return this.product.sizes.length && this.product.sizes.some(s => s.originalPrice)
          ? Math.max(...this.product.sizes
            .filter(s => s.originalPrice && parseFloat(s.originalPrice) > 0)
            .map(s => parseFloat(s.originalPrice)))
          : parseFloat(this.product.original_price || 0);
      },
      get hasOriginalPriceRange() {
        return this.product.sizes.length &&
          this.product.sizes.some(s => s.originalPrice && parseFloat(s.originalPrice) > parseFloat(s.price));
      },
      get averageDiscount() {
        if (!this.hasOriginalPriceRange) return 0;

        const sizesWithDiscount = this.product.sizes.filter(s =>
          s.originalPrice && parseFloat(s.originalPrice) > parseFloat(s.price)
        );

        if (sizesWithDiscount.length === 0) return 0;

        const totalDiscount = sizesWithDiscount.reduce((sum, s) =>
          sum + (1 - parseFloat(s.price) / parseFloat(s.originalPrice)), 0);

        return Math.round((totalDiscount / sizesWithDiscount.length) * 100);
      },

      addToCart(quantity = 1) {
        if (this.product.sizes && this.product.sizes.length > 0 && !this.selectedSize) {
          this.sizeWarningShown = true;
          return;
        }
        if (this.selectedSize && this.selectedSize.stock <= 0) {
          this.$dispatch('notify', {
            message: 'This size is out of stock.',
            type: 'error',
          });
          return;
        }
        let data = { quantity, size_id: this.selectedSizeId || null };
        if (this.selectedSize) {
          data.size_id = this.selectedSize.id;
        }
        post(this.product.addToCartUrl, data)
          .then((result) => {
            window.dispatchEvent(
              new CustomEvent("cart-change", {
                detail: { count: result.count },
              })
            );
            this.$dispatch("notify", {
              message: "The item was added into the cart",
            });
          })
          .catch(async (response) => {
            console.error("Caught error response:", response);

            let message = "Server Error. Please try again.";

            if (response instanceof Response) {
              try {
                const data = await response.json();  // <-- Parse JSON correctly
                message = data.message || message;
              } catch (e) {
                console.error("Failed to parse error response", e);
              }
            }

            this.$dispatch("notify", {
              message: message,
              type: "error",
            });
          });
      },

      removeItemFromCart() {
        // Include size_id for proper removal
        post(this.product.removeUrl, { size_id: this.product.size_id || null })
          .then((result) => {
            this.$dispatch("notify", {
              message: "The item was removed from cart",
            });
            this.$dispatch("cart-change", { count: result.count });
          });
      },

      changeQuantity() {
        // Include size_id so that the server can match the right cart item
        post(this.product.updateQuantityUrl, {
          quantity: this.product.quantity,
          size_id: this.product.size_id || null,
        })
          .then((result) => {
            this.$dispatch("cart-change", { count: result.count });
            this.$dispatch("notify", {
              message: "The item quantity was updated",
            });
          })
          .catch((response) => {
            this.$dispatch("notify", {
              message: response.message || "Server Error. Please try again.",
              type: "error",
            });
          });
      },
    };
  });
  Alpine.data("miniCart", (initialData) => {
    return {
      cartItems: initialData.items || [],
      cartTotal: initialData.total || '0.00',

      async refreshCart() {
        // Fetch new mini-cart data from the server
        try {
          const response = await fetch('/cart/mini'); // You need to create this route if not already
          const data = await response.json();

          this.cartItems = data.items || [];
          this.cartTotal = data.total || '0.00';
        } catch (error) {
          console.error('Failed to refresh mini-cart', error);
        }
      },

      init() {
        window.addEventListener('cart-change', async (event) => {
          await this.refreshCart();
        });
      }
    }
  });
  Alpine.data('scrollable', () => ({
    showLeftArrow: false,
    showRightArrow: false,

    init() {
      // Check arrows after Alpine initializes
      this.checkArrows();

      // Also check on window resize or load
      window.addEventListener('resize', this.checkArrows.bind(this));
      window.addEventListener('load', this.checkArrows.bind(this));
    },

    checkArrows() {
      // Defer measurements so elements are rendered
      this.$nextTick(() => {
        const container = this.$refs.scrollContainer;
        if (!container) return;

        const totalScrollWidth = container.scrollWidth;
        const visibleWidth = container.clientWidth;
        const scrollLeft = container.scrollLeft;

        // If total content <= container width => hide both arrows
        if (totalScrollWidth <= visibleWidth) {
          this.showLeftArrow = false;
          this.showRightArrow = false;
        } else {
          // Show left arrow if scrolled away from left
          this.showLeftArrow = (scrollLeft > 0);

          // Show right arrow if not yet at the right end
          this.showRightArrow = (scrollLeft + visibleWidth < totalScrollWidth - 1);
        }
      });
    },

    scroll(direction) {
      const container = this.$refs.scrollContainer;
      // Estimate one “card” width; adjust if you have different spacing
      const firstItem = container.querySelector('.snap-start');
      // e.g. 16 or 20 px is your space-x gap
      const gap = 20;

      const itemWidth = firstItem
        ? firstItem.offsetWidth + gap
        : 200; // fallback

      const currentScroll = container.scrollLeft;
      const newPosition = direction === 'left'
        ? Math.max(currentScroll - itemWidth, 0)
        : currentScroll + itemWidth;

      container.scrollTo({ left: newPosition, behavior: 'smooth' });
    },
  }));
});


Alpine.start();
