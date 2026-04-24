/**
 * showSection(sectionID)
 * Hides all sections (including home) and shows only the target section.
 * Called by nav buttons: Create, Read, Update, Delete.
 */
function showSection(sectionID) {
    // Hide all .content sections
    const sections = document.querySelectorAll('.content');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    // Hide the home section
    const homeSection = document.getElementById('home');
    if (homeSection) homeSection.style.display = 'none';

    // Show the requested section
    const activeSection = document.getElementById(sectionID);
    if (activeSection) {
        activeSection.style.display = 'block';
    }
}

/**
 * hideSections()
 * Called when the logo is clicked — hides all .content sections
 * and brings back the home section.
 */
function hideSections() {
    const sections = document.querySelectorAll('.content');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    const homeSection = document.getElementById('home');
    if (homeSection) homeSection.style.display = 'block';
}

// ===== CLEAR FIELDS (Create section) =====
document.addEventListener('DOMContentLoaded', function () {
    const clrBtn = document.getElementById('clrbtn');
    if (clrBtn) {
        clrBtn.addEventListener('click', function () {
            // Clear all text and number inputs inside #create section
            const inputs = document.querySelectorAll('#create input[type="text"], #create input[type="number"]');
            inputs.forEach(input => {
                input.value = '';
            });
        });
    }
});

// ===== TOAST NOTIFICATIONS =====
window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status    = urlParams.get('status');
    const section   = urlParams.get('section');

    let toastMessage  = null;
    let toastColor    = '#4CAF50'; // default: green (success)

    if (status === 'success') {
        toastMessage = '✅ Registration Successful!';
    } else if (status === 'updated') {
        toastMessage = '✅ Student Updated Successfully!';
        toastColor   = '#f39c12';
    } else if (status === 'deleted') {
        toastMessage = '🗑️ Student Deleted Successfully!';
        toastColor   = '#e74c3c';
    } else if (status === 'error') {
        toastMessage = '❌ An error occurred. Please try again.';
        toastColor   = '#e74c3c';
    }

    if (toastMessage) {
        const toast = document.getElementById('global-toast');
        toast.textContent    = toastMessage;
        toast.style.backgroundColor = toastColor;
        toast.classList.remove('toast-hidden');
        toast.style.opacity  = '1';
        toast.style.display  = 'block';

        // Auto-hide after 3 seconds
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.classList.add('toast-hidden');
                toast.style.display = 'none';
            }, 500);
        }, 3000);

        // Clean the URL — remove status param but keep section param so the right tab stays open
        const cleanUrl = window.location.pathname + (section ? '?section=' + section : '');
        window.history.replaceState({}, document.title, cleanUrl);
    }
};