<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Budget by Costs to Expect - Simplified Budgeting">
        <meta name="author" content="Dean Blackborough">
        <title>Budget: Edit Budget Item</title>
        <link rel="icon" sizes="48x48" href="{{ asset('images/favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/favicon.png') }}">
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet"/>
    </head>
    <body>

        <x-offcanvas active="home"/>

        <div class="col-lg-10 col-xl-9 mx-auto p-3">

            <div class="row">
                <div class="col-12 col-lg-5 mx-auto p-2">
                    <form action="{{ route('budget.item.update.process', ['item_id' => $item['id']]) }}" method="POST" class="row g-2">

                        @csrf

                        <div class="col-12">
                            <h2 class="display-5 mt-3 mb-3">Edit</h2>
                            <h5>Changes will affect all instances</h5>
                        </div>

                        <div class="col-6 col-md-6">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control form-control-sm <x-validation-error field='name' />" id="name" name="name" value="{{ old('name', $item['name']) }}" placeholder="Rent">
                            <x-validation-error-message field="name" />
                        </div>
                        <div class="col-6 col-md-6">
                            <label for="account" class="form-label">Account *</label>
                            <select id="account" name="account" class="form-select form-select-sm <x-validation-error field='account' />">
                                @foreach ($accounts as $__account)
                                    <option value="{{ $__account->id() }}" @if (old('account', $item['account']) !== null && old('account') === $__account->id()) selected="selected" @endif>{{ $__account->name() }}</option>
                                @endforeach
                                <x-validation-error-message field="account" />
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control form-control-sm <x-validation-error field='description' />" id="description" name="description" placeholder="An optional description of the expense/income">{{ old('description', $item['description']) }}</textarea>
                            <x-validation-error-message field="description" />
                        </div>
                        <div class="col-12">
                            <label for="frequency_option" class="form-label">Repeats *</label>
                            <select id="frequency_option" name="frequency_option" class="form-select form-select-sm <x-validation-error field='frequency_option' />" aria-describedby="frequency_optionHelpBlock">
                                <option value="monthly" @if (old('frequency_option', $item['frequency']['type']) === 'monthly') selected="selected" @endif>Monthly</option>
                                <option value="annually" @if (old('frequency_option', $item['frequency']['type']) === 'annually') selected="selected" @endif>Annually</option>
                                <option value="one-off" @if (old('frequency_option', $item['frequency']['type']) === 'one-off') selected="selected" @endif>One-Off</option>
                            </select>
                            <p id="frequency_optionHelpBlock" class="form-text">Please choose how often this item should repeat on your budget.</p>
                            <x-validation-error-message field="frequency_option" />
                        </div>
                        <div class="col-6 col-md-6">
                            <label for="start_date" class="form-label">Start Date *</label>
                            <input type="date" class="form-control form-control-sm <x-validation-error field='start_date' />" id="start_date" name="start_date" value="{{ old('start_date', $item['start_date']) }}">
                            <x-validation-error-message field="start_date" />
                        </div>
                        <div class="col-6 col-md-6" data-frequency="one-off">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control form-control-sm <x-validation-error field='end_date' />" id="end_date" name="end_date" value="{{ old('end_date', $item['end_date']) }}">
                            <x-validation-error-message field="end_date" />
                        </div>
                        <div class="col-6 col-md-6">
                            <label for="currency_id" class="form-label">Currency *</label>
                            <select id="currency_id" name="currency_id" class="form-select form-select-sm <x-validation-error field='currency_id' />">
                                <option value="{{ $currency['id'] }}" @if (old('currency_id', $item['currency']['id']) !== null && old('currency_id') === $currency['id']) selected="selected" @endif>{{ $currency['code'] }} - <x-currency :currency="$currency" /></option>
                            </select>
                            <x-validation-error-message field="currency_id" />
                        </div>
                        <div class="col-6 col-md-6">
                            <label for="amount" class="form-label">Amount *</label>
                            <input type="number" class="form-control form-control-sm <x-validation-error field='amount' /> to-fixed" id="amount" name="amount" placeholder="10.99" value="{{ old('amount', $item['amount']) }}" data-points="2" min="0" step="0.01">
                            <x-validation-error-message field="amount" />
                        </div>
                        <div class="col-6 col-md-6">
                            <label for="category" class="form-label">Type *</label>
                            <select id="category" name="category" class="form-select form-select-sm <x-validation-error field='category' />">
                                <optgroup label="Expense">
                                    <option value="fixed" @if (old('category', $item['category']) === 'fixed') selected="selected" @endif>Fixed</option>
                                    <option value="flexible" @if (old('category', $item['category']) === 'flexible') selected="selected" @endif>Flexible</option>
                                    @if ($has_savings_account)
                                    <option value="savings" @if (old('category', $item['category']) === 'savings') selected="selected" @endif>Savings</option>
                                    @endif
                                </optgroup>
                                <optgroup label="Income">
                                    <option value="income" @if (old('category', $item['category']) === 'income') selected="selected" @endif>Income</option>
                                </optgroup>
                            </select>
                            <x-validation-error-message field="category" />
                        </div>
                        <div class="col-6 col-md-6" data-savings="target_account">
                            <label for="target_account" class="form-label">Target Account *</label>
                            <select id="target_account" name="target_account" class="form-select form-select-sm <x-validation-error field='target_account' />">
                                @foreach ($accounts as $__account)
                                    @if ($__account->type() === 'savings')
                                    <option value="{{ $__account->id() }}" @if (old('target_account', $item['target_account']) !== null && old('target_account') === $__account->id()) selected="selected" @endif>{{ $__account->name() }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <x-validation-error-message field="target_account" />
                        </div>
                        <fieldset>
                            <legend class="col-form-label col-12 text-primary" data-frequency="monthly">Frequency Options</legend>
                            <div class="col-12" data-frequency="monthly">
                                <label for="monthly_day" class="form-label">Day of Month</label>
                                <input type="number" class="form-control form-control-sm <x-validation-error field='monthly_day' />" id="monthly_day" name="monthly_day" placeholder="5" value="{{ old('monthly_day', ($item['frequency']['type'] === 'monthly' ? $item['frequency']['day'] : null)) }}" aria-describedby="monthly_dayHelpBlock">
                                <div id="monthly_dayHelpBlock" class="form-text">Please set the day of the month this typically occurs</div>
                                <x-validation-error-message field="monthly_day" />
                            </div>
                            <legend class="col-form-label col-12 text-primary" data-frequency="annually">Frequency Options</legend>
                            <div class="row">
                                <div class="col-6" data-frequency="annually">
                                    <label for="annually_day" class="form-label">Day of Month</label>
                                    <input type="number" class="form-control form-control-sm <x-validation-error field='annually_day' />" id="annually_day" name="annually_day" placeholder="5" value="{{ old('annually_day', ($item['frequency']['type'] === 'annually' ? $item['frequency']['day'] : null)) }}" aria-describedby="annually_dayHelpBlock">
                                    <div id="annually_dayHelpBlock" class="form-text">Please set the day of the month this typically occurs</div>
                                    <x-validation-error-message field="annually_day" />
                                </div>
                                <div class="col-6" data-frequency="annually">
                                    <label for="annually_month" class="form-label">Month *</label>
                                    <select id="annually_month" name="annually_month" class="form-select form-select-sm <x-validation-error field='annually_month' />">
                                        <option value="">Select month</option>
                                        <option value="1" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '1') selected="selected" @endif>January</option>
                                        <option value="2" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '2') selected="selected" @endif>February</option>
                                        <option value="3" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '3') selected="selected" @endif>March</option>
                                        <option value="4" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '4') selected="selected" @endif>April</option>
                                        <option value="5" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '5') selected="selected" @endif>May</option>
                                        <option value="6" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '6') selected="selected" @endif>June</option>
                                        <option value="7" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '7') selected="selected" @endif>July</option>
                                        <option value="8" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '8') selected="selected" @endif>August</option>
                                        <option value="9" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '9') selected="selected" @endif>September</option>
                                        <option value="10" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '10') selected="selected" @endif>October</option>
                                        <option value="11" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '11') selected="selected" @endif>November</option>
                                        <option value="12" @if (old('annually_month', ($item['frequency']['type'] === 'annually' ? (string) $item['frequency']['month'] : null)) === '12') selected="selected" @endif>December</option>
                                    </select>
                                    <x-validation-error-message field="annually_month" />
                                </div>
                            </div>
                        </fieldset>

                        <fieldset data-frequency="monthly">
                            <legend class="col-form-label col-12 text-primary">Exclusions</legend>
                            <p>Select any months when the expense <strong>should not</strong> appear on your
                                budget, for example, you may not pay Council Tax in January & February.</p>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_1" name="exclusion[]" value="1" @if((is_array(old('exclusion')) && in_array('1', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(1, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_1">
                                            January
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_2" name="exclusion[]" value="2" @if((is_array(old('exclusion')) && in_array('2', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(2, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_2">
                                            February
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_3" name="exclusion[]" value="3" @if((is_array(old('exclusion')) && in_array('3', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(3, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_3">
                                            March
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_4" name="exclusion[]" value="4" @if((is_array(old('exclusion')) && in_array('4', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(4, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_4">
                                            April
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_5" name="exclusion[]" value="5" @if((is_array(old('exclusion')) && in_array('5', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(5, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_5">
                                            May
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_6" name="exclusion[]" value="6" @if((is_array(old('exclusion')) && in_array('6', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(6, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_6">
                                            June
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_7" name="exclusion[]" value="7" @if((is_array(old('exclusion')) && in_array('7', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(7, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_7">
                                            July
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_8" name="exclusion[]" value="8" @if((is_array(old('exclusion')) && in_array('8', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(8, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_8">
                                            August
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_9" name="exclusion[]" value="9" @if((is_array(old('exclusion')) && in_array('9', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(9, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_9">
                                            September
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input <x-validation-error field='exclusion' />" type="checkbox" id="exclusion_10" name="exclusion[]" value="10" @if((is_array(old('exclusion')) && in_array('10', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(10, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_10">
                                            October
                                        </label>
                                        <x-validation-error-message field="exclusion" />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_11" name="exclusion[]" value="11" @if((is_array(old('exclusion')) && in_array('11', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(11, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_11">
                                            November
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="exclusion_12" name="exclusion[]" value="12" @if((is_array(old('exclusion')) && in_array('12', old('exclusion'), true)) || ($item['frequency']['type'] === 'monthly' && in_array(12, $item['frequency']['exclusions']))) checked="checked" @endif>
                                        <label class="form-check-label" for="exclusion_12">
                                            December
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="col-12 text-muted small">Fields marked with an asterisk * are required.</div>
                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-sm btn-dark">Save</button>
                            <a href="{{ route(
                                'budget.item.view',
                                [
                                    'item_id' => $item['id'],
                                    'year' => $selected_now_year,
                                    'month' => $selected_now_month,
                                    'item-year' => $item_year,
                                    'item-month' => $item_month
                                ]
                            ) }}" class="btn btn-sm btn-outline-primary">Cancel</a>
                        </div>
                    </form>

                    <div class="p-2">
                        <div class="alert alert-primary fade show mt-3" role="alert">
                            <h4 class="alert-heading">Budget Pro! <small>Coming soon(tm)</small></h4>
                            <p>In Budget Pro we will support multi-edit.</p>
                            <p>You will be able to update all your budget items on a single page.</p>
                            <hr>
                            <p class="mb-0"><a href="{{ route('version-compare') }}">Find out more</a>.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-7 p-2">
                    <x-budget
                        :accounts="$accounts"
                        :months="$months"
                        :pagination="$pagination"
                        :viewEnd="$view_end"
                        :projection="$projection"
                        :hasAccounts="$has_accounts"
                        :hasBudget="$has_budget"
                        :active_item="$item['id']"
                        :active_item_year="$item_year"
                        :active_item_month="$item_month" />
                </div>
            </div>

            <x-help />

            <x-requests />

            <x-footer />
        </div>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}" defer></script>
        <script src="{{ asset('js/create-budget-item.js') }}" defer></script>
        <script src="{{ asset('js/auto-format-numbers.js') }}" defer></script>
    </body>
</html>
