@use('App\Support\Site')
<x-layouts.app :seo="$seo">
    <x-ui.legal-page title="Terms &amp; Conditions" updated="2026-09-17" :breadcrumbs="[['name' => __('Home'), 'url' => route('home')], ['name' => __('Terms & Conditions'), 'url' => route('terms')]]">
        <p>These Terms and Conditions (“Terms”) govern your use of the {{ Site::name() }} website at {{ Site::url() }} (the “Website”) and set out the general basis on which {{ Site::legalName() }} (“{{ Site::name() }}”, “we”, “us”) provides software products and development services. Specific projects are governed by a separate written agreement, which takes precedence over these Terms where they differ.</p>

        <h2>1. Use of the Website</h2>
        <p>You may use the Website for lawful purposes to learn about our products and services and to contact us. You agree not to misuse the Website, attempt to gain unauthorised access to it, interfere with its operation, or submit false, misleading or abusive content through our forms.</p>

        <h2>2. Information on the Website</h2>
        <p>We take care to keep the Website accurate and up to date, but product features, technologies, timelines and pricing described on the Website are indicative and may change. Nothing on the Website constitutes a binding offer; binding terms are set out in written proposals and agreements.</p>

        <h2>3. Enquiries, proposals and quotations</h2>
        <p>Submitting an enquiry does not create a contract. Following a consultation we may provide a proposal or quotation, which is valid for the period stated in it. A project begins only when both parties have accepted a written agreement or purchase order and any agreed advance payment has been received.</p>

        <h2>4. Products and services</h2>
        <p>Software products are supplied under the licence terms described in the relevant product agreement. Development services are delivered according to the scope, milestones and acceptance criteria defined in the project agreement. Changes to scope are agreed in writing and may affect timeline and cost.</p>

        <h2>5. Payment</h2>
        <p>Fees, payment schedules and accepted payment methods are set out in each proposal or agreement. Unless otherwise stated, invoices are payable on the dates shown, and we may suspend work or services where payment is overdue after notice.</p>

        <h2>6. Intellectual property</h2>
        <p>The Website, its design, text, graphics and code are owned by {{ Site::name() }} or its licensors and may not be reproduced without permission, except for personal, non-commercial reference. Ownership of software delivered under a project — including whether source code is transferred to the client — is defined in the project agreement. Unless otherwise agreed in writing, custom-developed source code is transferred to the client on full payment, while {{ Site::name() }} retains ownership of its pre-existing products, tools and libraries.</p>

        <h2>7. Client responsibilities</h2>
        <p>Clients agree to provide timely information, content, access and feedback needed to deliver a project, to nominate a decision-maker, and to ensure that content and data they supply do not infringe third-party rights or applicable law.</p>

        <h2>8. Warranties and support</h2>
        <p>Delivered software is covered by the warranty period stated in the project agreement, during which we correct defects that prevent it from operating as specified. Ongoing maintenance and support are provided under separate support plans. Except as expressly stated in a written agreement, software and services are provided without further warranties to the extent permitted by law.</p>

        <h2>9. Limitation of liability</h2>
        <p>To the extent permitted by applicable law, {{ Site::name() }} is not liable for indirect, incidental or consequential losses, including loss of profit, revenue or data, arising from use of the Website or from services, and our total liability in connection with any project is limited to the fees paid for that project unless a written agreement provides otherwise. Nothing in these Terms limits liability that cannot be limited by law.</p>

        <h2>10. Third-party services</h2>
        <p>Projects may rely on third-party services such as hosting, payment gateways, SMS providers or courier APIs. These are governed by the third parties' own terms and fees, and we are not responsible for their availability or changes to their services.</p>

        <h2>11. Confidentiality</h2>
        <p>Both parties agree to keep confidential information received from the other party confidential and to use it only for the purposes of the engagement. We are happy to sign a non-disclosure agreement on request.</p>

        <h2>12. Privacy</h2>
        <p>Personal information is handled in accordance with our <a href="{{ route('privacy') }}">Privacy Policy</a>.</p>

        <h2>13. Governing law</h2>
        <p>These Terms are governed by the laws of Bangladesh. Disputes that cannot be resolved amicably are subject to the jurisdiction of the courts of Dhaka, Bangladesh, unless a project agreement specifies otherwise.</p>

        <h2>14. Changes</h2>
        <p>We may update these Terms from time to time. The “last updated” date indicates the current version. Continued use of the Website after changes constitutes acceptance of the revised Terms.</p>

        <h2>15. Contact</h2>
        <p>Questions about these Terms can be sent to {{ Site::name() }}@if(Site::email()) at <a href="mailto:{{ Site::email() }}">{{ Site::email() }}</a>@endif, or through our <a href="{{ route('contact.show') }}">contact page</a>.</p>
    </x-ui.legal-page>
</x-layouts.app>
