<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($seo) ? 'Edit SEO' : 'Create SEO' }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">

                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($seo) ? route('seo.update', $seo->id) : route('seo.store') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label for=""> Title</label>
                            <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Title" value="{{ old('title', $seo->title ?? '') }}"> 
                        </div>

                      
                        <div>
                            <label for=""> Meta Title</label>
                            <input type="text" name="meta_title" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Meta Title" value="{{ old('meta_title', $seo->meta_title ?? '') }}">
                        </div>


                        <div>
                            <label for=""> Meta Description</label>
                            <textarea name="meta_description" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Meta Description">{{ old('meta_description', $seo->meta_description ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for=""> Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Meta Keywords" value="{{ old('meta_keywords', $seo->meta_keywords ?? '') }}">
                        </div>

                        <div>
                            <label for="">Canonical URL</label>
                            <input type="text" name="canonical_url" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Canonical URL" value="{{ old('canonical_url', $seo->canonical_url ?? '') }}">
                        </div>

                        <div>
                            <label for=""> Robots</label>
                            <input type="text" name="robots" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Robots" value="{{ old('robots', $seo->robots ?? '') }}">
                        </div>

                        <div>
                            <label for="">og_title</label>
                            <input type="text" name="og_title" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter og_title" value="{{ old('og_title', $seo->og_title ?? '') }}"> 

                        </div>

                        <div>
                            <label for="">og_description</label>
                            <input type="text" name="og_description" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter og_description" value="{{ old('og_description', $seo->og_description ?? '') }}">
                        </div>

                        <div>
                            <label for="og_type">Og type</label>
                            <input type="text" name="og_type" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter og type" value="{{ old('og_type', $seo->og_type ?? '') }}"> 
                        </div>
                        <div>
                            <label for="og_url">Og URL</label>
                            <input type="text" name="og_url" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter og URL" value="{{ old('og_url', $seo->og_url ?? '') }}">
                        </div>

                  
                          <div>
                            <label for="twitter_card">Twitter Card</label>
                            <input type="text" name="twitter_card" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Twitter Card" value="{{ old('twitter_card', $seo->twitter_card ?? '') }}"> 
                          </div>

                        <div>
                            <label for="twitter_title">Twitter Title</label>
                            <input type="text" name="twitter_title" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Twitter Title" value="{{ old('twitter_title', $seo->twitter_title ?? '') }}">
                        </div>

                        <div>
                            <label for="twitter_description">Twitter Description</label>
                            <input type="text" name="twitter_description" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Twitter Description" value="{{ old('twitter_description', $seo->twitter_description ?? '') }}">
                        </div>

                        <div>
                            <label for="twitter_site">Twitter Site</label>
                            <input type="text" name="twitter_site" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Twitter Site" value="{{ old('twitter_site', $seo->twitter_site ?? '') }}">
                        </div>

                        <div>
                            <label for="twitter_creator">Twitter Creator</label>
                            <input type="text" name="twitter_creator" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Twitter Creator" value="{{ old('twitter_creator', $seo->twitter_creator ?? '') }}">
                        </div>

   
                        <div>
                            <label for="schema_type">Schema Type</label>
                            <input type="text" name="schema_type" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Schema Type" value="{{ old('schema_type', $seo->schema_type ?? '') }}">
                        </div>

                        <div>
                            <label for="structured_data_json">Structured Data JSON</label>
                            <textarea name="structured_data_json" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Structured Data JSON">{{ old('structured_data_json', $seo->structured_data_json ?? '') }}</textarea>
                        </div>

                       
                        <div>
                            <label for="focus_keyword">Focus Keyword</label>
                            <input type="text" name="focus_keyword" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Focus Keyword" value="{{ old('focus_keyword', $seo->focus_keyword ?? '') }}">
                        </div>

                        <div>
                            <label for="meta_tags">Meta Tags</label>
                            <textarea name="meta_tags" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Meta Tags">{{ old('meta_tags', $seo->meta_tags ?? '') }}</textarea>
                        </div>

                      

                        <div>
                            <label for="breadcrumb_title">Breadcrumb Title</label>
                            <input type="text" name="breadcrumb_title" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Breadcrumb Title" value="{{ old('breadcrumb_title', $seo->breadcrumb_title ?? '') }}">
                        </div>

                        <div>
                            <label for="content_type">Content Type</label>
                            <input type="text" name="content_type" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Content Type" value="{{ old('content_type', $seo->content_type ?? '') }}">
                        </div>

                        <div>
                            <label for="author">Author</label>
                            <input type="text" name="author" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Author Name" value="{{ old('author', $seo->author ?? '') }}">
                        </div>

                       



                        <div>
                            <label for="priority">Priority</label>
                            <input type="text" name="priority" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Priority (0.1 to 1.0)" value="{{ old('priority', $seo->priority ?? '') }}">
                        </div>

                        <div>
                            <label for="changefreq">Change Frequency</label>
                            <input type="text" name="changefreq" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Change Frequency (daily, weekly, monthly)" value="{{ old('changefreq', $seo->changefreq ?? '') }}">
                        </div>




                        <div>
                            <label for="page_type">Page Type</label>
                            <select name="page_type" id="page_type">
                                <option value="">none</option>
                                <option value="home" {{ old('page_type', $seo->page_type ?? '') == 'home' ? 'selected' : '' }}>Home</option>
                                <option value="about" {{ old('page_type', $seo->page_type ?? '') == 'about' ? 'selected' : '' }}>About</option>
                                <option value="service" {{ old('page_type', $seo->page_type ?? '') == 'service' ? 'selected' : '' }}>Service</option>
                                <option value="packages" {{ old('page_type', $seo->page_type ?? '') == 'packages' ? 'selected' : '' }}>Packages</option>

                                <option value="blog" {{ old('page_type', $seo->page_type ?? '') == 'blog' ? 'selected' : '' }}>Blog</option>

                                <option value="project" {{ old('page_type', $seo->page_type ?? '') == 'project' ? 'selected' : '' }}>Project</option>
                                <option value="contact" {{ old('page_type', $seo->page_type ?? '') == 'contact' ? 'selected' : '' }}>Contact</option>

                                <option value="career" {{ old('page_type', $seo->page_type ?? '') == 'career' ? 'selected' : '' }}>Career</option>
                                <option value="packagesCategory" {{ old('page_type', $seo->page_type ?? '') == 'packagesCategory' ? 'selected' : '' }}>Packages Category</option>

                                <option value="term_and_condition" {{ old('page_type', $seo->page_type ?? '') == 'term_and_condition' ? 'selected' : '' }}>Term and Condition</option>

                                <option value="privacy_policy" {{ old('page_type', $seo->page_type ?? '') == 'privacy_policy' ? 'selected' : '' }}>Privacy Policy</option>

                                <option value="return_policy" {{ old('page_type', $seo->page_type ?? '') == 'return_policy' ? 'selected' : '' }}>Return Policy</option>

                                <option value="refund_policy" {{ old('page_type', $seo->page_type ?? '') == 'refund_policy' ? 'selected' : '' }}>Refund Policy</option>

                               
                             </select>
                        </div>


                        <div>
                            <label for="locale">Locale</label>
                            <input type="text" name="locale" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Locale (e.g., en, fr)" value="{{ old('locale', $seo->locale ?? '') }}">
                        </div>

                        <div>
                            <label for="country">Country</label>
                            <input type="text" name="country" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Country (default: India)" value="{{ old('country', $seo->country ?? 'India') }}">
                        </div>

                        <div>
                            <label for="region">Region</label>
                            <input type="text" name="region" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Region (optional)" value="{{ old('region', $seo->region ?? '') }}">
                        </div>

                        <div>
                            <label for="timezone">Timezone</label>
                            <input type="text" name="timezone" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter Timezone" value="{{ old('timezone', $seo->timezone ?? 'UTC') }}">
                        </div>  


                      <div>
                            <label class="block font-medium">Link to Blog</label>
                            <select name="blog_id" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">None</option>
                                @foreach ($blogs as $blog)
                                    <option value="{{ $blog->id }}"
                                        {{ old('blog_id', $seo->blog_id ?? '') == $blog->id ? 'selected' : '' }}>
                                        {{ $blog->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium">Link to Package</label>
                            <select name="package_id" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">None</option>
                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}"
                                        {{ old('package_id', $seo->package_id ?? '') == $package->id ? 'selected' : '' }}>
                                        {{ $package->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium">Link to Service</label>
                            <select name="service_id" class="w-full px-4 py-2 border rounded-lg">
                                <option value="">None</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}"
                                        {{ old('service_id', $seo->service_id ?? '') == $service->id ? 'selected' : '' }}>
                                        {{ $service->title }}
                                        @if ($service->category)
                                            ({{ $service->category->name }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                        @foreach ([
        'meta_image_file' => 'meta_image',
        'og_image_file' => 'og_image',
        'twitter_image_file' => 'twitter_image',
    ] as $input => $dbField)
                            <div>
                                <label
                                    class="block font-medium">{{ ucwords(str_replace('_file', '', str_replace('_', ' ', $input))) }}</label>
                                <input type="file" name="{{ $input }}" class="block w-full mt-2">
                                @if (isset($seo) && $seo->$dbField)
                                    <img src="{{ asset('storage/' . $seo->$dbField) }}"
                                        class="mt-2 w-24 rounded shadow">
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition">
                            {{ isset($seo) ? 'Update SEO' : 'Create SEO' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
