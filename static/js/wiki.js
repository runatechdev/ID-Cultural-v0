document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const allCards = document.querySelectorAll('.card');
    const allCategories = document.querySelectorAll('.categoria');
    const noResultsMessage = document.getElementById('no-results');

    function filterArtists() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value;
        let visibleCards = 0;

        // Itera sobre cada categoría (Música, Literatura, etc.)
        allCategories.forEach(categoryDiv => {
            let categoryHasVisibleCards = false;
            const categoryName = categoryDiv.getAttribute('data-category');

            // Itera sobre cada tarjeta de artista dentro de la categoría
            categoryDiv.querySelectorAll('.card').forEach(card => {
                const artistName = card.getAttribute('data-nombre');
                
                const matchesCategory = selectedCategory === "" || categoryName === selectedCategory;
                const matchesSearch = artistName.includes(searchTerm);

                // La tarjeta se muestra si coincide con la categoría Y con la búsqueda
                if (matchesCategory && matchesSearch) {
                    card.style.display = 'block';
                    categoryHasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Si una categoría tiene tarjetas visibles, se muestra el título de la categoría
            if (categoryHasVisibleCards) {
                categoryDiv.style.display = 'block';
                visibleCards += categoryDiv.querySelectorAll('.card[style*="block"]').length;
            } else {
                categoryDiv.style.display = 'none';
            }
        });
        
        // Muestra u oculta el mensaje de "No hay resultados"
        noResultsMessage.hidden = visibleCards > 0;
    }

    // Añade los "escuchadores" de eventos para que el filtro se active al escribir o seleccionar
    searchInput.addEventListener('input', filterArtists);
    categoryFilter.addEventListener('change', filterArtists);
});