document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('stateFilter');
    if (select) {
        new Choices(select, {
            searchEnabled: true,
            itemSelectText: '',
            shouldSort: false,
        });
    }

    const cards = document.querySelectorAll('.provider-card');
    select.addEventListener('change', function () {
        const selected = this.value.toLowerCase();
        cards.forEach(card => {
            const tags = card.dataset.tags.toLowerCase();
            const show = !selected || tags.includes(selected);
            card.style.display = show ? 'block' : 'none';
        });
    });
});
