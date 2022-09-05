<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\Budget\Service;
use Illuminate\Http\Request;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough (Costs to Expect) 2018-2022
 * @license https://github.com/costs-to-expect/budget/blob/main/LICENSE
 */
class Index extends Controller
{
    public function home(Request $request)
    {
        $this->bootstrap($request);

        $budget = new Service($this->mock_accounts_data);

        foreach ($this->mock_data as $budget_item) {
            $budget->add($budget_item);
        }

        $budget->allocatedItemsToMonths();

        return view(
            'home',
            [
                'accounts' => $budget->accounts(),
                'months' => $budget->months(),
                'pagination' => $budget->pagination(),
            ]
        );
    }

    public function landing()
    {
        return view('landing');
    }
}
