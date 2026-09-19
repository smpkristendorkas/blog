// Admin Panel JavaScript - API Integration

const API_URL = 'api.php';

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
            
            // Load data for specific sections
            if (sectionId === 'dashboard') {
                loadStats();
            } else if (sectionId === 'posts') {
                loadPosts();
            } else if (sectionId === 'media') {
                loadMedia();
            }
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

// ============== API FUNCTIONS ==============

// Load Statistics
function loadStats() {
    fetch(`${API_URL}?action=get_stats`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('post-count').textContent = data.data.posts;
                document.getElementById('visitor-count').textContent = data.data.visitors.toLocaleString();
                document.getElementById('comment-count').textContent = data.data.comments;
                document.getElementById('media-count').textContent = data.data.media;
            }
        })
        .catch(error => console.error('Error loading stats:', error));
}

// Load Posts
function loadPosts() {
    fetch(`${API_URL}?action=get_posts`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.getElementById('post-table-body');
                tbody.innerHTML = '';
                
                if (data.data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #7f8c8d;">Tidak ada posting</td></tr>';
                    return;
                }
                
                data.data.forEach(post => {
                    const statusColor = post.status === 'Dipublikasikan' ? '#27ae60' : '#f39c12';
                    const row = `
                        <tr>
                            <td>${post.title}</td>
                            <td>${post.author}</td>
                            <td>${post.created_date}</td>
                            <td><span style="background-color: ${statusColor}; color: white; padding: 5px 10px; border-radius: 3px;">${post.status}</span></td>
                            <td>
                                <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;" onclick="editPost(${post.id})">Edit</button>
                                <button class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="deletePost(${post.id})">Hapus</button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }
        })
        .catch(error => console.error('Error loading posts:', error));
}

// Add Post
function addPost(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const postData = {
        title: formData.get('title'),
        category: formData.get('category'),
        content: formData.get('content'),
        tags: formData.get('tags'),
        status: formData.get('status')
    };
    
    fetch(`${API_URL}?action=add_post`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(postData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Posting berhasil ditambahkan!', 'success');
            hideForm('postForm');
            loadPosts();
            event.target.reset();
        } else {
            showAlert(data.message || 'Gagal menambahkan posting', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error: ' + error.message, 'error');
    });
}

// Delete Post
function deletePost(postId) {
    if (!confirm('Apakah Anda yakin ingin menghapus posting ini?')) return;
    
    fetch(`${API_URL}?action=delete_post`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id: postId})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Posting berhasil dihapus!', 'success');
            loadPosts();
        } else {
            showAlert(data.message || 'Gagal menghapus posting', 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Edit Post (placeholder)
function editPost(postId) {
    alert('Fitur edit posting akan segera hadir!');
}

// Load Media
function loadMedia() {
    fetch(`${API_URL}?action=get_media`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const gallery = document.getElementById('media-gallery');
                gallery.innerHTML = '';
                
                if (data.data.length === 0) {
                    gallery.innerHTML = '<p style="color: #7f8c8d;">Belum ada media yang diupload</p>';
                    return;
                }
                
                data.data.forEach(media => {
                    const mediaItem = `
                        <div style="background-color: white; padding: 10px; border-radius: 8px; text-align: center;">
                            <div style="width: 100%; height: 150px; background-color: #ecf0f1; border-radius: 5px; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <img src="${media.file_path}" style="max-width: 100%; max-height: 100%; object-fit: cover;" alt="${media.filename}">
                            </div>
                            <small>${media.filename}</small>
                            <div style="margin-top: 10px;">
                                <button class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;" onclick="deleteMedia(${media.id})">Hapus</button>
                            </div>
                        </div>
                    `;
                    gallery.innerHTML += mediaItem;
                });
            }
        })
        .catch(error => console.error('Error loading media:', error));
}

// Upload Media
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const files = e.target.files;
            
            Array.from(files).forEach(file => {
                const formData = new FormData();
                formData.append('file', file);
                
                fetch(`${API_URL}?action=upload_media`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('File berhasil diupload!', 'success');
                        loadMedia();
                    } else {
                        showAlert(data.message || 'Gagal upload file', 'error');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
            
            // Reset input
            fileInput.value = '';
        });
    }
});

// Delete Media
function deleteMedia(mediaId) {
    if (!confirm('Apakah Anda yakin ingin menghapus media ini?')) return;
    
    fetch(`${API_URL}?action=delete_media`, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id: mediaId})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('Media berhasil dihapus!', 'success');
            loadMedia();
        } else {
            showAlert(data.message || 'Gagal menghapus media', 'error');
        }
    })
    .catch(error => console.error('Error:', error));
}

// Handle form submissions
document.addEventListener('DOMContentLoaded', function() {
    // Add post form
    const postForm = document.getElementById('addPostForm');
    if (postForm) {
        postForm.addEventListener('submit', addPost);
    }

    // Appearance form
    const appearanceForm = document.getElementById('appearanceForm');
    if (appearanceForm) {
        appearanceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const settings = {};
            formData.forEach((value, key) => {
                settings[key] = value;
            });
            
            fetch(`${API_URL}?action=update_settings`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(settings)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Penampilan berhasil diperbarui!', 'success');
                } else {
                    showAlert(data.message || 'Gagal memperbarui', 'error');
                }
            });
        });
    }

    // Settings form
    const settingsForm = document.getElementById('settingsForm');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const settings = {};
            formData.forEach((value, key) => {
                settings[key] = value === 'on' ? '1' : value;
            });
            
            fetch(`${API_URL}?action=update_settings`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(settings)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Pengaturan berhasil disimpan!', 'success');
                } else {
                    showAlert(data.message || 'Gagal menyimpan', 'error');
                }
            });
        });
    }

    // Handle logout
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                localStorage.removeItem('adminSession');
                window.location.href = 'index.html';
            }
        });
    }

    // Load dashboard stats on page load
    loadStats();
});

// ============== UTILITY FUNCTIONS ==============

// Show alerts
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const contentDiv = document.querySelector('.content');
    contentDiv.insertBefore(alertDiv, contentDiv.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

