<section class="bg-[#1a2e2a] text-white py-16 px-6 md:px-12 relative overflow-hidden">
    {{-- Decorative elements --}}
    <div class="absolute top-0 left-0 w-full h-full opacity-5">
        <div class="absolute top-20 left-10 w-40 h-40 rounded-full bg-[#e07b39]"></div>
        <div class="absolute bottom-20 right-10 w-60 h-60 rounded-full bg-[#e07b39]"></div>
    </div>
    
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center gap-10">
        {{-- Left Content --}}
        <div class="flex-1 z-10">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                Get Your Home<br>
                Jobs Done <span class="text-[#e07b39]">Fast &<br>Reliably</span>
            </h1>
            <p class="text-gray-300 text-sm md:text-base max-w-md mb-8 leading-relaxed">
                Connect with vetted local professionals for plumbing, electrical, carpentry, and more. Book in minutes, get the job done right.
            </p>

            {{-- Search Box --}}
            <div class="bg-white rounded-xl shadow-lg p-5 max-w-xl">
                <div class="flex flex-col sm:flex-row gap-3 mb-3">
                    <div class="flex-1">
                        <label class="text-gray-500 text-xs mb-1 block">What do you need done?</label>
                        <div class="flex items-center border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                            <span class="text-gray-400 mr-2 text-sm">🏠</span>
                            <select class="flex-1 bg-transparent text-gray-600 text-sm outline-none">
                                <option>Select a service</option>
                                <option>Plumbing</option>
                                <option>Electrical</option>
                                <option>Carpentry</option>
                                <option>Painting</option>
                                <option>AC Repair</option>
                                <option>Cleaning</option>
                                <option>Appliance Repair</option>
                                <option>Handyman</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="text-gray-500 text-xs mb-1 block">Your location</label>
                        <div class="flex items-center border border-gray-200 rounded-md px-3 py-2 bg-gray-50">
                            <span class="text-gray-400 mr-2 text-sm">📍</span>
                            <input type="text" placeholder="Enter your city or zip code" class="flex-1 bg-transparent text-gray-600 text-sm outline-none">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button class="bg-[#e07b39] hover:bg-[#c96a2a] text-white font-semibold px-6 py-2.5 rounded-md text-sm transition-colors h-[42px] mt-auto">
                            Search
                        </button>
                    </div>
                </div>
                <div class="text-center">
                    <button class="inline-flex items-center gap-2 text-gray-600 text-sm border border-gray-300 rounded-full px-5 py-2 hover:border-[#e07b39] hover:text-[#e07b39] transition-colors">
                        <span>📋</span> Post a job for free
                    </button>
                </div>
            </div>
        </div>

        {{-- Right Image --}}
        <div class="flex-1 flex justify-center md:justify-end">
            <div class="relative w-full max-w-sm md:max-w-md">
                <div class="rounded-2xl overflow-hidden h-72 md:h-96 shadow-2xl">
                    <img src="https://coresg-normal.trae.ai/api/ide/v1/text_to_image?prompt=modern%20living%20room%20interior%20with%20green%20sofa%20and%20tools%20for%20home%20service&image_size=square_hd" alt="Beautiful Living Room" class="w-full h-full object-cover">
                </div>
                {{-- Floating tool icon --}}
                <div class="absolute -bottom-4 -right-4 bg-[#e07b39] rounded-full w-16 h-16 flex items-center justify-center shadow-xl">
                    <span class="text-2xl">🔨</span>
                </div>
                {{-- Floating lamp decoration --}}
                <div class="absolute -top-8 -left-8">
                    <div class="text-4xl">💡</div>
                </div>
            </div>
        </div>
    </div>
</section>
