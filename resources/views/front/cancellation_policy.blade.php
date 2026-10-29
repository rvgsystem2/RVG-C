
@extends('component.main', ['seos' => $seos])

@section('content')

<style>
    .policy-link {
        color: #075bb5 !important;
        text-decoration: underline !important;
        text-underline-offset: 3px;
        overflow-wrap: anywhere;
        font-weight: 600;
    }
    .policy-link:hover, .policy-link:focus {
        color: #003c7b !important;
        text-decoration-thickness: 2px !important;
    }
</style>

@include('front.partials.page-hero', ['eyebrow'=>'Information', 'title'=>'Cancellation Policy'])

<!-- Cancellation Policy Start -->
<div class="container-fluid my-lg-5 my-4">
    <div class="container">
        <div class="row shadow-lg rounded p-lg-5 p-md-4 p-3">
            <div class="col-12">

                <h2 class="text-center mb-4">
                    Cancellation Policy
                </h2>

                <p class="mb-4">
                    <strong>Last Updated:</strong> 28 October 2026
                </p>

                <p>
                    At Real Victory Groups, we strive to provide reliable
                    IT services, digital solutions, and subscription-based
                    software products. This Cancellation Policy explains
                    how customers can request cancellation of services,
                    projects, orders, and subscriptions.
                </p>

                <p>
                    This policy should be read together with our
                    Terms &amp; Conditions, Refund Policy, and any applicable
                    quotation or service agreement.
                </p>

                <!-- Section 1 -->
                <h3 class="mt-4 mb-3">
                    1. General Cancellation Policy
                </h3>

                <p>
                    Customers may request cancellation of services purchased
                    from Real Victory Groups by contacting our support team.
                </p>

                <p>
                    Cancellation requests are reviewed based on the type
                    of service, project execution status, subscription
                    period, and applicable contractual commitments.
                </p>

                <p>
                    Submitting a cancellation request does not automatically
                    guarantee a refund.
                </p>

                <!-- Section 2 -->
                <h3 class="mt-4 mb-3">
                    2. Cancellation of Website and Software Development Projects
                </h3>

                <p>
                    For website development, mobile application development,
                    custom software development, e-commerce development,
                    and other project-based services:
                </p>

                <ul>
                    <li>
                        Customers may request cancellation before project
                        execution begins.
                    </li>

                    <li>
                        Cancellation before commencement may qualify for
                        a refund, subject to the Refund Policy.
                    </li>

                    <li>
                        Once planning, design, development, or execution
                        has commenced, applicable work charges and
                        committed expenses will remain payable.
                    </li>

                    <li>
                        Any completed work, allocated resources, and
                        non-recoverable third-party expenses may be
                        deducted from eligible refunds.
                    </li>

                    <li>
                        Cancellation after final delivery or project
                        completion will not normally qualify for a refund,
                        except as required by law or agreed in writing.
                    </li>
                </ul>

                <!-- Section 3 -->
                <h3 class="mt-4 mb-3">
                    3. Cancellation of Graphic Design and Digital Marketing Services
                </h3>

                <p>
                    Customers may request cancellation of graphic design,
                    branding, video editing, SEO, digital marketing,
                    social media management, and related services.
                </p>

                <ul>
                    <li>
                        Cancellation requests should be submitted before
                        the next billing or service period.
                    </li>

                    <li>
                        Charges for work already completed or services
                        already delivered are non-refundable.
                    </li>

                    <li>
                        Advertising expenses, third-party subscriptions,
                        and committed vendor payments remain payable.
                    </li>

                    <li>
                        Services subject to a minimum contractual term
                        or notice period may only be cancelled in
                        accordance with the agreed service contract.
                    </li>
                </ul>

                <!-- Section 4 -->
                <h3 class="mt-4 mb-3">
                    4. Cancellation of SaaS and Software Subscriptions
                </h3>

                <p>
                    Real Victory Groups provides subscription-based
                    digital products and business software solutions.
                </p>

                <p>
                    For monthly, yearly, and other recurring subscription plans:
                </p>

                <ul>
                    <li>
                        Customers may request cancellation of future
                        subscription renewals.
                    </li>

                    <li>
                        Unless the applicable plan states otherwise,
                        cancellation requests should be submitted at least
                        <strong>7 days before the next renewal date</strong>.
                    </li>

                    <li>
                        Where automatic renewal is enabled and authorised
                        by the customer, the subscription will continue
                        renewing until cancelled according to the
                        applicable terms.
                    </li>

                    <li>
                        Cancellation will generally take effect at the
                        end of the current paid subscription period.
                    </li>

                    <li>
                        Customers may continue accessing subscribed
                        services until the end of their active paid
                        period, subject to the applicable
                        Terms &amp; Conditions.
                    </li>

                    <li>
                        Cancellation does not normally entitle customers
                        to refunds for unused subscription days or months.
                    </li>

                    <li>
                        After the subscription expires, access to paid
                        features may be restricted or discontinued.
                    </li>
                </ul>

                <!-- Section 5 -->
                <h3 class="mt-4 mb-3">
                    5. Cancellation of Annual Service Packages
                </h3>

                <p>
                    For annual graphic design packages, digital marketing
                    packages, maintenance contracts, and other yearly services:
                </p>

                <ul>
                    <li>
                        Customers may request cancellation of future renewals.
                    </li>

                    <li>
                        Cancellation during an active annual service
                        period does not normally qualify for a
                        proportional refund.
                    </li>

                    <li>
                        Services already delivered, resources allocated,
                        and committed expenses remain chargeable.
                    </li>

                    <li>
                        Cancellation of future renewals does not
                        automatically cancel outstanding invoices
                        or contractual obligations.
                    </li>
                </ul>

                <!-- Section 6 -->
                <h3 class="mt-4 mb-3">
                    6. Cancellation of Third-Party Services
                </h3>

                <p>
                    Services involving third-party providers, including
                    domain registration, hosting, cloud servers, APIs,
                    software licenses, and advertising platforms, are
                    subject to the respective providers' cancellation terms.
                </p>

                <p>
                    Real Victory Groups cannot guarantee cancellation
                    or refunds for charges already committed to
                    third-party providers.
                </p>

                <!-- Section 7 -->
                <h3 class="mt-4 mb-3">
                    7. How to Request Cancellation
                </h3>

                <p>
                    Customers can submit a cancellation request through
                    the official contact channels listed on our
                    <a href="https://www.realvictorygroups.com" class="policy-link"
                       target="_blank" rel="noopener noreferrer">website (https://www.realvictorygroups.com)</a>.
                </p>

                <p>The request should include:</p>

                <ul>
                    <li>Customer or business name.</li>
                    <li>Registered mobile number or email address.</li>
                    <li>Invoice number, order ID, or subscription details.</li>
                    <li>Name of the service to be cancelled.</li>
                    <li>Reason for cancellation.</li>
                    <li>Requested cancellation date.</li>
                </ul>

                <p>
                    Our team will review the request and communicate
                    the applicable cancellation conditions.
                </p>

                <!-- Section 8 -->
                <h3 class="mt-4 mb-3">
                    8. Cancellation Confirmation
                </h3>

                <p>
                    Cancellation requests will be reviewed and confirmed
                    after verification of customer details, service status,
                    and contractual obligations.
                </p>

                <p>
                    Customers should retain the written cancellation
                    confirmation for future reference.
                </p>

                <p>
                    A cancellation request is not considered fully
                    processed until confirmed by Real Victory Groups.
                </p>

                <!-- Section 9 -->
                <h3 class="mt-4 mb-3">
                    9. Service Suspension or Termination
                </h3>

                <p>
                    Real Victory Groups may suspend or terminate services
                    in accordance with its Terms &amp; Conditions
                    in cases involving:
                </p>

                <ul>
                    <li>Non-payment or overdue invoices.</li>
                    <li>Fraudulent or unauthorised activities.</li>
                    <li>Violation of applicable laws or service terms.</li>
                    <li>Misuse of software, platforms, or technical infrastructure.</li>
                    <li>Material breach of contractual obligations.</li>
                </ul>

                <p>
                    Any outstanding payments and liabilities will remain
                    subject to the applicable agreement and law.
                </p>

                <!-- Section 10 -->
                <h3 class="mt-4 mb-3">
                    10. Refunds After Cancellation
                </h3>

                <p>
                    Cancellation and refund eligibility are separate matters.
                </p>

                <p>
                    Any refund arising from an approved cancellation
                    will be governed by our Refund Policy.
                </p>

                <p>
                    Where a refund is approved, the amount will generally
                    be credited within <strong>6–8 days</strong>,
                    subject to payment gateway and banking timelines.
                </p>

                <!-- Section 11 -->
                <h3 class="mt-4 mb-3">
                    11. Contract-Specific Cancellation Terms
                </h3>

                <p>
                    Where a signed quotation, service agreement,
                    subscription plan, or other written contract
                    specifies a minimum commitment period, notice
                    requirement, or cancellation charges, those
                    specific terms will apply to the extent
                    permitted by law.
                </p>

                <!-- Section 12 -->
                <h3 class="mt-4 mb-3">
                    12. Changes to This Policy
                </h3>

                <p>
                    Real Victory Groups may update this Cancellation
                    Policy from time to time.
                </p>

                <p>
                    Changes will be published on our official website.
                    Any changes affecting existing contractual rights
                    will be subject to applicable law and
                    contractual obligations.
                </p>

                <!-- Section 13 -->
                <h3 class="mt-4 mb-3">
                    13. Contact Information
                </h3>

                <p>
                    <strong>Business Name:</strong>
                    Real Victory Groups
                </p>

                <p>
                    <strong>Business Type:</strong>
                    Sole Proprietorship
                </p>

                <p>
                    <strong>Website:</strong>
                    <a href="https://www.realvictorygroups.com"
                       class="policy-link"
                       target="_blank"
                       rel="noopener noreferrer">
                        https://www.realvictorygroups.com
                    </a>
                </p>

                <p>
                    <strong>Phone:</strong>
                    <a href="tel:+918299012292" class="policy-link">
                        +91 8299012292
                    </a>
                </p>

                <p>
                    <strong>Address:</strong>
                    <a href="https://www.google.com/maps/search/?api=1&amp;query=73%20Basement%2C%20Ekta%20Enclave%20Society%2C%20Lakhanpur%2C%20Khyora%2C%20Kanpur%2C%20Uttar%20Pradesh%20208024%2C%20India"
                       class="policy-link"
                       target="_blank"
                       rel="noopener noreferrer">
                        73 Basement, Ekta Enclave Society,
                        Lakhanpur, Khyora, Kanpur,
                        Uttar Pradesh – 208024, India.
                    </a>
                </p>

                <p>
                    For cancellation-related assistance, customers
                    may contact us through our
                    <a href="https://www.realvictorygroups.com" class="policy-link"
                       target="_blank" rel="noopener noreferrer">official website (https://www.realvictorygroups.com)</a>
                    or call <a href="tel:+918299012292" class="policy-link">+91 8299012292</a>.
                </p>

            </div>
        </div>
    </div>
</div>
<!-- Cancellation Policy End -->

@endsection
