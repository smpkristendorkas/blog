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
