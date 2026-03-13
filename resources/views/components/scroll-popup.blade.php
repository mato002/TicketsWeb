<!-- Scroll Popup Component -->
<div id="scroll-popup" class="fixed bottom-4 left-4 z-40 hidden transform transition-all duration-300 translate-x-full">
    <div class="bg-white rounded-xl shadow-lg p-4 max-w-xs border border-gray-200">
        <!-- Close Button -->
        <button onclick="closeScrollPopup()" 
                class="absolute -top-2 -right-2 bg-gray-100 text-gray-600 rounded-full w-6 h-6 flex items-center justify-center hover:bg-gray-200 transition-colors">
            <i class="fas fa-times text-xs"></i>
        </button>
        
        <!-- Content -->
        <div class="flex items-center space-x-3">
            <div class="bg-gradient-to-br from-purple-500 to-blue-600 rounded-lg p-2">
                <i class="fas fa-gift text-white text-sm"></i>
            </div>
            <div class="flex-1">
                <div class="font-bold text-gray-900 text-sm">Flash Sale!</div>
                <div class="text-xs text-gray-600">Save 20% on events</div>
                <div class="text-xs font-black text-orange-500">Ends in 2:45:30</div>
            </div>
        </div>
        
        <!-- CTA -->
        <a href="{{ route('public.events.index') }}" 
           class="mt-3 block w-full bg-purple-600 text-white text-center py-2 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
            View Deals <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>

<!-- Styles -->
<style>
#scroll-popup {
    animation: slideIn 0.5s ease-out;
}

#scroll-popup.show {
    transform: translateX(0);
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
    }
    to {
        transform: translateX(0);
    }
}

/* Pulse animation for gift icon */
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

#scroll-popup .bg-gradient-to-br {
    animation: pulse 2s infinite;
}
</style>

<!-- JavaScript -->
<script>
let scrollPopupShown = false;

function showScrollPopup() {
    if (scrollPopupShown) return;
    
    const popup = document.getElementById('scroll-popup');
    popup.classList.remove('hidden');
    popup.classList.add('show');
    scrollPopupShown = true;
    
    // Auto-hide after 10 seconds
    setTimeout(() => {
        closeScrollPopup();
    }, 10000);
}

function closeScrollPopup() {
    const popup = document.getElementById('scroll-popup');
    popup.classList.remove('show');
    popup.classList.add('hidden');
}

// Show popup when user scrolls to 70% of page (less frequent)
document.addEventListener('DOMContentLoaded', function() {
    let scrollTimeout;
    
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            const scrollPercentage = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            
            if (scrollPercentage >= 70 && !scrollPopupShown) {
                showScrollPopup();
            }
        }, 100);
    });
});
</script>
