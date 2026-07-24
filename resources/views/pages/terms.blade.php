<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service - Fixly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/dark-mode.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F5F1EA; color: #1f2937; }
        .legal-content h2 { font-size: 1.15rem; font-weight: 700; margin: 28px 0 10px; }
        .legal-content p, .legal-content li { font-size: 0.88rem; color: #4b5563; line-height: 1.8; }
        .legal-content ul { padding-left: 20px; margin: 8px 0; }
        .legal-content li { margin-bottom: 6px; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('components.navbar', ['navData' => []])

    <section class="brand-section pt-32 pb-16 px-6 text-center" style="background:#16302A; color:#fff;">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Terms of Service</h1>
            <p class="text-sm text-gray-400">Last updated: {{ date('F Y') }}</p>
        </div>
    </section>

    <section class="py-16 px-6">
        <div class="max-w-3xl mx-auto legal-content">
            <h2>1. Acceptance of Terms</h2>
            <p>By accessing or using Fixly, you agree to be bound by these Terms of Service. If you do not agree, please do not use the platform.</p>

            <h2>2. Platform Description</h2>
            <p>Fixly is a marketplace that connects homeowners (Customers) with home service professionals (Pros). We facilitate the connection but are not a party to any agreement between customers and professionals.</p>

            <h2>3. User Responsibilities</h2>
            <p><strong>Customers agree to:</strong></p>
            <ul>
                <li>Provide accurate job descriptions and location information.</li>
                <li>Communicate professionally with assigned professionals.</li>
                <li>Make payment for completed work as agreed.</li>
                <li>Leave honest reviews based on actual experiences.</li>
            </ul>
            <p><strong>Professionals agree to:</strong></p>
            <ul>
                <li>Maintain accurate profile and qualification information.</li>
                <li>Perform work to a professional standard.</li>
                <li>Honor quoted prices and agreed timelines.</li>
                <li>Maintain required insurance and licenses.</li>
                <li>Comply with all applicable local laws and regulations.</li>
            </ul>

            <h2>4. Platform's Role</h2>
            <p>Fixly acts as an intermediary. We do not:</p>
            <ul>
                <li>Employ or contract with professionals.</li>
                <li>Guarantee the quality of work performed.</li>
                <li>Resolve disputes between customers and professionals (though we may assist in mediation).</li>
                <li>Verify all claims made by users on the platform.</li>
            </ul>

            <h2>5. Payments</h2>
            <p>Payments processed through Fixly are handled by our secure payment partners. Platform fees may apply. All prices are agreed between customer and professional before work begins.</p>

            <h2>6. Disputes</h2>
            <p>If a dispute arises between a customer and a professional, Fixly encourages direct communication to resolve the issue. Fixly may, at its discretion, assist in mediation but is not obligated to do so. Users agree to release Fixly from liability for disputes arising from platform use.</p>

            <h2>7. Account Termination</h2>
            <p>We reserve the right to suspend or terminate accounts that violate these terms, engage in fraudulent behavior, or damage the platform's reputation. Users may also delete their accounts at any time.</p>

            <h2>8. Intellectual Property</h2>
            <p>All content on Fixly — including logos, design, text, and software — is the property of Fixly and protected by intellectual property laws. Users may not reproduce or distribute platform content without permission.</p>

            <h2>9. Limitation of Liability</h2>
            <p>Fixly is provided "as is" without warranties of any kind. We are not liable for damages arising from use of the platform, including but not limited to direct, indirect, incidental, or consequential damages.</p>

            <h2>10. Changes to Terms</h2>
            <p>We may update these Terms of Service from time to time. Continued use of the platform after changes constitutes acceptance of the updated terms.</p>

            <h2>11. Contact</h2>
            <p>Questions about these terms? Contact us at <a href="mailto:legal@fixly.co" class="text-[#E8823C] hover:underline">legal@fixly.co</a> or visit our <a href="{{ route('contact') }}" class="text-[#E8823C] hover:underline">Contact page</a>.</p>
        </div>
    </section>

    @include('components.footer', ['footerData' => []])
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
