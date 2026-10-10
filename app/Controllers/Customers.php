<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index(): string
    {
        $customers = (new CustomerModel())->orderBy('full_name', 'ASC')->findAll();

        foreach ($customers as &$customer) {
            $customer['initials'] = $this->initials($customer['full_name']);
        }
        unset($customer);

        return view('customers/index', [
            'title'       => 'Our Guests',
            'currentPage' => 'customers',
            'customers'   => $customers,
        ]);
    }

    public function new(): string
    {
        return view('customers/form', [
            'title'       => 'Add a Guest',
            'currentPage' => 'customers',
            'heading'     => 'Welcome a new guest',
            'eyebrow'     => 'Around our table',
            'action'      => site_url('customers'),
            'submitLabel' => 'Save guest',
            'customer'    => null,
            'errors'      => session('errors') ?? [],
        ]);
    }

    public function create()
    {
        $data = $this->customerData();

        if (! $this->validateData($data, $this->customerRules())) {
            return redirect()->to(site_url('customers/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        (new CustomerModel())->insert($data);

        return redirect()->to(site_url('customers'))->with('success', 'Guest added to Tahanan.');
    }

    public function edit(int $id): string
    {
        $customer = (new CustomerModel())->find($id);

        if ($customer === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Guest not found.');
        }

        return view('customers/form', [
            'title'       => 'Update Guest',
            'currentPage' => 'customers',
            'heading'     => 'Update guest details',
            'eyebrow'     => 'Around our table',
            'action'      => site_url('customers/' . $id),
            'submitLabel' => 'Save guest details',
            'customer'    => $customer,
            'errors'      => session('errors') ?? [],
        ]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();

        if ($model->find($id) === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Guest not found.');
        }

        $data = $this->customerData();

        if (! $this->validateData($data, $this->customerRules())) {
            return redirect()->to(site_url('customers/' . $id . '/edit'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, $data);

        return redirect()->to(site_url('customers'))->with('success', 'Guest details updated.');
    }

    private function customerData(): array
    {
        return [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')) ?: null,
        ];
    }

    private function customerRules(): array
    {
        return [
            'full_name' => ['label' => 'Full name', 'rules' => 'required|min_length[2]|max_length[100]'],
            'email'     => ['label' => 'Email address', 'rules' => 'required|valid_email|max_length[100]'],
            'phone'     => ['label' => 'Phone number', 'rules' => 'permit_empty|max_length[20]'],
        ];
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
