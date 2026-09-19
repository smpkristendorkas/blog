// Admin Panel JavaScript

// Navigation
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all links
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        
        // Add active class to clicked link
        this.classList.add('active');
        
        // Hide all sections
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        
        // Show selected section
        const sectionId = this.getAttribute('data-section');
        const section = document.getElementById(sectionId);
        if (section) {
            section.classList.add('active');
            
            // Update page title
            const titles = {
                'dashboard': '📈 Dashboard',
                'posts': '📝 Posting',
                'media': '🖼️ Foto & Media',
                'appearance': '🎨 Penampilan',
                'widgets': '🧩 Widget',
                'menu': '📋 Menu',
                'users': '👥 Pengguna',
                'settings': '⚙️ Pengaturan',
                'seo': '🔍 SEO',
                'backup': '💾 Backup'
            };
            
            document.getElementById('page-title').textContent = titles[sectionId] || sectionId;
        }
    });
});

// Show/Hide Forms
function showForm(formId) {
    document.getElementById(formId).style.display = 'block';
}

function hideForm(formId) {
    document.getElementById(formId).style.display = 'none';
}

// Tab Switching
function switchTab(e, tabId) {
    e.preventDefault();
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    
    // Add active class to clicked tab and corresponding content
    e.target.classList.add('active');
    document.getElementById(tabId).classList.add('active');
}

// Handle logout
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                alert('Anda telah logout. Redirecting...');
                // Uncomment untuk redirect ke halaman login/home
                // window.location.href = 'index.html';
            }
        });
    }

    // Form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Data berhasil disimpan!');
            // Reset form
            this.reset();
            // Hide form jika ada
            const formContainer = this.parentElement;
            if (formContainer.id.includes('Form')) {
                formContainer.style.display = 'none';
            }
        });
    });
});
