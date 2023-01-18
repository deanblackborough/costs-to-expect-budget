<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Budget by Costs to Expect - Simplified Budgeting">
        <meta name="author" content="Dean Blackborough">
        <title>Budget: Privacy Policy</title>
        <link rel="icon" sizes="48x48" href="{{ asset('images/favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon.png') }}">
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet"/>
        <x-open-graph />
        <x-twitter-card />
        <style>
            .site-header {
                background-color: #000000;
                -webkit-backdrop-filter: saturate(180%) blur(20px);
                backdrop-filter: saturate(180%) blur(20px);
            }
        </style>
    </head>
    <body>

        @auth
        <x-offcanvas active="privacy-policy"/>
        @else
        <header class="site-header sticky-top py-1">
            <nav class="container-fluid d-flex navbar-dark">
                <a class="navbar-brand p-0 me-0 me-lg-2" href="{{ route('landing') }}" aria-label="Budget by Costs to Expect">
                    <img src="{{ asset('images/logo.png') }}" alt="Costs to Expect Logo" width="40" height="40" title="Costs to Expect" />
                </a>
                <ul class="navbar-nav flex-row flex-wrap bd-navbar-nav">
                    <li class="nav-item px-1">
                        <a class="nav-link py-2 px-1 px-lg-2" href="{{ route('version-compare') }}">Versions</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link py-2 px-1 px-lg-2 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Budgeting
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('what-is-budgeting') }}">What is Budgeting?</a></li>
                            <li><a class="dropdown-item" href="">Page 2</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link py-2 px-1 px-lg-2 active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Support
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('getting-started') }}">Getting Started</a></li>
                            <li><a class="dropdown-item" href="{{ route('workflow') }}">Workflow</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('help.add-expense') }}">How do I add an expense item?</a></li>
                            <li><a class="dropdown-item" href="{{ route('help.add-income') }}">How do I add an income item?</a></li>
                            <li><a class="dropdown-item" href="{{ route('help.add-savings') }}">How do I add a savings item?</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('faqs') }}">FAQs</a></li>
                            <li><a class="dropdown-item" href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        @endauth

        <div class="col-lg-8 mx-auto p-3">

            <div class="row">
                <div class="col-12">
                    <h2 class="display-5 mt-3 mb-3">Privacy Policy</h2>

                    <p class="lead">
                        Your privacy is important to us. It is our policy to respect your privacy regarding any
                        information we may collect from you across our <a href="https://budget.costs-to-expect.com">website</a>,
                        and other sites in the Costs to Expect service that we own and operate.
                    </p>
                    <p class="lead">
                        We only ask for personal information when we truly need it to provide a service to you.
                        We collect it by fair and lawful means, with your knowledge and consent. We also let you
                        know why we’re collecting it and how it will be used.
                    </p>
                    <p class="lead">
                        We only retain collected information for as long as necessary to provide you with your
                        requested service. Any data that we store will be protected within commercially acceptable
                        means to prevent loss and theft, as well as unauthorised access, disclosure, copying, use
                        or modification.
                    </p>
                    <p class="lead">
                        We don’t share any personally identifying information publicly or with third-parties, except
                        when required to by law.
                    </p>
                    <p class="lead">
                        Our website may link to external sites that are not operated by us. Please be aware that
                        we have no control over the content and practices of these sites, and cannot accept
                        responsibility or liability for their respective privacy policies.
                    </p>
                    <p class="lead">
                        You are free to refuse our request for your personal information, with the understanding
                        that we may be unable to provide you with some of your desired services.
                    </p>
                    <p class="lead">
                        Your continued use of our website will be regarded as acceptance of our practices around
                        privacy and personal information. If you have any questions about how we
                        handle user data and personal information, feel free to contact us.
                    </p>
                    <p>
                        This policy is effective as of the 12th January 2023.
                    </p>
                </div>
            </div>

            <x-footer />
        </div>
        <script src="{{ asset('node_modules/@popperjs/core/dist/umd/popper.min.js') }}" defer></script>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}" defer></script>
    </body>
</html>
