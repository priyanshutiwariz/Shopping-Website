// TechStore JavaScript - Modern UI Interactions

document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        const currentTheme = localStorage.getItem('theme') || 'dark';
        document.documentElement.setAttribute('data-theme', currentTheme);
        themeToggle.textContent = currentTheme === 'dark' ? '🌙' : '☀️';

        themeToggle.addEventListener('click', function() {
            const newTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            this.textContent = newTheme === 'dark' ? '🌙' : '☀️';
            showToast(`Switched to ${newTheme} mode`);
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Form validation
    function validateRegister(form) {
        if (form.password.value.length < 6) {
            showToast('Password must be at least 6 characters', 'error');
            return false;
        }
        if (form.password.value !== form.confirm.value) {
            showToast('Passwords do not match', 'error');
            return false;
        }
        return true;
    }

    function validateLogin(form) {
        return true;
    }

    // Attach validation to forms
    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            if (!validateRegister(this)) {
                e.preventDefault();
            }
        });
    }

    // Highlight inputs on focus
    document.querySelectorAll('input, textarea').forEach(el => {
        el.addEventListener('focus', function() {
            this.style.outline = '2px solid rgba(125, 211, 252, 0.25)';
        });
        el.addEventListener('blur', function() {
            this.style.outline = '';
        });
    });

    // Add to cart with toast
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showLoader();
            // Simulate async add to cart
            setTimeout(() => {
                hideLoader();
                showToast('Item added to cart!', 'success');
                // In a real app, you'd submit the form or use AJAX
                this.submit();
            }, 500);
        });
    });

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card, .cart-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});

// Toast notifications
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#7ee787' : type === 'error' ? '#ff7b7b' : '#7dd3fc'};
        color: ${type === 'success' ? '#052' : 'white'};
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        font-weight: 600;
        animation: slideIn 0.3s ease;
    `;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Loader
function showLoader() {
    let loader = document.querySelector('.loader');
    if (!loader) {
        loader = document.createElement('div');
        loader.className = 'loader';
        loader.innerHTML = '<div class="spinner"></div>';
        document.body.appendChild(loader);
    }
    loader.classList.add('show');
}

function hideLoader() {
    const loader = document.querySelector('.loader');
    if (loader) {
        loader.classList.remove('show');
    }
}

// CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
