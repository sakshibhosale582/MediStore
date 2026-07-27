<?php

namespace App\Controllers;

use App\Models\AddressModel;
use App\Models\OrderModel;
use App\Models\PrescriptionModel;
use App\Models\ReturnRequestModel;
use App\Services\NotificationService;
use App\Services\OrderService;

class Customer extends BaseController
{
    protected OrderService $orderService;
    protected NotificationService $notificationService;

    public function __construct()
    {
        $this->orderService = service('orderService');
        $this->notificationService = service('notificationService');
    }

    public function dashboard()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $orderModel = model(OrderModel::class);
        $orders = $orderModel->getByUserWithItems($this->userId(), 5);

        return view('customer/dashboard', [
            'pageTitle' => 'Customer Dashboard | MediStore',
            'orders' => $orders,
        ]);
    }

    public function orders()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $orderModel = model(OrderModel::class);
        $orders = $orderModel->getByUserWithItems($this->userId(), 20);

        return view('customer/orders', [
            'pageTitle' => 'My Orders | MediStore',
            'orders' => $orders,
        ]);
    }

    public function viewOrder(int $orderId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $order = $this->orderService->getTracking($orderId, $this->userId());

        if ($order === null) {
            return redirect()->to('/customer/orders')->with('error', 'Order not found.');
        }

        return view('customer/order_detail', [
            'pageTitle' => 'Order Details | MediStore',
            'order' => $order,
        ]);
    }

    public function prescriptions()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $prescriptionModel = model(PrescriptionModel::class);

        return view('customer/prescriptions', [
            'pageTitle' => 'My Prescriptions | MediStore',
            'prescriptions' => $prescriptionModel->getByUser($this->userId()),
        ]);
    }

    public function notifications()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        return view('customer/notifications', [
            'pageTitle' => 'Notifications | MediStore',
            'notifications' => $this->notificationService->getRecent($this->userId(), 30),
        ]);
    }

    public function markNotificationRead(int $notificationId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $this->notificationService->markAsRead($notificationId, $this->userId());

        return redirect()->to('/customer/notifications');
    }

    public function returnRequest(int $orderId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $orderModel = model(OrderModel::class);
        $order = $orderModel->find($orderId);

        if ($order === null || (int) $order['user_id'] !== $this->userId()) {
            return redirect()->to('/customer/orders')->with('error', 'Order not found.');
        }

        return view('customer/return_request', [
            'pageTitle' => 'Return Request | MediStore',
            'order' => $order,
        ]);
    }

    public function submitReturnRequest(int $orderId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $reason = trim($this->request->getPost('reason') ?? '');
        $result = $this->orderService->requestReturn($orderId, $this->userId(), $reason);

        if (! $result['success']) {
            return redirect()->back()->withInput()->with('error', $result['message']);
        }

        return redirect()->to('/customer/orders')->with('success', $result['message']);
    }

    public function addresses()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $addressModel = model(AddressModel::class);

        return view('customer/addresses', [
            'pageTitle' => 'My Addresses | MediStore',
            'addresses' => $addressModel->getByUser($this->userId()),
            'editAddress' => null,
        ]);
    }

    public function editAddress(int $addressId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $addressModel = model(AddressModel::class);
        $address = $addressModel->getUserAddress($this->userId(), $addressId);

        if ($address === null) {
            return redirect()->to('/customer/addresses')->with('error', 'Address not found.');
        }

        return view('customer/addresses', [
            'pageTitle' => 'Edit Address | MediStore',
            'addresses' => $addressModel->getByUser($this->userId()),
            'editAddress' => $address,
        ]);
    }

    public function saveAddress()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $addressModel = model(AddressModel::class);
        $userId = $this->userId();
        $addressId = (int) ($this->request->getPost('id') ?? 0);

        $data = [
            'user_id' => $userId,
            'label' => trim($this->request->getPost('label') ?? ''),
            'name' => trim($this->request->getPost('name') ?? ''),
            'phone' => trim($this->request->getPost('phone') ?? ''),
            'address_line' => trim($this->request->getPost('address_line') ?? ''),
            'city' => trim($this->request->getPost('city') ?? ''),
            'state' => trim($this->request->getPost('state') ?? ''),
            'pincode' => trim($this->request->getPost('pincode') ?? ''),
            'is_default' => (int) ($this->request->getPost('is_default') ?? 0),
        ];

        if ($data['label'] === '' || $data['name'] === '' || $data['phone'] === '' || $data['address_line'] === '' || $data['city'] === '' || $data['state'] === '' || $data['pincode'] === '') {
            return redirect()->back()->withInput()->with('error', 'Please fill in all address fields.');
        }

        if ($addressId > 0) {
            $existing = $addressModel->getUserAddress($userId, $addressId);
            if ($existing === null) {
                return redirect()->to('/customer/addresses')->with('error', 'Address not found.');
            }
            $addressModel->update($addressId, $data);
            $savedId = $addressId;
        } else {
            $savedId = $addressModel->insert($data);
        }

        if (! $savedId) {
            return redirect()->back()->withInput()->with('error', 'Unable to save address.');
        }

        if (! empty($data['is_default'])) {
            $addressModel->setDefault($userId, (int) $savedId);
        }

        return redirect()->to('/customer/addresses')->with('success', 'Address saved successfully.');
    }

    public function deleteAddress(int $addressId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $addressModel = model(AddressModel::class);
        $address = $addressModel->getUserAddress($this->userId(), $addressId);

        if ($address === null) {
            return redirect()->to('/customer/addresses')->with('error', 'Address not found.');
        }

        $deleted = $addressModel->delete($addressId);
        if ($deleted) {
            $remaining = $addressModel->getByUser($this->userId());
            if (! empty($remaining) && empty(array_filter($remaining, static fn($item) => !empty($item['is_default'])))) {
                $addressModel->setDefault($this->userId(), (int) $remaining[0]['id']);
            }
            return redirect()->to('/customer/addresses')->with('success', 'Address removed.');
        }

        return redirect()->to('/customer/addresses')->with('error', 'Unable to remove address.');
    }

    public function setDefaultAddress(int $addressId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $addressModel = model(AddressModel::class);
        $address = $addressModel->getUserAddress($this->userId(), $addressId);

        if ($address === null) {
            return redirect()->to('/customer/addresses')->with('error', 'Address not found.');
        }

        $addressModel->setDefault($this->userId(), $addressId);

        return redirect()->to('/customer/addresses')->with('success', 'Default address updated.');
    }
}
