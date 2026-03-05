@extends('layouts.public')

@section('title', 'Privacy Policy - ConcertHub')
@section('description', 'Learn how ConcertHub protects your privacy and handles your personal information.')

@section('content')
<div class="bg-gradient-to-r from-purple-600 to-blue-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Privacy Policy</h1>
            <p class="text-xl text-purple-100">Last updated: {{ date('F d, Y') }}</p>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-md p-8 prose prose-lg max-w-none">
        
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">1. Introduction</h2>
            <p class="text-gray-600 mb-4">
                At ConcertHub, we respect your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our service.
            </p>
            <p class="text-gray-600 mb-4">
                Please read this Privacy Policy carefully. By using ConcertHub, you agree to the collection and use of information in accordance with this policy.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">2. Information We Collect</h2>
            
            <h3 class="text-xl font-semibold text-gray-800 mb-3">2.1 Personal Information</h3>
            <p class="text-gray-600 mb-4">
                When you register or use our services, we may collect:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Name and contact information (email, phone number, address)</li>
                <li>Account credentials (username, password)</li>
                <li>Payment information (credit card details, billing address)</li>
                <li>Date of birth and identification details</li>
                <li>Preferences and interests</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">2.2 Usage Data</h3>
            <p class="text-gray-600 mb-4">
                We automatically collect information about how you interact with our service:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>IP address and device information</li>
                <li>Browser type and version</li>
                <li>Pages visited and time spent</li>
                <li>Referring website addresses</li>
                <li>Search queries and interactions</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">2.3 Cookies and Tracking</h3>
            <p class="text-gray-600 mb-4">
                We use cookies and similar tracking technologies to enhance your experience and gather information about visitors and visits to our website.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">3. How We Use Your Information</h2>
            <p class="text-gray-600 mb-4">
                We use the information we collect for various purposes:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>To provide and maintain our service</li>
                <li>To process your bookings and payments</li>
                <li>To send you tickets and booking confirmations</li>
                <li>To communicate with you about your account or transactions</li>
                <li>To provide customer support</li>
                <li>To send marketing communications (with your consent)</li>
                <li>To personalize your experience</li>
                <li>To improve our service and develop new features</li>
                <li>To detect, prevent, and address technical issues or fraud</li>
                <li>To comply with legal obligations</li>
            </ul>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">4. Information Sharing and Disclosure</h2>
            
            <h3 class="text-xl font-semibold text-gray-800 mb-3">4.1 Third-Party Service Providers</h3>
            <p class="text-gray-600 mb-4">
                We may share your information with third parties who provide services on our behalf:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Payment processors</li>
                <li>Email service providers</li>
                <li>Analytics services</li>
                <li>Customer support tools</li>
                <li>Accommodation partners</li>
            </ul>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">4.2 Legal Requirements</h3>
            <p class="text-gray-600 mb-4">
                We may disclose your information if required to do so by law or in response to valid requests by public authorities.
            </p>

            <h3 class="text-xl font-semibold text-gray-800 mb-3">4.3 Business Transfers</h3>
            <p class="text-gray-600 mb-4">
                In the event of a merger, acquisition, or sale of assets, your information may be transferred as part of that transaction.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">5. Data Security</h2>
            <p class="text-gray-600 mb-4">
                We implement appropriate security measures to protect your personal information:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li>Encryption of data in transit and at rest</li>
                <li>Secure servers and databases</li>
                <li>Regular security audits and updates</li>
                <li>Access controls and authentication</li>
                <li>Employee training on data protection</li>
            </ul>
            <p class="text-gray-600 mb-4">
                However, no method of transmission over the Internet or electronic storage is 100% secure. While we strive to protect your data, we cannot guarantee absolute security.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">6. Your Rights and Choices</h2>
            <p class="text-gray-600 mb-4">
                You have certain rights regarding your personal information:
            </p>
            <ul class="list-disc list-inside text-gray-600 space-y-2 mb-4">
                <li><strong>Access:</strong> Request a copy of your personal data</li>
                <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                <li><strong>Deletion:</strong> Request deletion of your personal data</li>
                <li><strong>Objection:</strong> Object to processing of your data</li>
                <li><strong>Portability:</strong> Request transfer of your data</li>
                <li><strong>Withdraw Consent:</strong> Opt-out of marketing communications</li>
            </ul>
            <p class="text-gray-600 mb-4">
                To exercise these rights, please contact us at privacy@concerthub.com
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">7. Data Retention</h2>
            <p class="text-gray-600 mb-4">
                We retain your personal information only for as long as necessary to fulfill the purposes outlined in this Privacy Policy, unless a longer retention period is required by law.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">8. Children's Privacy</h2>
            <p class="text-gray-600 mb-4">
                Our service is not directed to individuals under the age of 13. We do not knowingly collect personal information from children. If you are a parent or guardian and believe your child has provided us with personal information, please contact us.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">9. International Data Transfers</h2>
            <p class="text-gray-600 mb-4">
                Your information may be transferred to and maintained on computers located outside of your jurisdiction where data protection laws may differ. We take steps to ensure your data is treated securely and in accordance with this Privacy Policy.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">10. Changes to This Privacy Policy</h2>
            <p class="text-gray-600 mb-4">
                We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. You are advised to review this Privacy Policy periodically for any changes.
            </p>
        </section>

        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">11. Contact Us</h2>
            <p class="text-gray-600 mb-4">
                If you have any questions about this Privacy Policy, please contact us:
            </p>
            <ul class="list-none text-gray-600 space-y-2">
                <li>📧 Email: privacy@concerthub.com</li>
                <li>📞 Phone: +1 (555) 123-4567</li>
                <li>🌐 Website: <a href="{{ route('public.help.contact') }}" class="text-purple-600 hover:underline">Contact Page</a></li>
                <li>📍 Address: 123 Concert Street, Music City, MC 12345</li>
            </ul>
        </section>

    </div>

    <!-- Important Notice -->
    <div class="mt-8 bg-blue-50 rounded-lg p-6 border-l-4 border-blue-600">
        <h3 class="font-bold text-gray-900 mb-2">Your Privacy Matters</h3>
        <p class="text-gray-700">
            We are committed to protecting your privacy and handling your data with care. If you have any concerns about how we handle your information, please don't hesitate to contact us.
        </p>
    </div>
</div>
@endsection

