# Real Victory Groups — Premium Website Redesign

A complete redesign of the public Laravel website using compiled Tailwind CSS, Three.js and D3.js. The original logo and business contact details are retained. Primary colours: warm ivory, deep navy and Victory red.

## Existing website par kaise lagana hai

1. Pehle live website ki files aur database ka backup lein. Staging par check karna behtar hai.
2. Is archive ko extract karein. Existing project mein neeche listed changed files/folders merge karein. Apni live `.env`, uploaded `public/storage`, `storage/app`, vendor aur existing database replace na karein. `CHANGED-FILES.txt` exact list deta hai.
3. Compiled `public/build` folder included hai. Server par Node/npm ki zarurat nahi hai agar included build use kar rahe hain.
4. Project folder mein terminal kholkar run karein:

```bash
php artisan optimize:clear
php artisan migrate --force
php artisan view:cache
```

Contact enquiries ke liye ek new migration hai: `2026_10_29_000001_allow_repeat_contact_enquiries.php`. Purane schema mein email required aur unique tha, jabki form/controller phone-only enquiries allow karte hain. Migration email nullable karta hai aur repeat enquiries allow karta hai. Koi existing enquiry delete nahi hoti. SQLite par migration aur form saving verify ki gayi hai; live MySQL par pehle staging check karein.

5. Browser hard refresh karein (Ctrl+Shift+R). Home, Services, Projects, About, Packages, Blog, Contact, Careers, App aur policy pages check karein.
6. Razorpay test mode mein checkout end-to-end test karein, phir production use karein. Payment credentials, SMTP, database and chat configuration aapki existing `.env` se aayenge.

### Agar CSS/JS edit karna ho

```bash
npm ci
npm run build
php artisan view:clear
```

Dev mode ke liye do terminals: `php artisan serve` aur `npm run dev`.

### Fresh project setup

PHP 8.2+ with Laravel-required extensions, Composer and your database are needed. Use your own `.env`, run `composer install`, configure `APP_KEY` and database, then migrate. Existing production project par APP_KEY regenerate na karein. `bootstrap/cache` and `storage` must be writable. Original project includes uploaded assets; existing server par merge ke samay unko overwrite na karein.

## Kya badla hai

- Sticky responsive navigation; mobile menu; new footer and accessible skip/back-to-top controls.
- Home, Services, Service Detail, About, Projects, Packages, Category Packages, Package Detail, Blog, Blog Detail, Contact, Careers, App and 404 page layouts.
- Existing legal wording retained, with new shared shell and policy headings.
- Checkout, phone verification and payment status pages inherit the new shell and compatibility styling; payment processing code is retained.
- Existing admin-managed hero title/subtitle, services, products, projects, about content, team, testimonials, packages, FAQs, media and articles remain dynamic.
- Three.js: lazy-loaded red sculptural knot, pointer response and animation pause when offscreen/hidden. Reduced-motion users see a still visual. WebGL-unavailable devices see the CSS fallback.
- D3.js: responsive illustrative growth chart, keyboard-focusable points and hover/focus labels. It is labelled illustrative, not actual performance data.
- Project category filtering, native FAQ expansion, career selection and enquiry/callback forms.
- Compiled Tailwind stylesheet with preflight disabled to retain existing Bootstrap checkout compatibility. No Tailwind CDN runtime dependency.

## Content notes

Hero headline/subtitle use the first active banner when present. Other hero copy is the default. Portfolio records are read from your database. When no records exist, clearly labelled design concepts appear instead. Package cards use database prices and existing purchase routes. No invented client results or reviews are added.

## Important verification limits

See `VALIDATION.md`. This archive has not been installed on your live domain. The review browser has WebGL disabled: the fallback was verified, but animated GPU rendering still needs checking in a WebGL-enabled browser. Production payments, delivery of SMTP mail, production database and authenticated chat were not exercised.
