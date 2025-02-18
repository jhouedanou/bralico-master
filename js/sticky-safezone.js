document.addEventListener('DOMContentLoaded', function() {
    // Vérifie si on est sur la bonne page
    if (document.body.classList.contains('page-id-290')) {
        const safezone = document.querySelector('.safezone');
        
        if (safezone) {
            // Position initiale du safezone
            const originalOffset = safezone.offsetTop;
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > originalOffset) {
                    safezone.style.position = 'fixed';
                    safezone.style.top = '0';
                    safezone.style.width = '100%';
                    safezone.style.zIndex = '1000';
                } else {
                    safezone.style.position = 'relative';
                }
            });
        }
    }
});
