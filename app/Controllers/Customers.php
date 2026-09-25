<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();
        $customers = $customerModel->orderBy('full_name', 'ASC')->findAll();

        foreach ($customers as &$customer) {
            $customer['initials'] = $this->initials($customer['full_name']);
        }
        unset($customer);

        return view('customers/index', [
            'title'       => 'Customer Accounts',
            'currentPage' => 'customers',
            'customers'   => $customers,
        ]);
    }

    private function initials(string $fullName): string
    {
        $words = preg_split('/\s+/', trim($fullName)) ?: [];

        return strtoupper(implode('', array_map(
            static fn (string $word): string => substr($word, 0, 1),
            array_slice($words, 0, 2),
        )));
    }
}
