@extends('layouts.public')

@section('title', 'Terms of Service - ConcertHub')
@section('description', 'Read our terms and conditions for using ConcertHub services.')

@section('content')
<div class="bg-gradient-to-r from-purple-600 to-blue-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Terms of Service</h1>
            <p class="text-xl text-purple-100">Last updated: {{ date('F d, Y') }}</p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-md p-8 prose prose-lg max-w-none">
        
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Acceptance of Terms</h2>
            <p class="text-gray-600 mb-4">
                By accessing and using ConcertHub ("the Service"), you accept and agree to be bound by the terms and provisions of this agreement. If you do not agree to these Terms of Service, please do not use the Service.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Use of Service</h2>
            <p class="text-gray-600 mb-4">
                ConcertHub provides a platform for discovering and booking concert tickets and related accommodations. You agree to:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Provide accurate, current, and complete information during registration</li>
                <li>Maintain the security of your password and account</li>
                <li>Notify us immediately of any unauthorized use of your account</li>
                <li>Use the Service only for lawful purposes and in accordance with these Terms</li>
                <li>Not attempt to gain unauthorized access to any portion of the Service</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. Ticket Purchases</h2>
            <p class="text-gray-600 mb-4">
                When you purchase tickets through ConcertHub:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>All sales are final unless the event is canceled or rescheduled</li>
                <li>Tickets are subject to availability and event-specific terms</li>
                <li>Prices are subject to change without notice until purchase is confirmed</li>
                <li>You may be required to present valid identification at the event</li>
                <li>Tickets cannot be resold for commercial purposes without authorization</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Cancellations and Refunds</h2>
            <p class="text-gray-600 mb-4">
                Cancellation and refund policies are detailed in our <a href="{{ route('public.pages.refund') }}" class="text-purple-600 hover:underline">Refund Policy</a>. Generally:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Event cancellations: Full refund within 7-10 business days</li>
                <li>User cancellations: Subject to timing and specific event policies</li>
                <li>Service fees may be non-refundable</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. User Conduct</h2>
            <p class="text-gray-600 mb-4">
                You agree not to:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Use the Service for any illegal or unauthorized purpose</li>
                <li>Violate any laws in your jurisdiction</li>
                <li>Infringe upon or violate the rights of others</li>
                <li>Transmit any viruses, worms, or malicious code</li>
                <li>Interfere with or disrupt the Service or servers</li>
                <li>Create multiple accounts to circumvent restrictions</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Intellectual Property</h2>
            <p class="text-gray-600 mb-4">
                The Service and its original content, features, and functionality are owned by ConcertHub and are protected by international copyright, trademark, patent, trade secret, and other intellectual property laws.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Limitation of Liability</h2>
            <p class="text-gray-600 mb-4">
                To the maximum extent permitted by law, ConcertHub shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Your use or inability to use the Service</li>
                <li>Any unauthorized access to or alteration of your data</li>
                <li>Any third-party conduct or content on the Service</li>
                <li>Event cancellations, postponements, or changes</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Third-Party Services</h2>
            <p class="text-gray-600 mb-4">
                Our Service may contain links to third-party websites or services (including accommodation providers and event venues) that are not owned or controlled by ConcertHub. We have no control over, and assume no responsibility for, the content, privacy policies, or practices of any third-party websites or services.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">9. Privacy</h2>
            <p class="text-gray-600 mb-4">
                Your use of the Service is also governed by our <a href="{{ route('public.pages.privacy') }}" class="text-purple-600 hover:underline">Privacy Policy</a>. Please review our Privacy Policy to understand our practices regarding your personal information.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Account Termination</h2>
            <p class="text-gray-600 mb-4">
                We reserve the right to terminate or suspend your account and access to the Service immediately, without prior notice or liability, for any reason, including but not limited to a breach of these Terms.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Changes to Terms</h2>
            <p class="text-gray-600 mb-4">
                We reserve the right to modify or replace these Terms at any time. We will provide notice of any significant changes by posting the new Terms on this page and updating the "Last updated" date. Your continued use of the Service after such changes constitutes acceptance of the new Terms.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">12. Governing Law</h2>
            <p class="text-gray-600 mb-4">
                These Terms shall be governed and construed in accordance with applicable laws, without regard to its conflict of law provisions.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">13. Contact Us</h2>
            <p class="text-gray-600 mb-4">
                If you have any questions about these Terms, please contact us:
            </p>
            <ul class="list-none text-gray-600 space-y-2">
                <li>📧 Email: legal@concerthub.com</li>
                <li>📞 Phone: +1 (555) 123-4567</li>
                <li>🌐 Website: <a href="{{ route('public.help.contact') }}" class="text-purple-600 hover:underline">Contact Page</a></li>
            </ul>
        </section>

    </div>

    <!-- Agreement Notice -->
    <div class="mt-8 bg-purple-50 rounded-lg p-6 border-l-4 border-purple-600">
        <p class="text-gray-700">
            <strong>Important:</strong> By using ConcertHub, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.
        </p>
    </div>
</div>
@endsection

