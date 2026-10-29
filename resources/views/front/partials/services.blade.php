<div class="rvg-service-grid">
@forelse(($serviceCategories ?? collect()) as $category)
<a class="rvg-service-card rvg-reveal" href="{{ route('servicedetail', $category->slug) }}"><span class="number">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span><div class="rvg-service-icon" aria-hidden="true">{{ ['⌘','✳','↗','◈','◎','⊞'][$loop->index % 6] }}</div><h3>{{ $category->name }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($category->serviceDetails->first()?->sort_description ?? 'Thoughtful strategy, purposeful design and technology that moves your business forward.'),145) }}</p><span class="rvg-link">Explore service <span aria-hidden="true">↗</span></span></a>
@empty
@foreach([['Website development','Fast, responsive websites that turn first impressions into lasting connections.','⌘'],['Branding & design','A clear identity. A distinctive voice. A brand your customers remember.','✳'],['Digital marketing','Reach the right audience with creative campaigns and purposeful content.','↗'],['App development','Useful, intuitive mobile experiences built around the way people work.','◈'],['Social media & content','Daily posters, engaging reels and a consistent presence for your brand.','◎'],['Business solutions','Connect your teams, simplify your processes and make room for growth.','⊞']] as $item)
<a class="rvg-service-card rvg-reveal" href="{{ route('contact') }}"><span class="number">0{{ $loop->iteration }}</span><div class="rvg-service-icon" aria-hidden="true">{{ $item[2] }}</div><h3>{{ $item[0] }}</h3><p>{{ $item[1] }}</p><span class="rvg-link">Let’s discuss <span aria-hidden="true">↗</span></span></a>
@endforeach
@endforelse
</div>
