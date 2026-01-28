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
                    counter.innerText = originalText; // Restore original formatting if needed
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
        row.style.transform = 'translateX(-10px)';
        row.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)'; // Bouncy effect

        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 50 * index); // 50ms delay per row
    });

    // 4. Sidebar Link Active Tick
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            const icon = link.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.2) rotate(5deg)';
                icon.style.transition = 'transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            }
        });
        link.addEventListener('mouseleave', () => {
            const icon = link.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });
});
