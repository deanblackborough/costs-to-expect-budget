<?php
declare(strict_types=1);

namespace App\Actions\Budget\Item;

use App\Actions\Action;
use App\Actions\Helper;
use App\Api\Service;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough (Costs to Expect) 2018-2022
 * https://github.com/costs-to-expect/budget/blob/main/LICENSE
 */
class Update extends Action
{
    public function __invoke(
        Service $api,
        string $resource_type_id,
        string $resource_id,
        string $item_id,
        array $input
    ): int
    {
        $item_response = $api->getBudgetItem($resource_type_id, $resource_id, $item_id);
        if ($item_response['status'] !== 200) {
            $this->message = $item_response['content'];
            return $item_response['status'];
        }

        $item = $item_response['content'];

        $payload = [];

        // Check simple fields
        foreach (['name', 'account', 'description', 'start_date', 'end_date', 'amount', 'category'] as $field) {
            if ($item[$field] !== $input[$field]) {
                $payload[$field] = $input[$field];
            }
        }

        if ($input['currency_id'] !== $item['currency']['id']) {
            $payload['currency_id'] = $input['currency_id'];
        }

        // Check target account
        if ($input['category'] === 'savings') {
            if ($input['target_account'] !== $item['target_account']) {
                $payload['target_account'] = $input['target_account'];
            }
        } elseif ($item['target_account'] !== null) {
            $payload['target_account'] = null;
        }

        // Check the frequency
        $frequency = Helper::createFrequencyArray($input);
        ksort($item['frequency']);
        if ($frequency !== $item['frequency']) {
            $payload['frequency'] = $frequency;
        }

        if (count($payload) === 0) {
            $this->message = 'No changes to save';
            return 204;
        }

        $patch_budget_item_response = $api->patchBudgetItem(
            $resource_type_id,
            $resource_id,
            $item_id,
            $payload
        );

        if ($patch_budget_item_response['status'] === 204) {
            return 204;
        }

        if ($patch_budget_item_response['status'] === 422) {
            $this->message = $patch_budget_item_response['content'];
            $this->validation_errors = $patch_budget_item_response['fields'];
            return 422;
        }

        $this->message = $patch_budget_item_response['content'];

        return $patch_budget_item_response['status'];
    }
}
