<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const minThumb = document.getElementById('min-thumb');
        const maxThumb = document.getElementById('max-thumb');
        const activeTrack = document.getElementById('active-track');
        const sliderTrack = document.getElementById('slider-track');
        const minPriceInput = document.getElementById('min_price_input');
        const maxPriceInput = document.getElementById('max_price_input');
        const minPriceHidden = document.getElementById('min_price');
        const maxPriceHidden = document.getElementById('max_price');
        const displayMinPrice = document.getElementById('display-min-price');
        const displayMaxPrice = document.getElementById('display-max-price');
        const form = document.getElementById('price-filter-form');

        // Price range values
        const globalMin = parseInt(minPriceInput.min);
        const globalMax = parseInt(maxPriceInput.max);
        const range = globalMax - globalMin;

        // Slider state
        let minValue = parseInt(minPriceInput.value);
        let maxValue = parseInt(maxPriceInput.value);
        let activeThumb = null;
        let isDragging = false;

        // Debounce function to delay form submission
        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }

        // Submit form with delay
        const submitForm = debounce(function() {
            form.submit();
        }, 500);

        // Update thumb positions and track
        function updateSlider() {
            // Calculate positions as percentages
            const minPos = ((minValue - globalMin) / range) * 100;
            const maxPos = ((maxValue - globalMin) / range) * 100;

            // Update visual elements
            minThumb.style.left = `${minPos}%`;
            maxThumb.style.left = `${maxPos}%`;
            activeTrack.style.left = `${minPos}%`;
            activeTrack.style.width = `${maxPos - minPos}%`;

            // Update display values
            displayMinPrice.textContent = minValue;
            displayMaxPrice.textContent = maxValue;

            // Update input fields
            minPriceInput.value = minValue;
            maxPriceInput.value = maxValue;

            // Update hidden form fields
            minPriceHidden.value = minValue;
            maxPriceHidden.value = maxValue;
        }

        // Calculate price from slider position
        function calculatePrice(posX) {
            const trackRect = sliderTrack.getBoundingClientRect();
            const percentage = (posX - trackRect.left) / trackRect.width;
            return Math.round(percentage * range + globalMin);
        }

        // Handle thumb movement
        function moveThumb(e) {
            if (!isDragging || !activeThumb) return;

            const price = calculatePrice(e.clientX);

            if (activeThumb === minThumb) {
                // Min thumb constraints
                minValue = Math.max(globalMin, Math.min(price, maxValue - 1));
            } else {
                // Max thumb constraints
                maxValue = Math.min(globalMax, Math.max(price, minValue + 1));
            }

            updateSlider();
        }

        // Start dragging
        function startDrag(e, thumb) {
            isDragging = true;
            activeThumb = thumb;
            document.addEventListener('mousemove', moveThumb);
            document.addEventListener('mouseup', stopDrag);
            e.preventDefault(); // Prevent text selection
        }

        // Stop dragging
        function stopDrag() {
            if (isDragging) {
                isDragging = false;
                activeThumb = null;
                document.removeEventListener('mousemove', moveThumb);
                document.removeEventListener('mouseup', stopDrag);
                submitForm();
            }
        }

        // Initialize slider
        updateSlider();

        // Event listeners for thumbs
        minThumb.addEventListener('mousedown', (e) => startDrag(e, minThumb));
        maxThumb.addEventListener('mousedown', (e) => startDrag(e, maxThumb));

        // Handle input field changes
        minPriceInput.addEventListener('change', function() {
            const newMin = parseInt(minPriceInput.value);
            if (isNaN(newMin)) return;

            minValue = Math.max(globalMin, Math.min(newMin, maxValue - 1));
            minPriceInput.value = minValue;
            updateSlider();
            submitForm();
        });

        maxPriceInput.addEventListener('change', function() {
            const newMax = parseInt(maxPriceInput.value);
            if (isNaN(newMax)) return;

            maxValue = Math.min(globalMax, Math.max(newMax, minValue + 1));
            maxPriceInput.value = maxValue;
            updateSlider();
            submitForm();
        });

        // Prevent clicking on track from moving thumbs directly
        sliderTrack.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
