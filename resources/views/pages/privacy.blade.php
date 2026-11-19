@use('App\Support\Site')
<x-layouts.app :seo="$seo">
    <x-ui.legal-page title="Privacy Policy" updated="2026-09-17" :breadcrumbs="[['name' => 'Home', 'url' => route('home')], ['name' => 'Privacy Policy', 'url' => route('privacy')]]">
        <p>This Privacy Policy explains how {{ Site::legalName() }} (“{{ Site::name() }}”, “we”, “us”) collects, uses and protects personal information when you use our website at {{ Site::url() }} (the “Website”) or contact us about our products and services.</p>

        <h2>Information we collect</h2>
        <p>We collect information you provide directly, and limited technical information generated when you use the Website.</p>
        <ul>
            <li><strong>Enquiry information.</strong> When you submit our contact form or reach us by email, phone or WhatsApp, we collect the details you provide: name, business name, phone number, email address, the service you are interested in, an approximate budget and your message.</li>
            <li><strong>Technical information.</strong> When you submit a form we record the IP address, browser user agent and referring page to protect against abuse. Our hosting provider may also keep standard server logs.</li>
            <li><strong>Analytics.</strong> If analytics are enabled on the Website, we use Google Analytics with IP anonymisation to understand how visitors use the site in aggregate. You can opt out using browser settings or Google's opt-out tools.</li>
        </ul>
        <p>We do not knowingly collect information from children, and the Website is intended for business use.</p>

        <h2>How we use information</h2>
        <ul>
            <li>To respond to your enquiry and discuss products or services you have asked about.</li>
            <li>To prepare proposals, demos and quotations.</li>
            <li>To provide, support and improve our products and services if you become a client.</li>
            <li>To protect the Website and our systems against spam, fraud and abuse.</li>
            <li>To comply with legal obligations.</li>
        </ul>
        <p>We do not sell personal information. We do not send marketing messages unless you have agreed to receive them, and you can withdraw consent at any time.</p>

        <h2>Legal basis and consent</h2>
        <p>We process enquiry information because you have asked us to respond to you and because we have a legitimate interest in operating our business. Where consent is required, we ask for it clearly and you may withdraw it at any time by contacting us.</p>

        <h2>Sharing of information</h2>
        <p>We share personal information only with service providers who help us operate the Website and our business — such as hosting, email delivery and analytics providers — under agreements that restrict their use of the data. We may also disclose information where required by law.</p>

        <h2>Data retention</h2>
        <p>Enquiry records are kept for as long as needed to respond to you and for a reasonable period afterwards for follow-up and record keeping. Client project records are retained for the duration of our relationship and as required by law or contract. You may ask us to delete your enquiry data at any time, subject to legal requirements.</p>

        <h2>Security</h2>
        <p>We apply appropriate technical and organisational measures to protect personal information, including encrypted connections (HTTPS), access controls and secure storage. No method of transmission or storage is completely secure, but we work to protect your information in line with industry practice.</p>

        <h2>Cookies</h2>
        <p>The Website uses strictly necessary cookies to keep forms secure (for example, protection against cross-site request forgery) and to maintain your session. Analytics cookies are used only if analytics are enabled. You can control cookies through your browser settings.</p>

        <h2>Your rights</h2>
        <p>You may request access to, correction of, or deletion of the personal information we hold about you, and you may object to or restrict certain processing. To exercise these rights, contact us using the details below. We will respond within a reasonable time.</p>

        <h2>Third-party links</h2>
        <p>The Website may link to third-party sites such as WhatsApp or social networks. Their privacy practices are governed by their own policies.</p>

        <h2>Changes to this policy</h2>
        <p>We may update this policy from time to time. The “last updated” date at the top indicates the most recent revision. Significant changes will be highlighted on this page.</p>

        <h2>Contact</h2>
        <p>Questions about this policy or your personal information can be sent to {{ Site::name() }}@if(Site::email()) at <a href="mailto:{{ Site::email() }}">{{ Site::email() }}</a>@endif, or through our <a href="{{ route('contact.show') }}">contact page</a>.</p>
    </x-ui.legal-page>
</x-layouts.app>
