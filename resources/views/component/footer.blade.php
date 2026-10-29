<footer class="rvg-footer"><div class="rvg-wrap">
<div class="rvg-footer-grid">
<div><a class="rvg-brand" href="{{ route('home') }}"><img src="{{ asset('asset/img/logo-w-removebg-preview.png') }}" alt="Real Victory Groups" width="155" height="57" loading="lazy"></a><p>Good ideas deserve a great digital presence. Let’s build yours, together.</p><a href="https://post.realvictorygroups.com/">Download your posts ↗</a></div>
<div><h4>Explore</h4>@foreach(['about'=>'Our story','service'=>'What we do','project'=>'Selected work','blog'=>'Insights','career'=>'Careers'] as $name=>$label)<a href="{{ route($name) }}">{{ $label }}</a>@endforeach</div>
<div><h4>Get started</h4><a href="{{ route('packages') }}">Our packages</a><a href="{{ route('contact') }}">Start a project</a><a href="{{ route('application') }}">Get our app</a><a href="{{ route('login') }}">Client login</a></div>
<div><h4>Let’s connect</h4><a href="mailto:realvictorygroups@gmail.com">realvictorygroups@gmail.com</a><a href="tel:+918299012292">+91 82990 12292</a><p>73 Basement, Ekta Enclave Society, Lakhanpur, Khyora, Kanpur, Uttar Pradesh 208024</p><a href="https://wa.me/918299012292" target="_blank" rel="noopener noreferrer">Chat on WhatsApp ↗</a></div>
</div>
<div class="rvg-footer-bottom"><span>© {{ date('Y') }} Real Victory Groups. All rights reserved.</span><div><a href="{{ route('privacy-policy') }}">Privacy policy</a><a href="{{ route('term') }}">Terms of service</a><a href="{{ route('refund_policy') }}">Refund policy</a><a href="{{ route('cancellation_policy') }}">Cancellation policy</a></div><span>Made for what’s next. ↗</span></div>
</div></footer>
