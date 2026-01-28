document.addEventListener('DOMContentLoaded', () => {

    // 1. Counter Animation for Stats
    const counters = document.querySelectorAll('.stat-card .value');
    counters.forEach(counter => {
        // Only run if it's a number
        const originalText = counter.innerText;
        const target = parseInt(originalText.replace(/[^0-9]/g, ''));

        if (!isNaN(target) && target > 0) {
            const duration = 1500; // ms
            const frameDuration = 1000 / 60; // 60fps
            const totalFrames = Math.round(duration / frameDuration);
            const easeOutQuad = t => t * (2 - t);

            let frame = 0;
            const counterAnimate = () => {
                frame++;
                const progress = easeOutQuad(frame / totalFrames);
                const currentCount = Math.round(target * progress);

                if (frame < totalFrames) {
                    counter.innerText = currentCount;
                    requestAnimationFrame(counterAnimate);
                } else {
                    counter.innerText = originalText;
                }
            };
            counterAnimate();
        }
    });

    // 2. 3D Tilt Effect removed due to blurring issues
    // Cards will just have a simple lift on hover via CSS

    // 3. Staggered Entry for Table Rows
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.transition = 'all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 100 * index);
    });

    console.log('Admin JS Loaded - Motion Effects Active');
});
