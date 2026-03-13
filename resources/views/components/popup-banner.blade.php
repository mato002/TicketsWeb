<!-- Popup Banner Component -->
<div id="popup-banner" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm" onclick="closePopupBanner()"></div>
    
    <!-- Banner Container -->
    <div class="fixed left-0 bottom-0 transform transition-all duration-300 translate-x-full" id="popup-content">
        <!-- Close Button -->
        <button onclick="closePopupBanner()" 
                class="absolute -top-4 right-4 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100 transition-colors z-20">
            <i class="fas fa-times text-gray-600 text-sm"></i>
        </button>
        
        <!-- Banner Content -->
        <div class="bg-white rounded-t-2xl shadow-2xl overflow-hidden max-w-sm">
            <!-- Banner Header -->
            <div class="relative h-24 bg-gradient-to-r from-purple-600 to-blue-600">
                <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Special Offer" class="w-full h-full object-cover mix-blend-overlay">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                <div class="absolute top-2 left-3">
                    <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                        LIMITED TIME
                    </span>
                </div>
                <div class="absolute bottom-2 left-3 right-3">
                    <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-lg px-2 py-1">
                        <div class="text-sm font-black text-gray-900">
                            <span class="text-orange-500 font-bold">25% OFF</span>
                        </div>
                        <div class="text-xs text-gray-600">This Weekend Only!</div>
                    </div>
                </div>
            </div>
            
            <!-- Banner Body -->
            <div class="p-4">
                <div class="text-center mb-4">
                    <h3 class="text-lg font-black text-gray-900 mb-2">
                        <i class="fas fa-star text-yellow-500"></i> 
                        Special Offer
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Save big on upcoming events and premium stays. Limited time offer!
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col gap-2 justify-center">
                        <a href="{{ route('public.events.index') }}" 
                           class="flex-1 bg-purple-600 text-white px-3 py-2 rounded-lg font-semibold hover:bg-purple-700 transition-colors flex items-center justify-center space-x-1">
                            <i class="fas fa-calendar-alt text-xs"></i>
                            <span class="text-sm">Events</span>
                        </a>
                        <a href="{{ route('public.accommodations.index') }}" 
                           class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors flex items-center justify-center space-x-1">
                            <i class="fas fa-hotel text-xs"></i>
                            <span class="text-sm">Hotels</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
#popup-banner {
    animation: fadeIn 0.3s ease-out;
    display: flex;
}

#popup-banner.hidden {
    display: none;
}

#popup-banner.show #popup-content {
    transform: scale(1);
    opacity: 1;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    #popup-content {
        margin: 1rem;
        max-width: calc(100vw - 2rem);
    }
    
    .flex-col.sm\:flex-row {
        flex-direction: column;
    }
}
</style>

<!-- JavaScript -->
<script>
let popupShown = false;

function showPopupBanner() {
    if (popupShown) return;
    
    const banner = document.getElementById('popup-banner');
    const content = document.getElementById('popup-content');
    
    banner.classList.remove('hidden');
    banner.classList.add('show');
    popupShown = true;
    
    // Trigger animation
    setTimeout(() => {
        content.style.transform = 'scale(1)';
        content.style.opacity = '1';
    }, 100);
    
    // Prevent body scroll
    document.body.style.overflow = 'hidden';
}

function closePopupBanner() {
    const banner = document.getElementById('popup-banner');
    const content = document.getElementById('popup-content');
    
    content.style.transform = 'scale(0.95)';
    content.style.opacity = '0';
    
    setTimeout(() => {
        banner.classList.remove('show');
        banner.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }, 200);
}

// Auto-show after longer delay and only once
document.addEventListener('DOMContentLoaded', function() {
    // Show popup after 8 seconds (less intrusive)
    setTimeout(showPopupBanner, 8000);
    
    // Remove exit-intent trigger (less annoying)
    
    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePopupBanner();
        }
    });
});
</script>
