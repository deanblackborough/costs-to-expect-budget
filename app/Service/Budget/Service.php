<?php

declare(strict_types=1);

namespace App\Service\Budget;

use DateTimeImmutable;
use DateTimeZone;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough (Costs to Expect) 2018-2022
 * @license https://github.com/costs-to-expect/budget/blob/main/LICENSE
 */
class Service
{
    /** @var Account[] */
    private array $accounts = [];

    /** @var Item[] */
    private array $budget_items = [];

    /** @var Month[] */
    private array $months = [];

    private DateTimeImmutable $start_date;

    private DateTimeImmutable $view_start_date;

    private DateTimeImmutable $view_end_date;

    private bool $projection = true;

    private array $currency;

    public function __construct()
    {
        $this->start_date = (new DateTimeImmutable('first day of this month'))->setTime(7, 1 );
        $this->view_start_date = (new DateTimeImmutable('first day of this month'))->setTime(7, 1);

        // Default to GBP
        $this->currency = [
            'id' => 'epMqeYqPkL',
            'code' => 'GBP',
            'name' => 'Sterling'
        ];
    }

    public function setNow(DateTimeImmutable $start_date): Service
    {
        $this->start_date = $start_date;
        $this->view_start_date = $start_date;

        return $this;
    }

    public function setPagination(int $month, $year): Service
    {
        $this->view_start_date = (new DateTimeImmutable(
            "{$year}-{$month}-01",
            new DateTimeZone('UTC')
        ))->setTime(7, 1);

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function setAccounts(array $accounts): Service
    {
        if(count($accounts) > 3) {
            throw new \LengthException('Too many accounts, limit three');
        }

        foreach ($accounts as $account) {
            $this->accounts[$account['id']] = new Account(
                $account['id'],
                $account['name'],
                $account['type'],
                $account['currency'],
                (float) $account['balance']
            );
        }

        return $this;
    }

    public function setCurrency(array $currency): Service
    {
        $this->currency = $currency;

        return $this;
    }

    public function create(): void
    {
        $this->setUpMonths();
    }

    public function currency() : array
    {
        return $this->currency;
    }

    public function currencyId() : string
    {
        return $this->currency['id'];
    }

    public function currencyCode() : string
    {
        return $this->currency['code'];
    }

    public function currencyName() : string
    {
        return $this->currency['name'];
    }

    public function account(string $id) : Account
    {
        return $this->accounts[$id];
    }

    public function accounts(): array
    {
        return $this->accounts;
    }

    public function addItem(array $data): bool
    {
        $this->budget_items[] = new Item($data);

        return true;
    }

    public function paginationParameters(): array
    {
        $earlier = $this->view_start_date->sub(new \DateInterval("P1M"));
        $later = $this->view_start_date->add(new \DateInterval("P1M"));

        return [
            'previous' => [
                'month' => (int) $earlier->format('n'),
                'year' => (int) $earlier->format('Y')
            ],
            'next' => [
                'month' => (int) $later->format('n'),
                'year' => (int) $later->format('Y')
            ]
        ];
    }

    public function projection(): bool
    {
        return $this->projection;
    }

    /**
     * @return array{ month: string, year: int}
     */
    public function viewEndPeriod(): array
    {
        return [
            'month' => $this->view_end_date->format('F'),
            'year' => (int) $this->view_end_date->format('Y')
        ];
    }

    public function months(): array
    {
        return $this->months;
    }

    public function numberOfVisibleMonths(): int
    {
        return 3;
    }

    public function assignItemsToBudget(): void
    {
        foreach ($this->months as $month) {
            foreach ($this->budget_items as $budget_item) {
                if ($budget_item->activeForMonth($month->days(), $month->month(), $month->year()) === true) {
                    $this->months[$month->year() . '-' . $month->month()]->add($budget_item);

                    if (
                        $budget_item->disabled() === false &&
                        $this->months[$month->year() . '-' . $month->month()]->future() === true
                    ) {
                        if ($budget_item->category() === 'income') {

                            if (array_key_exists($budget_item->account(), $this->accounts)) {
                                $this->accounts[$budget_item->account()]->add($budget_item->amount());
                            }
                        } else {
                            if ($budget_item->category() === 'savings') {
                                if (
                                    array_key_exists($budget_item->account(), $this->accounts) &&
                                    array_key_exists($budget_item->targetAccount(), $this->accounts)
                                ) {
                                    $this->accounts[$budget_item->account()]->sub($budget_item->amount());
                                    $this->accounts[$budget_item->targetAccount()]->add(
                                        $budget_item->amount()
                                    );
                                }
                            } else {
                                if (array_key_exists($budget_item->account(), $this->accounts)) {
                                    $this->accounts[$budget_item->account()]->sub($budget_item->amount());
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function setUpMonths(): void
    {
        $date_diff = date_diff($this->start_date, $this->view_start_date);

        if ($date_diff->invert === 0) {

            for (
                $i = 0;
                $i < ($date_diff->y * 12) + $date_diff->m;
                $i++
            ) {
                $next = $this->start_date->add(new \DateInterval("P{$i}M"));

                $year_int = (int)$next->format('Y');
                $month_int = (int)$next->format('n');

                $this->months[$year_int . '-' . $month_int] = new Month($month_int, $year_int, false);
            }
        }

        $added_to_view_start_date = 0;
        if ($date_diff->invert === 1) {

            $date_diff = date_diff($this->view_start_date, $this->start_date);

            $period_in_months = ($date_diff->y * 12) + $date_diff->m;

            for (
                $i = 0;
                $i < (min($period_in_months, 3));
                $i++
            ) {
                $added_to_view_start_date++;
                $next = $this->view_start_date->add(new \DateInterval("P{$i}M"));

                $year_int = (int) $next->format('Y');
                $month_int = (int) $next->format('n');

                if ($i === 2) {
                    $this->projection = false; // We are not projecting as there are three past months on display
                    $this->view_end_date = (new DateTimeImmutable(
                        "{$year_int}-{$month_int}-01", new DateTimeZone('UTC')))->setTime(7, 1);
                }

                $this->months[$year_int . '-' . $month_int] = new Month($month_int, $year_int, true, false);
            }
        }

        for ($i = 0; $i < $this->numberOfVisibleMonths() - $added_to_view_start_date; $i++) {

            $months_to_add = $i + $added_to_view_start_date;

            $next = $this->view_start_date->add(new \DateInterval("P{$months_to_add}M"));

            $year_int = (int) $next->format('Y');
            $month_int = (int) $next->format('n');

            $this->view_end_date = (new DateTimeImmutable(
                "{$year_int}-{$month_int}-01", new DateTimeZone('UTC')))->setTime(7, 1);

            $this->months[$year_int . '-' . $month_int] = new Month($month_int, $year_int, true);
        }
    }
}
