jQuery(document).ready(function () {
    const canvas = document.getElementById('the-retail-storefront-notice-confetti');
    if (canvas && typeof confetti === 'function') {
        const The_Retail_Storefront_Confetti = confetti.create(canvas, {
            resize: true
        });

        setTimeout(function () {
            The_Retail_Storefront_Confetti({
                particleCount: 500,  // Increased particle count
                origin: { x: 1, y: 2 },
                gravity: 0.4,        // Adjust gravity to control the speed of particles
                spread: 100,         // Increased spread
                ticks: 180,          // Lengthened the duration
                angle: 120,          // Adjusted angle for varied effect
                startVelocity: 80,   // Increased start velocity for faster confetti
                colors: ['#0e6ef1', '#f5b800', '#ff344c', '#98e027', '#9900f1', '#ff6347', '#8e44ad'],
                particleSize: 4,     // Adjusted particle size
                scalar: 1,         // Adjust the size of the confetti to appear bigger
                shapes: ['square', 'circle'],  // Added different shapes to diversify the look
            });
        }, 300);

        setTimeout(function () {
            The_Retail_Storefront_Confetti({
                particleCount: 500,  // Increased particle count
                origin: { x: 0, y: 2 },
                gravity: 0.4,        // Adjust gravity to control the speed of particles
                spread: 100,         // Increased spread
                ticks: 200,          // Lengthened the duration
                angle: 60,           // Adjusted angle for varied effect
                startVelocity: 80,   // Increased start velocity for faster confetti
                colors: ['#0e6ef1', '#f5b800', '#ff344c', '#98e027', '#9900f1', '#ff6347', '#8e44ad'],
                particleSize: 4,     // Adjusted particle size
                scalar: 1,         // Adjust the size of the confetti to appear bigger
                shapes: ['square', 'circle'],  // Added different shapes to diversify the look
            });
        }, 600);
    }
});