// Menu toggle for responsive nav (works for multiple header instances)
document.querySelectorAll('[id^="menuToggle"]').forEach(btn=>{
	btn.addEventListener('click',()=>{
		const nav = btn.nextElementSibling || document.getElementById(btn.getAttribute('data-target')) || btn.parentElement.querySelector('.nav');
		if(!nav) return;
		nav.style.display = (nav.style.display==='flex' || nav.style.display==='') ? 'none' : 'flex';
		if(nav.style.display==='flex') nav.style.flexDirection='column';
	});
});

// Simple hero slider
;(function(){
	const slider = document.getElementById('heroSlider');
	if(!slider) return;
	const slides = Array.from(slider.querySelectorAll('.slide'));
	const prev = slider.querySelector('.slider-prev');
	const next = slider.querySelector('.slider-next');
	const dotsWrap = document.getElementById('heroDots');
	let current = 0;
	let interval = null;
	const delay = 5000;

	const dots = slides.map((s,i)=>{
		const b = document.createElement('button');
		b.addEventListener('click',()=>goTo(i));
		dotsWrap.appendChild(b);
		return b;
	});

	function update(){
		slides.forEach((s,i)=> s.classList.toggle('active', i===current));
		dots.forEach((d,i)=> d.classList.toggle('active', i===current));
	}

	function goTo(i){ current = (i + slides.length) % slides.length; update(); }
	function nextSlide(){ goTo(current+1); }
	function prevSlide(){ goTo(current-1); }
	function start(){ stop(); interval = setInterval(nextSlide, delay); }
	function stop(){ if(interval) clearInterval(interval); interval = null; }

	if(next) next.addEventListener('click', ()=>{ nextSlide(); start(); });
	if(prev) prev.addEventListener('click', ()=>{ prevSlide(); start(); });

	slider.addEventListener('mouseenter', stop);
	slider.addEventListener('mouseleave', start);

	update(); start();
})();
// ============== Load Posts from Database ==============

const BLOG_API = 'blog-api.php';

// Load recent posts
function loadRecentPosts() {
	fetch(`${BLOG_API}?action=get_posts&limit=6`)
		.then(response => response.json())
		.then(data => {
			if (data.success && data.data.length > 0) {
				const newsSection = document.querySelector('.news .cards');
				if (newsSection) {
					newsSection.innerHTML = '';
					data.data.forEach(post => {
						const excerpt = post.content.substring(0, 100) + '...';
						const card = document.createElement('article');
						card.className = 'card';
						card.innerHTML = `
							<img src="https://picsum.photos/seed/${post.id}/400/240" alt="${post.title}">
							<h3>${post.title}</h3>
							<p>${excerpt}</p>
							<a class="read-more" href="single.html?id=${post.id}">Baca selengkapnya →</a>
						`;
						newsSection.appendChild(card);
					});
				}
			}
		})
		.catch(error => console.error('Error loading posts:', error));
}

// Load single post
function loadSinglePost() {
	const params = new URLSearchParams(window.location.search);
	const postId = params.get('id');
	
	if (postId) {
		fetch(`${BLOG_API}?action=get_post&id=${postId}`)
			.then(response => response.json())
			.then(data => {
				if (data.success && data.data) {
					const post = data.data;
					const container = document.querySelector('main') || document.body;
					container.innerHTML = `
						<section class="single-post container">
							<article>
								<h1>${post.title}</h1>
								<div class="post-meta">
									<span>Oleh <strong>${post.author}</strong></span> | 
									<span>${post.created_date}</span> |
									<span>Kategori: <strong>${post.category}</strong></span>
								</div>
								<div class="post-content">
									${post.content}
								</div>
								<div class="post-tags">
									${post.tags.split(',').map(tag => `<span class="tag">${tag.trim()}</span>`).join('')}
								</div>
								<a href="news.html" class="read-more">← Kembali ke Berita</a>
							</article>
						</section>
					`;
				}
			})
			.catch(error => console.error('Error loading post:', error));
	}
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
	// Load posts if we're on the homepage or news page
	if (window.location.pathname.includes('index.html') || window.location.pathname === '/Blog/' || window.location.pathname === '/Blog/index.html') {
		loadRecentPosts();
	}
	
	// Load single post if we have an id parameter
	if (window.location.pathname.includes('single.html')) {
		loadSinglePost();
	}
});