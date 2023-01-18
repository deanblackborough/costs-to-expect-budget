<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Budget by Costs to Expect - Simplified Budgeting">
        <meta name="author" content="Dean Blackborough">
        <title>Budget: What is Budgeting?</title>
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
        <x-offcanvas active="what-is-budgeting"/>
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
                        <a class="nav-link py-2 px-1 px-lg-2 active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Budgeting
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('what-is-budgeting') }}">What is Budgeting?</a></li>
                            <li><a class="dropdown-item" href="">Page 2</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link py-2 px-1 px-lg-2 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                    <h2 class="display-5 mt-3 mb-3">What is Budgeting</h2>

                    <p class="lead">
                        Budgeting is simply the process of balancing your income and outcome and thus creating a plan
                        for how you'll spend your money. It's that simple.
                    </p>
                    <p class="lead">
                        Creating a budget can help you to determine whether you'll have enough cash-flow to do what
                        you need/want to and can help you to identify where you might be able to make savings.
                    </p>
                    <p class="lead">
                        Budgeting can also help you to build up an emergency fund so that you're prepared for
                        those unexpected costs which catch most of us out.
                    </p>
                    <p class="lead">
                        There are several different approaches to budgeting and what works for one person, may not
                        work for someone else:
                    </p>

                    <h3>Zero-based budgeting</h3>

                    <p class="lead">
                        The aim of this approach is to ensure that every single pound (dollar/euro etc) of your
                        income is accounted for in your expenditure. Your income minus your expenses equals zero
                        every month.
                    </p>
                    <p class="lead">
                        So if you earn &pound;2,000 per month, you will plan where every single &pound; will go.
                    </p>

                    <h3>50/30/20 Budget Plan</h3>

                    <p class="lead">
                        This is a common budget approach and allows much more flexibility. The goal is that 50&percnt; of
                        your income goes towards the essentials - food, mortgage/rent and bills. 30&percnt; goes towards
                        "wants", or what we call the "fun stuff" – takeouts, days out and holidays.
                    </p>

                    <p class="lead">
                        Yes, you read that correctly - a budget is not about restricting what you spend, more
                        about planning what you spend.
                    </p>

                    <p class="lead">
                        The last 20&percnt; of your income goes into savings or investments.
                    </p>

                    <p class="lead">
                        Our Budget App provides an indication of which categories your expenses fall into.
                    </p>

                    <h3>The Reverse Budget</h3>

                    <p class="lead">
                        This method of budgeting turns the traditional approach on its head by putting saving ahead
                        of any other expenses. Save first and then spend. This prioritises your financial goals such
                        as paying off debt or saving for a mortgage. Once you have put money towards your financial
                        goals, you then pay your essential costs.
                    </p>

                    <p class="lead">
                        With this budgeting method, you won't have much left over but whatever you have can be
                        spent on the "fun stuff".
                    </p>

                    <h3>60&percnt; Solution Budget</h3>

                    <p class="lead">
                        This approach to budgeting was coined by former MSN Money editor-in-chief
                        <a href="https://web.archive.org/web/20130127123532/http://web.utah.edu/basford/personalfinance/handouts/budgeting/The60Solution.htm">Richard Jenkins</a>,
                        who realised that traditional budgeting methods just weren't effective for him. His
                        budgeting approach is that 60&percnt; of gross income should go towards what Jenkins calls
                        "committed expenses" – mortgage, food, clothing etc. Jenkins acknowledges that 60&percnt; isn't a
                        magic figure – just what works for his circumstances.
                    </p>

                    <p class="lead">
                        The remaining 40&percnt; is divided equally and allocated into four pots: retirement savings,
                        long-term savings (for bigger purchases), short-term savings (for holidays) and the
                        all-important "fun stuff".
                    </p>

                    <p class="lead">
                        Whichever method of budgeting you opt for, our Budget App will help you take control of your
                        finances and plan your spending.  <a href="{{ route('home') }}">Let's get started</a>.
                    </p>
                </div>
            </div>

            <x-footer />
        </div>
        <script src="{{ asset('node_modules/@popperjs/core/dist/umd/popper.min.js') }}" defer></script>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}" defer></script>
    </body>
</html>
