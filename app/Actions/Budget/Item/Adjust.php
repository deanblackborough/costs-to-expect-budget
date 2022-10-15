<?php
declare(strict_types=1);

namespace App\Actions\Budget\Item;

use App\Actions\Action;
use App\Models\AdjustedBudgetItem;
use Illuminate\Support\Facades\Validator;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough (Costs to Expect) 2018-2022
 * https://github.com/costs-to-expect/budget/blob/main/LICENSE
 */
class Adjust extends Action
{
    public function __invoke(
        string $resource_id,
        int $year,
        int $month,
        string $budget_item_id,
        array $input
    ): int
    {
        Validator::make(
            $input,
            [
                'amount' => [
                    'required',
                    'string',
                    'regex:/^\d+\.\d{2}$/',
                    'max:16'
                ]
            ],
            [
                'amount.regex' => 'The amount should be in the format 0.00'
            ]
        )->validate();

        $model = new AdjustedBudgetItem();
        $model->resource_id = $resource_id;
        $model->year = $year;
        $model->month = $month;
        $model->amount = $input['amount'];

        try {
            $model->save();

            return 201;
        } catch (\Exception $e) {
            $this->message = $e->getMessage();

            return 500;
        }
    }
}