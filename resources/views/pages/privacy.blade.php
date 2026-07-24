<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - Fixly</title>
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
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Privacy Policy</h1>
            <p class="text-sm text-gray-400">Last updated: {{ date('F Y') }}</p>
        </div>
    </section>

    <section class="py-16 px-6">
        <div class="max-w-3xl mx-auto legal-content">
            <h2>1. Information We Collect</h2>
            <p>When you use Fixly, we collect information you provide directly and information generated through your use of the platform:</p>
            <ul>
                <li><strong>Account Information:</strong> Name, email address, phone number, and password when you create an account.</li>
                <li><strong>Profile Information:</strong> Professional details, trade categories, service area, bio, and profile photos.</li>
                <li><strong>Job Information:</strong> Job descriptions, locations, budgets, and related communications.</li>
                <li><strong>Payment Information:</strong> Billing details processed through our secure payment partners. We do not store full credit card numbers.</li>
                <li><strong>Usage Data:</strong> Pages visited, features used, device information, and IP addresses.</li>
            </ul>

            <h2>2. How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Provide, maintain, and improve the Fixly platform.</li>
                <li>Connect customers with relevant professionals.</li>
                <li>Process payments and manage transactions.</li>
                <li>Send important account-related communications.</li>
                <li>Verify professional credentials and maintain platform trust.</li>
                <li>Analyze usage patterns to improve our services.</li>
                <li>Comply with legal obligations.</li>
            </ul>

            <h2>3. Information Sharing</h2>
            <p>We share your information only in the following circumstances:</p>
            <ul>
                <li><strong>Between Customers and Professionals:</strong> When a job is posted, relevant details are shared with matched professionals to facilitate the service.</li>
                <li><strong>Service Providers:</strong> We share data with trusted third-party services (payment processing, hosting, analytics) that help operate our platform.</li>
                <li><strong>Legal Requirements:</strong> When required by law, regulation, or legal process.</li>
                <li><strong>With Your Consent:</strong> When you explicitly authorize us to share your information.</li>
            </ul>

            <h2>4. Data Security</h2>
            <p>We implement industry-standard security measures to protect your personal information, including encryption in transit (SSL/TLS), secure data storage, and regular security audits. However, no method of transmission over the Internet is 100% secure.</p>

            <h2>5. Data Retention</h2>
            <p>We retain your information for as long as your account is active or as needed to provide services. If you delete your account, we will remove your personal data within 30 days, except where we need to retain certain information for legal or legitimate business purposes.</p>

            <h2>6. Your Rights</h2>
            <p>You have the right to:</p>
            <ul>
                <li>Access the personal information we hold about you.</li>
                <li>Request correction of inaccurate data.</li>
                <li>Request deletion of your personal data.</li>
                <li>Opt out of non-essential communications.</li>
                <li>Export your data in a portable format.</li>
            </ul>

            <h2>7. Cookies</h2>
            <p>Fixly uses cookies and similar technologies to maintain your session, remember your preferences, and analyze usage. You can control cookie settings through your browser preferences.</p>

            <h2>8. Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of significant changes by posting the new policy on this page and updating the "Last updated" date.</p>

            <h2>9. Contact Us</h2>
            <p>If you have questions about this Privacy Policy or how we handle your data, please contact us at <a href="mailto:privacy@fixly.co" class="text-[#E8823C] hover:underline">privacy@fixly.co</a> or visit our <a href="{{ route('contact') }}" class="text-[#E8823C] hover:underline">Contact page</a>.</p>
        </div>
    </section>

    @include('components.footer', ['footerData' => []])
    <script src="/js/theme-toggle.js"></script>
</body>
</html>
