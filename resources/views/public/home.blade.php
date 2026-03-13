@extends('layouts.public')

@section('title', 'TwendeTickets - Discover Amazing Events')
@section('description', 'Find and book best events including sports, music festivals, comedy, car shows, travel, hiking, art, and gallery events. Discover upcoming events, secure your tickets, book nearby accommodation, and arrange transport all in one place with TwendeeTickets.')

@section('content')
<!-- Include Popup Banner Components -->
@include('components.popup-banner')
@include('components.scroll-popup')
<!-- Hero Section with Slideshow -->
<section class="hero-section relative text-white py-20 lg:py-32 overflow-hidden" x-data="heroSlideshow()">
    <!-- Slideshow Container -->
    <div class="absolute inset-0">
        <!-- Slide 1: Concerts -->
        <div class="slide absolute inset-0 transition-opacity duration-1000" 
             :class="currentSlide === 0 ? 'opacity-100' : 'opacity-0'">
            <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 alt="Music Concert" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>
        
        <!-- Slide 2: Sports -->
        <div class="slide absolute inset-0 transition-opacity duration-1000" 
             :class="currentSlide === 1 ? 'opacity-100' : 'opacity-0'">
            <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 alt="Sports Event" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>
        
        <!-- Slide 3: Comedy -->
        <div class="slide absolute inset-0 transition-opacity duration-1000" 
             :class="currentSlide === 2 ? 'opacity-100' : 'opacity-0'">
            <img src="https://images.unsplash.com/photo-1516280430614-37939bbacd81?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 alt="Comedy Show" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>
        
        <!-- Slide 4: Art & Culture -->
        <div class="slide absolute inset-0 transition-opacity duration-1000" 
             :class="currentSlide === 3 ? 'opacity-100' : 'opacity-0'">
            <img src="https://images.unsplash.com/photo-1532274402911-5a369e4c4bb5?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 alt="Art Exhibition" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>
        
        <!-- Slide 5: Festivals -->
        <div class="slide absolute inset-0 transition-opacity duration-1000" 
             :class="currentSlide === 4 ? 'opacity-100' : 'opacity-0'">
            <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" 
                 alt="Festival" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>
    </div>
    
    <!-- Slide Indicators -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-30 flex space-x-2">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="goToSlide(index)" 
                    :class="currentSlide === index ? 'bg-yellow-400 w-8' : 'bg-white/50 w-6'"
                    class="h-2 rounded-full transition-all duration-300 hover:bg-yellow-300"></button>
        </template>
    </div>
    
    <!-- Navigation Arrows -->
    <button @click="prevSlide()" 
            class="absolute left-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button @click="nextSlide()" 
            class="absolute right-4 top-1/2 transform -translate-y-1/2 z-30 bg-white/20 backdrop-blur-sm text-white p-3 rounded-full hover:bg-white/30 transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
    
    <!-- Hero Content -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Dynamic Content Based on Current Slide -->
            <div class="slide-content transition-all duration-500">
                <!-- Slide 1: Concerts -->
                <div x-show="currentSlide === 0" x-transition:enter="transition-opacity duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        Experience the
                        <span class="block text-yellow-300 animate-pulse">Music Magic</span>
                    </h1>
                    <p class="text-xl md:text-2xl lg:text-3xl mb-8 text-blue-100 max-w-4xl mx-auto font-light">
                        From intimate jazz sessions to massive music festivals, discover the rhythm that moves your soul.
                    </p>
                </div>
                
                <!-- Slide 2: Sports -->
                <div x-show="currentSlide === 1" x-transition:enter="transition-opacity duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        Feel the
                        <span class="block text-yellow-300 animate-pulse">Action Live</span>
                    </h1>
                    <p class="text-xl md:text-2xl lg:text-3xl mb-8 text-blue-100 max-w-4xl mx-auto font-light">
                        From football matches to athletics championships, witness sporting greatness up close.
                    </p>
                </div>
                
                <!-- Slide 3: Comedy -->
                <div x-show="currentSlide === 2" x-transition:enter="transition-opacity duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        Laugh Out Loud
                        <span class="block text-yellow-300 animate-pulse">Comedy Nights</span>
                    </h1>
                    <p class="text-xl md:text-2xl lg:text-3xl mb-8 text-blue-100 max-w-4xl mx-auto font-light">
                        Stand-up comedy, improv shows, and laugh riots that will leave you in stitches.
                    </p>
                </div>
                
                <!-- Slide 4: Art & Culture -->
                <div x-show="currentSlide === 3" x-transition:enter="transition-opacity duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        Explore
                        <span class="block text-yellow-300 animate-pulse">Art & Culture</span>
                    </h1>
                    <p class="text-xl md:text-2xl lg:text-3xl mb-8 text-blue-100 max-w-4xl mx-auto font-light">
                        Art exhibitions, cultural festivals, and creative experiences that inspire and delight.
                    </p>
                </div>
                
                <!-- Slide 5: Festivals -->
                <div x-show="currentSlide === 4" x-transition:enter="transition-opacity duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 leading-tight">
                        Join the
                        <span class="block text-yellow-300 animate-pulse">Festival Fun</span>
                    </h1>
                    <p class="text-xl md:text-2xl lg:text-3xl mb-8 text-blue-100 max-w-4xl mx-auto font-light">
                        Food festivals, cultural celebrations, and community events that bring everyone together.
                    </p>
                </div>
            </div>
            
            <!-- Enhanced Search Box -->
            <div class="max-w-5xl mx-auto">
                <form action="{{ route('public.events.index') }}" method="GET" 
                      class="bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl p-8 shadow-2xl border border-white border-opacity-20">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Event Type</label>
                            <select name="type" class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500 focus:border-transparent transition-all hover:border-purple-300">
                                <option value=""><i class="fas fa-calendar-alt"></i> All Events</option>
                                <option value="music"><i class="fas fa-music"></i> Music & Concerts</option>
                                <option value="sports"><i class="fas fa-football-ball"></i> Sports Events</option>
                                <option value="comedy"><i class="fas fa-laugh"></i> Comedy Shows</option>
                                <option value="car_show"><i class="fas fa-car"></i> Car Shows</option>
                                <option value="travel"><i class="fas fa-plane"></i> Travel & Tours</option>
                                <option value="hiking"><i class="fas fa-hiking"></i> Hiking & Adventure</option>
                                <option value="art"><i class="fas fa-palette"></i> Art Exhibitions</option>
                                <option value="gallery"><i class="fas fa-images"></i> Gallery Shows</option>
                                <option value="festival"><i class="fas fa-glass-cheers"></i> Festivals</option>
                                <option value="theater"><i class="fas fa-theater-masks"></i> Theater & Drama</option>
                                <option value="conference"><i class="fas fa-briefcase"></i> Conferences</option>
                                <option value="workshop"><i class="fas fa-tools"></i> Workshops</option>
                            </select>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Venue</label>
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="venue" placeholder="Search venue..." 
                                       class="w-full pl-12 pr-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500 focus:border-transparent transition-all hover:border-purple-300">
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">City</label>
                            <div class="relative">
                                <i class="fas fa-city absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="city" placeholder="Search city..." 
                                       class="w-full pl-12 pr-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500 focus:border-transparent transition-all hover:border-purple-300">
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Date</label>
                            <div class="relative">
                                <i class="fas fa-calendar absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="date" name="date_from" 
                                       class="w-full pl-12 pr-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-purple-500 focus:border-transparent transition-all hover:border-purple-300">
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-purple-600 to-blue-600 text-white px-12 py-5 rounded-xl font-bold text-lg hover:from-purple-700 hover:to-blue-700 transition-all transform hover:scale-105 shadow-2xl flex items-center justify-center space-x-3 mx-auto">
                            <i class="fas fa-search"></i>
                            <span>Search Events</span>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12 max-w-4xl mx-auto">
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-black text-yellow-300"><i class="fas fa-calendar-check"></i> 500+</div>
                    <div class="text-sm text-blue-100">Events</div>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-black text-yellow-300"><i class="fas fa-users"></i> 50K+</div>
                    <div class="text-sm text-blue-100">Happy Customers</div>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-black text-yellow-300"><i class="fas fa-map-marked-alt"></i> 100+</div>
                    <div class="text-sm text-blue-100">Venues</div>
                </div>
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl p-6 border border-white border-opacity-20">
                    <div class="text-3xl font-black text-yellow-300"><i class="fas fa-headset"></i> 24/7</div>
                    <div class="text-sm text-blue-100">Support</div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Featured Events Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100" style="background-image: url('https://images.unsplash.com/photo-1470225620780-dba8ba36b745?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-attachment: fixed; background-position: center;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl p-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                    <i class="fas fa-fire text-orange-500"></i> Featured Events
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Don't miss these incredible upcoming events from sports to music, comedy to art. Limited tickets available!
                </p>
            </div>

        @if($featuredEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredEvents as $event)
                    <div class="event-card bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                        <div class="relative group">
                            @if($event->image_url)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" 
                                     class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-56 bg-gradient-to-br from-purple-600 to-blue-600 flex items-center justify-center">
                                    <i class="fas fa-music text-white text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    {{ $event->event_type_name }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                                    <i class="fas fa-fire"></i> Only {{ $event->available_tickets }} left
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-gray-900 mb-3">{{ $event->title }}</h3>
                            <p class="text-purple-600 font-bold text-lg mb-4">{{ $event->organizer }}</p>
                            <div class="flex items-center text-gray-600 mb-3">
                                <i class="fas fa-map-marker-alt mr-3 text-purple-500"></i>
                                <span class="font-medium">{{ $event->venue }}, {{ $event->city }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 mb-6">
                                <i class="fas fa-calendar-alt mr-3 text-purple-500"></i>
                                <span class="font-medium">{{ $event->event_date->format('M j, Y') }} at {{ $event->event_time->format('g:i A') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-3xl font-black text-purple-600">{{ $event->formatted_price }}</span>
                                    <span class="text-gray-500 block text-sm">per ticket</span>
                                </div>
                                <a href="{{ route('public.events.show', $event) }}" 
                                   class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:from-purple-700 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                                    Get Tickets <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('public.events.index') }}" 
                   class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-12 py-5 rounded-2xl font-bold text-lg hover:from-purple-700 hover:to-blue-700 transition-all transform hover:scale-105 shadow-2xl inline-block">
                    View All Events <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gradient-to-br from-purple-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-calendar-times text-purple-600 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">No Featured Events Yet</h3>
                <p class="text-gray-600 text-lg">Check back soon for amazing featured events from all categories!</p>
                <a href="{{ route('public.events.index') }}" 
                   class="mt-6 inline-block bg-purple-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-purple-700 transition-colors">
                    Browse All Events <i class="fas fa-search ml-2"></i>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Advertising Banner Section -->
<section class="py-16 bg-gradient-to-r from-yellow-400 to-orange-500 relative overflow-hidden" style="background-image: url('https://images.unsplash.com/photo-15432863869-fa1275d5f1f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-500 opacity-90"></div>
    <div class="absolute inset-0">
        <div class="floating-banner absolute top-4 left-8 text-6xl animate-bounce"><i class="fas fa-gift text-white opacity-50"></i></div>
        <div class="floating-banner absolute top-8 right-12 text-5xl animate-pulse"><i class="fas fa-music text-white opacity-50"></i></div>
        <div class="floating-banner absolute bottom-4 left-1/3 text-6xl animate-bounce"><i class="fas fa-star text-white opacity-50"></i></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="bg-white bg-opacity-95 backdrop-blur-lg rounded-3xl p-12 shadow-2xl">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                <i class="fas fa-percentage text-orange-500"></i> Early Bird Special!
            </h2>
            <p class="text-xl text-gray-700 mb-8 max-w-3xl mx-auto">
                Get <span class="text-3xl font-black text-orange-500">20% OFF</span> on all upcoming events when you book this week. 
                Limited time offer - don't miss out on the hottest events!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('public.events.index') }}" 
                   class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:from-orange-600 hover:to-red-600 transition-all transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-rocket"></i> Book Now & Save
                </a>
                <button class="bg-gray-800 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-gray-900 transition-all">
                    <i class="fas fa-clock"></i> Timer: 48:23:15
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Featured Accommodations Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 to-purple-50" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099925b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-attachment: fixed; background-position: center;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl p-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                    <i class="fas fa-hotel text-green-500"></i> Featured Accommodations
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Stay in comfort near your favorite venues. Book your perfect accommodation today!
                </p>
            </div>

        @if($featuredAccommodations->count() > 0)
            <div id="accommodations-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredAccommodations as $index => $accommodation)
                    <div class="accommodation-card bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-3xl {{ $index >= 3 ? 'hidden accommodation-extra' : '' }}">
                        <div class="relative group">
                            @if($accommodation->images && count($accommodation->images) > 0)
                                <img src="{{ $accommodation->images[0] }}" alt="{{ $accommodation->name }}" 
                                     class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-56 bg-gradient-to-br from-green-500 to-blue-600 flex items-center justify-center">
                                    <i class="fas fa-home text-white text-5xl"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-gradient-to-r from-green-500 to-blue-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            </div>
                            @if($accommodation->rating)
                                <div class="absolute top-4 right-4 bg-white bg-opacity-95 backdrop-blur-lg px-3 py-2 rounded-xl shadow-lg">
                                    <span class="text-sm font-black text-gray-900"><i class="fas fa-star text-yellow-500"></i> {{ $accommodation->formatted_rating }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-2xl font-black text-gray-900 mb-3">{{ $accommodation->name }}</h3>
                            <p class="text-gray-600 font-semibold text-lg mb-4">{{ ucfirst($accommodation->type) }}</p>
                            <div class="flex items-center text-gray-600 mb-4">
                                <i class="fas fa-map-marker-alt mr-3 text-green-500"></i>
                                <span class="font-medium">{{ $accommodation->city }}, {{ $accommodation->state }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-3xl font-black text-green-600">{{ $accommodation->formatted_price }}</span>
                                    <span class="text-gray-500 block text-sm">per night</span>
                                </div>
                                <a href="{{ route('public.accommodations.show', $accommodation) }}" 
                                   class="bg-gradient-to-r from-green-500 to-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:from-green-600 hover:to-blue-700 transition-all transform hover:scale-105 shadow-lg">
                                    Book Now <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                @if($featuredAccommodations->count() > 3)
                    <button id="toggle-accommodations-btn" onclick="toggleAccommodations()" 
                       class="bg-gradient-to-r from-green-500 to-blue-600 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:from-green-600 hover:to-blue-700 transition-all transform hover:scale-105 shadow-2xl mr-4">
                        View All Accommodations <i class="fas fa-th ml-2"></i>
                    </button>
                @endif
                <a href="{{ route('public.accommodations.index') }}" 
                   class="bg-gray-800 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-gray-900 transition-all transform hover:scale-105 shadow-2xl inline-block">
                    Browse More <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gradient-to-br from-green-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-home text-green-600 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-3">No Featured Accommodations Yet</h3>
                <p class="text-gray-600 text-lg">Check back soon for amazing accommodation options!</p>
                <a href="{{ route('public.accommodations.index') }}" 
                   class="mt-6 inline-block bg-green-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-green-700 transition-colors">
                    Browse All Accommodations <i class="fas fa-search ml-2"></i>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Transport Services Section -->
<section class="py-20 bg-gradient-to-br from-orange-50 to-yellow-50" style="background-image: url('https://images.unsplash.com/photo-1446746379205-3a53b9c9a6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-attachment: fixed; background-position: center;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl p-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                    <i class="fas fa-bus text-orange-500"></i> Transport Services
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Travel to events in comfort and style with our transport services
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-8 transform transition-all duration-300 group-hover:scale-110 shadow-2xl">
                        <i class="fas fa-route text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">Multiple Routes</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Choose from various pickup points and destinations across Kenya
                    </p>
                </div>

                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-8 transform transition-all duration-300 group-hover:scale-110 shadow-2xl">
                        <i class="fas fa-users text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">Group Transport</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Travel together with friends and family in our spacious vehicles
                    </p>
                </div>

                <div class="text-center group">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-8 transform transition-all duration-300 group-hover:scale-110 shadow-2xl">
                        <i class="fas fa-shield-alt text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-4">Safe & Reliable</h3>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Professional drivers and well-maintained vehicles for your safety
                    </p>
                </div>
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('public.transport.index') }}" 
                   class="mt-6 inline-block bg-orange-500 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:from-orange-600 hover:to-yellow-600 transition-all transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-bus mr-3"></i> Explore Transport Services
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-gradient-to-br from-purple-50 to-pink-50" style="background-image: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-attachment: fixed; background-position: center;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-3xl p-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">
                    <i class="fas fa-rocket text-purple-500"></i> How It Works
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Booking your perfect concert experience has never been easier
                </p>
            </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center group">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-8 transform transition-all duration-300 group-hover:scale-110 shadow-2xl">
                    <i class="fas fa-search text-white text-3xl"></i>
                </div>
            <h3 class="text-2xl font-black text-gray-900 mb-4">1. Discover</h3>
            <p class="text-gray-600 text-lg leading-relaxed">
                Browse through hundreds of upcoming events, shows, and performances to find your perfect experience
            </p>
            </div>

            <div class="text-center group">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-8 transform transition-all duration-300 group-hover:scale-110 shadow-2xl">
                    <i class="fas fa-ticket-alt text-white text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">2. Book</h3>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Select your tickets, choose accommodation, and secure your booking in minutes
                </p>
            </div>

            <div class="text-center group">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-8 transform transition-all duration-300 group-hover:scale-110 shadow-2xl">
                    <i class="fas fa-check-circle text-white text-3xl"></i>
                </div>
            <h3 class="text-2xl font-black text-gray-900 mb-4">3. Enjoy</h3>
            <p class="text-gray-600 text-lg leading-relaxed">
                Show up and enjoy an unforgettable event experience with friends and family
            </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-purple-600 to-blue-600 relative overflow-hidden" style="background-image: url('https://images.unsplash.com/photo-1470249690251-6a8b9c2c6b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=60'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 opacity-90"></div>
    <div class="absolute inset-0">
        <div class="floating-cta absolute top-4 left-8 text-4xl animate-bounce"><i class="fas fa-gift text-white opacity-50"></i></div>
        <div class="floating-cta absolute top-8 right-12 text-3xl animate-pulse"><i class="fas fa-music text-white opacity-50"></i></div>
        <div class="floating-cta absolute bottom-4 left-1/3 text-4xl animate-bounce"><i class="fas fa-star text-white opacity-50"></i></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-3xl p-16 shadow-2xl border border-white border-opacity-20">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6">
                <i class="fas fa-rocket"></i> Ready for Your Next Unforgettable Experience?
            </h2>
            <p class="text-xl text-blue-100 mb-10 max-w-3xl mx-auto">
                Join thousands of event lovers who trust TwendeTickets for their concert, show, and performance bookings
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('public.events.index') }}" 
                   class="bg-white text-purple-600 px-12 py-5 rounded-2xl font-bold text-lg hover:bg-gray-100 transition-all transform hover:scale-105 shadow-2xl">
                    <i class="fas fa-ticket-alt"></i> Browse All Events
                </a>
                @guest
                    <a href="{{ route('register') }}" 
                       class="border-4 border-white text-white px-12 py-5 rounded-2xl font-bold text-lg hover:bg-white hover:text-purple-600 transition-all transform hover:scale-105">
                        <i class="fas fa-user-plus"></i> Sign Up Free
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    let accommodationsExpanded = false;

    function toggleAccommodations() {
        const extraAccommodations = document.querySelectorAll('.accommodation-extra');
        const button = document.getElementById('toggle-accommodations-btn');
        
        accommodationsExpanded = !accommodationsExpanded;
        
        extraAccommodations.forEach(accommodation => {
            if (accommodationsExpanded) {
                accommodation.classList.remove('hidden');
            } else {
                accommodation.classList.add('hidden');
            }
        });
        
        button.textContent = accommodationsExpanded ? 'Show Less' : 'View All Accommodations';
    }

    // Enhanced animations and interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards and sections
        document.querySelectorAll('.event-card, .accommodation-card, .group').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(el);
        });

        // Hero Slideshow JavaScript
        function heroSlideshow() {
            return {
                currentSlide: 0,
                slides: [
                    { title: 'Concerts', image: 'concert' },
                    { title: 'Sports', image: 'sports' },
                    { title: 'Comedy', image: 'comedy' },
                    { title: 'Art & Culture', image: 'art' },
                    { title: 'Festivals', image: 'festivals' }
                ],
                autoplayInterval: null,
                
                init() {
                    this.startAutoplay();
                    this.setupKeyboardNavigation();
                    this.setupTouchGestures();
                },
                
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.nextSlide();
                    }, 5000); // Change slide every 5 seconds
                },
                
                stopAutoplay() {
                    if (this.autoplayInterval) {
                        clearInterval(this.autoplayInterval);
                    }
                },
                
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    this.resetAutoplay();
                },
                
                prevSlide() {
                    this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                    this.resetAutoplay();
                },
                
                goToSlide(index) {
                    this.currentSlide = index;
                    this.resetAutoplay();
                },
                
                resetAutoplay() {
                    this.stopAutoplay();
                    this.startAutoplay();
                },
                
                setupKeyboardNavigation() {
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'ArrowLeft') {
                            this.prevSlide();
                        } else if (e.key === 'ArrowRight') {
                            this.nextSlide();
                        }
                    });
                },
                
                setupTouchGestures() {
                    let touchStartX = 0;
                    let touchEndX = 0;
                    
                    const heroSection = document.querySelector('.hero-section');
                    
                    heroSection.addEventListener('touchstart', (e) => {
                        touchStartX = e.changedTouches[0].screenX;
                    });
                    
                    heroSection.addEventListener('touchend', (e) => {
                        touchEndX = e.changedTouches[0].screenX;
                        this.handleSwipe();
                    });
                    
                    this.handleSwipe = () => {
                        const swipeThreshold = 50;
                        const diff = touchStartX - touchEndX;
                        
                        if (Math.abs(diff) > swipeThreshold) {
                            if (diff > 0) {
                                this.nextSlide(); // Swipe left, go to next slide
                            } else {
                                this.prevSlide(); // Swipe right, go to previous slide
                            }
                        }
                    };
                }
            }
        }
        
        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-section');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Add hover sound effect simulation (visual feedback)
        document.querySelectorAll('.btn, .event-card, .accommodation-card').forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });
            element.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>
@endpush
@endsection
