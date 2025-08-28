// AJAX функції
async function fetchData(url, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    };
    
    if (data) {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(url, options);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Error fetching data:', error);
        return { success: false, error: error.message };
    }
}

// Обробник для адмін-форм
document.addEventListener('DOMContentLoaded', function() {
    // Асинхронне видалення елементів
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!confirm('Ви впевнені, що хочете видалити цей елемент?')) {
                return;
            }
            
            const formData = new FormData(this);
            const response = await fetchData(this.action, 'POST', Object.fromEntries(formData));
            
            if (response.success) {
                alert('Елемент успішно видалено!');
                this.closest('.card').remove();
            } else {
                alert('Помилка при видаленні: ' + (response.error || 'Невідома помилка'));
            }
        });
    });
    
    // Прев'ю завантаження зображень
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const preview = this.closest('form').querySelector('.image-preview');
            if (!preview) return;
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 200px;">`;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // Таби в адмінці
    document.querySelectorAll('.admin-tabs a').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.querySelectorAll('.admin-tabs a').forEach(t => {
                t.classList.remove('active');
            });
            
            document.querySelectorAll('.tab-content').forEach(content => {
                content.style.display = 'none';
            });
            
            this.classList.add('active');
            document.querySelector(this.getAttribute('href')).style.display = 'block';
        });
    });
    
    // Ініціалізація першого таба
    if (document.querySelector('.admin-tabs a')) {
        document.querySelector('.admin-tabs a').click();
    }
});

// Модальні вікна
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Закриття модального вікна при кліку на поза ним
window.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
        e.target.style.display = 'none';
    }
    // Обробник для галереї з lightbox
document.addEventListener('DOMContentLoaded', function() {
    // Lightbox для галереї
    const galleryItems = document.querySelectorAll('.gallery-item');
    if (galleryItems.length > 0) {
        galleryItems.forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.tagName !== 'A') {
                    const imgSrc = this.querySelector('img').src;
                    const imgAlt = this.querySelector('img').alt;
                    
                    const lightbox = document.createElement('div');
                    lightbox.className = 'lightbox';
                    lightbox.innerHTML = `
                        <div class="lightbox-content">
                            <img src="${imgSrc}" alt="${imgAlt}">
                            <button class="lightbox-close">&times;</button>
                        </div>
                    `;
                    
                    document.body.appendChild(lightbox);
                    
                    lightbox.querySelector('.lightbox-close').addEventListener('click', function() {
                        lightbox.remove();
                    });
                    
                    lightbox.addEventListener('click', function(e) {
                        if (e.target === this) {
                            this.remove();
                        }
                    });
                }
            });
        });
    }
    
    // AJAX пошук експонатів
    const searchForm = document.querySelector('.exhibit-search');
    if (searchForm) {
        searchForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const query = formData.get('query');
            
            try {
                const response = await fetchData(`api/search_exhibits.php?query=${encodeURIComponent(query)}`);
                
                if (response.success && response.data.length > 0) {
                    const resultsContainer = document.querySelector('.exhibit-results');
                    resultsContainer.innerHTML = '';
                    
                    response.data.forEach(exhibit => {
                        const exhibitCard = document.createElement('div');
                        exhibitCard.className = 'card';
                        exhibitCard.innerHTML = `
                            <img src="${exhibit.image}" alt="${exhibit.title}">
                            <div class="card-content">
                                <h3>${exhibit.title}</h3>
                                <p>${exhibit.description}</p>
                                <a href="index.php?page=exhibit&id=${exhibit.id}" class="btn">Детальніше</a>
                            </div>
                        `;
                        resultsContainer.appendChild(exhibitCard);
                    });
                } else {
                    alert('Нічого не знайдено');
                }
            } catch (error) {
                console.error('Search error:', error);
                alert('Помилка пошуку');
            }
        });
    }
    
    // Динамічне завантаження коментарів
    const commentsSection = document.querySelector('.comments-section');
    if (commentsSection) {
        const exhibitId = commentsSection.dataset.exhibitId;
        
        async function loadComments() {
            try {
                const response = await fetchData(`api/get_comments.php?exhibit_id=${exhibitId}`);
                
                if (response.success) {
                    const commentsList = commentsSection.querySelector('.comments-list');
                    commentsList.innerHTML = '';
                    
                    if (response.data.length > 0) {
                        response.data.forEach(comment => {
                            const commentElement = document.createElement('div');
                            commentElement.className = 'comment';
                            commentElement.innerHTML = `
                                <div class="comment-header">
                                    <strong>${comment.username}</strong>
                                    <span>${comment.created_at}</span>
                                </div>
                                <div class="comment-content">${comment.content}</div>
                            `;
                            commentsList.appendChild(commentElement);
                        });
                    } else {
                        commentsList.innerHTML = '<p>Ще немає коментарів. Будьте першим!</p>';
                    }
                }
            } catch (error) {
                console.error('Error loading comments:', error);
            }
        }
        
        loadComments();
        
        // Додавання нового коментаря
        const commentForm = commentsSection.querySelector('.comment-form');
        if (commentForm) {
            commentForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('exhibit_id', exhibitId);
                
                try {
                    const response = await fetchData('api/add_comment.php', 'POST', Object.fromEntries(formData));
                    
                    if (response.success) {
                        this.reset();
                        loadComments();
                    } else {
                        alert(response.error || 'Помилка додавання коментаря');
                    }
                } catch (error) {
                    console.error('Error adding comment:', error);
                    alert('Помилка додавання коментаря');
                }
            });
        }
    }
});

// Додаткові стилі для lightbox
const lightboxStyle = document.createElement('style');
lightboxStyle.textContent = `
.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
}
.lightbox-content img {
    max-width: 100%;
    max-height: 90vh;
    display: block;
}
.lightbox-close {
    position: absolute;
    top: -40px;
    right: 0;
    background: none;
    border: none;
    color: white;
    font-size: 30px;
    cursor: pointer;
}
`;
document.head.appendChild(lightboxStyle);
});