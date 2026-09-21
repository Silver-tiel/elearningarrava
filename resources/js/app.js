import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-toggle-password]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.togglePassword);
            if (!input) return;

            const showing = input.type === 'text';
            input.type = showing ? 'password' : 'text';
            button.setAttribute('aria-label', showing ? 'Tampilkan kata sandi' : 'Sembunyikan kata sandi');
        });
    });

    const roleTabs = document.querySelectorAll('[data-role-tab]');
    roleTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            roleTabs.forEach((item) => {
                item.classList.remove('bg-white', 'text-[#3F82F6]', 'shadow-[0_1px_4px_rgba(30,70,120,0.08)]');
                item.classList.add('text-[#53647D]');
            });

            tab.classList.remove('text-[#53647D]');
            tab.classList.add('bg-white', 'text-[#3F82F6]', 'shadow-[0_1px_4px_rgba(30,70,120,0.08)]');
        });
    });
});
