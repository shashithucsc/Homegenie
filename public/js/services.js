document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const serviceCards = document.querySelectorAll('.service-card');
    const categoryRadios = document.querySelectorAll('input[name="category"]');
    const ratingRadios = document.querySelectorAll('input[name="rating"]');
    const resetFilters = document.getElementById('resetFilters');

    function normalize(str) {
        return (str || '').toLowerCase();
    }

    function getSelectedRadioValue(radios) {
        for (const radio of radios) {
            if (radio.checked) return radio.value;
        }
        return '';
    }

    function filterServices() {
        const searchTerm = normalize(searchInput.value);
        const selectedCategory = getSelectedRadioValue(categoryRadios);
        const selectedRating = parseFloat(getSelectedRadioValue(ratingRadios)) || 0;

        serviceCards.forEach(card => {
            const name = normalize(card.querySelector('h3').textContent);
            const expertise = normalize(card.querySelector('.service-type').textContent);
            const description = normalize(card.querySelector('p').textContent);
            const rating = parseFloat(card.querySelector('.rating-number').textContent) || 0;

            // Search filter: matches name, expertise, or description
            const matchesSearch = !searchTerm ||
                name.includes(searchTerm) ||
                expertise.includes(searchTerm) ||
                description.includes(searchTerm);

            // Category filter
            const matchesCategory = !selectedCategory || expertise === normalize(selectedCategory);

            // Rating filter
            const matchesRating = rating >= selectedRating;

            if (matchesSearch && matchesCategory && matchesRating) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterServices);
    clearSearch.addEventListener('click', function () {
        searchInput.value = '';
        filterServices();
    });
    categoryRadios.forEach(radio => radio.addEventListener('change', filterServices));
    ratingRadios.forEach(radio => radio.addEventListener('change', filterServices));
    resetFilters.addEventListener('click', function () {
        // Reset all filters
        document.querySelector('input[name="category"][value=""]').checked = true;
        document.querySelector('input[name="rating"][value=""]').checked = true;
        searchInput.value = '';
        filterServices();
    });

    // Initial filter on page load
    filterServices();
});