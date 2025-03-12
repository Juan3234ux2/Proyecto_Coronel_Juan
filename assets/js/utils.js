export const parseCurrency = function(currencyString) {
    if (!currencyString) return 0;
    return parseFloat(currencyString.replace('$', '').replace(/\./g, '').replace(',', '.').replace('&nbsp;', ''));
};

export const toggleDropdown = (idContainer) => {
    const container = document.getElementById(idContainer);
    if (!container) return;

    if (container.classList.contains('d-none')) {
        container.style.display = 'flex';
        container.style.maxHeight = '0';
        container.style.opacity = '0';
        container.style.overflow = 'hidden';
        container.style.transition = 'max-height 0.3s ease-in-out, opacity 0.3s ease-in-out';
        container.classList.remove('d-none');

        const altura = container.scrollHeight;
        setTimeout(() => {
            container.style.maxHeight = altura + 'px';
            container.style.opacity = '1';

            setTimeout(() => {
                container.style.maxHeight = '';
                container.style.overflow = '';
            }, 300);
        }, 10);
    } else {
        const altura = container.scrollHeight;
        container.style.maxHeight = altura + 'px';
        container.style.overflow = 'hidden';
        container.style.transition = 'max-height 0.4s ease-in-out, opacity 0.3s ease-in-out';
        void container.offsetHeight;
        container.style.maxHeight = '0';
        container.style.opacity = '0';

        setTimeout(() => {
            container.classList.add('d-none');
            container.style.display = '';
            container.style.maxHeight = '';
            container.style.opacity = '';
            container.style.overflow = '';
        }, 400);
    }
};