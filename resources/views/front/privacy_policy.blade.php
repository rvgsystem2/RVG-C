@extends('component.main', ['seos' => $seos])

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid custom-color my-lg-5 py-md-4 py-sm-3 py-2">
        <div class="container text-center py-5">
            <h1 class="display-5 text-white mb-3 animated slideInDown">Privacy Policy</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="/" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Privacy Policy</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Privacy Policy Start -->
    <div class="container-fluid mb-lg-5">
        <div class="container my-4 my-lg-5">
            <div class="row shadow rounded bg-white p-3 p-md-4 p-lg-5">
                <div class="col-12 mb-4">
                    <h2 class="fw-bold text-dark mb-3">Privacy Policy</h2>
                    <p class="mb-2"><strong>Effective Date:</strong> 10 October 2024</p>
                    <p class="mb-0">
                        Real Victory Groups (“we,” “our,” or “us”) values your privacy and is committed to protecting
                        the personal information you share with us. This Privacy Policy explains how we collect, use,
                        store, and protect your information when you use our website, services, and connected social
                        media tools, including Facebook and Instagram integrations.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">1. Information We Collect</h4>
                    <p>We may collect the following types of information:</p>
                    <ul class="ps-3">
                        <li class="mb-2">
                            <strong>Personal Information:</strong> such as your name, phone number, email address,
                            business name, and other details you provide when contacting us, registering, or using our services.
                        </li>
                        <li class="mb-2">
                            <strong>Technical Information:</strong> such as IP address, browser type, device information,
                            operating system, pages visited, date/time of access, and referring website details.
                        </li>
                        <li class="mb-2">
                            <strong>Social Media Account Information:</strong> if you connect your Facebook Page or
                            Instagram account with our platform, we may collect limited account-related data such as
                            page ID, page name, Instagram business account ID, Instagram username, access tokens,
                            and related account metadata required to provide publishing and account connection features.
                        </li>
                        <li class="mb-2">
                            <strong>Cookies and Similar Technologies:</strong> we may use cookies and related technologies
                            to improve user experience, remember preferences, and analyze traffic.
                        </li>
                    </ul>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">2. How We Use Your Information</h4>
                    <p>We use your information for the following purposes:</p>
                    <ul class="ps-3">
                        <li class="mb-2">To provide, maintain, and improve our website and services.</li>
                        <li class="mb-2">To respond to your inquiries, support requests, and service-related communications.</li>
                        <li class="mb-2">To manage your account and deliver requested services.</li>
                        <li class="mb-2">To enable social media connection and publishing features for connected Facebook Pages and Instagram accounts.</li>
                        <li class="mb-2">To monitor, analyze, and improve the performance and security of our platform.</li>
                        <li class="mb-2">To comply with legal obligations and prevent misuse, fraud, or unauthorized activity.</li>
                    </ul>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">3. Facebook and Instagram Data Usage</h4>
                    <p>
                        If you choose to connect your Facebook or Instagram account with our platform, we may access and use
                        certain data made available through Meta’s APIs strictly for providing requested features.
                    </p>
                    <ul class="ps-3">
                        <li class="mb-2">To identify the Facebook Pages connected to your account.</li>
                        <li class="mb-2">To identify linked Instagram professional/business accounts.</li>
                        <li class="mb-2">To allow you to publish approved content through our platform.</li>
                        <li class="mb-2">To store connection details required for account linking and publishing functionality.</li>
                    </ul>
                    <p class="mb-0">
                        We do not sell your Facebook or Instagram data to third parties. We only use such data as necessary
                        to provide the features you authorize.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">4. Disclosure of Information</h4>
                    <p>We may share your information only in the following situations:</p>
                    <ul class="ps-3">
                        <li class="mb-2">
                            <strong>Service Providers:</strong> with trusted vendors or partners who help us operate our
                            services, such as hosting, technical support, communication tools, or analytics providers.
                        </li>
                        <li class="mb-2">
                            <strong>Legal Compliance:</strong> where required by law, regulation, court order, or valid governmental request.
                        </li>
                        <li class="mb-2">
                            <strong>Business Transfers:</strong> in connection with a merger, sale, restructuring, or transfer
                            of business assets, subject to appropriate confidentiality measures.
                        </li>
                    </ul>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">5. Data Retention</h4>
                    <p class="mb-0">
                        We retain personal information only for as long as necessary to fulfill the purposes described in this
                        Privacy Policy, comply with legal obligations, resolve disputes, and enforce our agreements. Social account
                        connection data may be removed when an account is disconnected, access is revoked, or a deletion request is processed.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">6. Security of Your Information</h4>
                    <p class="mb-0">
                        We use reasonable administrative, technical, and organizational safeguards to protect your information
                        against unauthorized access, loss, misuse, or alteration. However, no system can guarantee complete security,
                        and you share information with us at your own risk.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">7. Third-Party Services and Links</h4>
                    <p class="mb-0">
                        Our website or services may contain links to third-party websites, tools, or platforms. We are not responsible
                        for the privacy practices, policies, or content of those third-party services. We encourage you to review their
                        privacy policies before sharing any personal information.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">8. Your Rights and Choices</h4>
                    <p>You may have the right to:</p>
                    <ul class="ps-3">
                        <li class="mb-2">Request access to the personal information we hold about you.</li>
                        <li class="mb-2">Request correction of inaccurate or incomplete information.</li>
                        <li class="mb-2">Request deletion of your personal information, subject to legal or operational requirements.</li>
                        <li class="mb-2">Request removal of connected social account data by disconnecting the account or contacting us.</li>
                        <li class="mb-2">Opt out of promotional communications where applicable.</li>
                    </ul>
                    <p class="mb-0">
                        To exercise any of these rights, please contact us using the contact details provided below.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">9. User Data Deletion</h4>
                    <p>
                        If you would like us to delete your personal data or data related to connected Facebook/Instagram accounts,
                        you may request deletion by contacting us at:
                    </p>
                    <ul class="ps-3 mb-3">
                        <li class="mb-2"><strong>Email:</strong> realvictorygroups@gmail.com</li>
                        <li class="mb-2"><strong>Phone:</strong> +91 7753800444</li>
                        <li class="mb-2"><strong>Website:</strong> https://www.realvictorygroups.com</li>
                    </ul>
                    <p class="mb-0">
                        Upon receiving a valid request, we will review and process it within a reasonable time, subject to
                        any legal or operational obligations requiring retention.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">10. Content Usage Disclaimer</h4>
                    <p>
                        At <strong>Real Victory Groups</strong>, we strive to provide high-quality creative and promotional content.
                        Some visual elements such as images, icons, illustrations, or backgrounds may be sourced from publicly
                        available platforms or third-party libraries believed to be available for lawful use at the time of creation.
                    </p>
                    <ul class="ps-3">
                        <li class="mb-2">
                            We do not claim ownership of third-party content unless explicitly stated.
                        </li>
                        <li class="mb-2">
                            While we make reasonable efforts to avoid unauthorized usage, we cannot guarantee that every third-party
                            asset is free from all restrictions in every jurisdiction or use case.
                        </li>
                        <li class="mb-2">
                            Clients are advised to independently verify suitability if they require fully exclusive, licensed,
                            or commercially restricted assets.
                        </li>
                        <li class="mb-2">
                            If any copyright concern, claim, or takedown request is received, the concerned content should be removed
                            immediately until the matter is resolved.
                        </li>
                    </ul>
                    <p class="mb-0">
                        We also offer custom/premium creative services where original or properly licensed assets can be used
                        specifically for your brand requirements.
                    </p>
                </div>

                <div class="col-12 mb-4">
                    <h4 class="fw-bold mb-3">11. Changes to This Privacy Policy</h4>
                    <p class="mb-0">
                        We may update this Privacy Policy from time to time. Any updates will be posted on this page with a revised
                        effective date. Continued use of our website or services after such changes constitutes acceptance of the updated policy.
                    </p>
                </div>

                <div class="col-12">
                    <h4 class="fw-bold mb-3">12. Contact Us</h4>
                    <p class="mb-1"><strong>Real Victory Groups</strong></p>
                    <p class="mb-1">73 Basement, Ekta Enclave Society, Lakhanpur, Khyora, Kanpur, Uttar Pradesh 208024</p>
                    <p class="mb-1"><strong>Phone:</strong> +91 7753800444</p>
                    <p class="mb-1"><strong>Email:</strong> realvictorygroups@gmail.com</p>
                    <p class="mb-0"><strong>Website:</strong> https://www.realvictorygroups.com</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Privacy Policy End -->
@endsection