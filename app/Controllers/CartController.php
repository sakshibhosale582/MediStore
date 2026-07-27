<?php

namespace App\Controllers;

use App\Services\CartService;
use App\Services\OrderService;
use App\Models\AddressModel;
use App\Models\PrescriptionModel;

class CartController extends BaseController
{
    protected CartService $cartService;
    protected OrderService $orderService;
    protected AddressModel $addressModel;

    public function __construct()
    {
        $this->cartService = service('cartService');
        $this->orderService = service('orderService');
        $this->addressModel = model(AddressModel::class);
    }

    public function index(): string
    {
        $data = [
            'pageTitle' => 'Cart | MediStore',
            'summary' => $this->cartService->getSummary(),
        ];

        return view('cart', $data);
    }

    public function add($medicineId = null)
    {
        if ($medicineId === null) {
            return redirect()->back()->with('error', 'Invalid medicine.');
        }

        $quantity = max(1, (int) $this->request->getPost('quantity') ?: 1);
        $result = $this->cartService->add((int) $medicineId, $quantity);

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function remove($medicineId = null)
    {
        if ($medicineId === null) {
            return redirect()->back()->with('error', 'Invalid medicine.');
        }

        $result = $this->cartService->remove((int) $medicineId);

        return redirect()->to('/cart')->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function update($medicineId = null)
    {
        if ($medicineId === null) {
            return redirect()->back()->with('error', 'Invalid medicine.');
        }

        $quantity = max(1, (int) $this->request->getPost('quantity') ?: 1);
        $result = $this->cartService->update((int) $medicineId, $quantity);

        return redirect()->to('/cart')->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function applyCoupon()
    {
        $code = trim($this->request->getPost('coupon_code') ?? '');
        $result = $this->cartService->applyCoupon($code);

        return redirect()->to('/cart')->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function checkout()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }

        $summary = $this->cartService->getSummary();
        if ($this->cartService->isEmpty()) {
            return redirect()->to('/cart')->with('error', 'Your cart is empty.');
        }

        $addresses = $this->addressModel->getByUser($this->userId());

        $data = [
            'pageTitle' => 'Checkout | MediStore',
            'summary' => $summary,
            'addresses' => $addresses,
            'requiresPrescription' => $summary['has_prescription'],
        ];

        return view('checkout', $data);
    }

    public function placeOrder()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }

        $addressId = (int) ($this->request->getPost('address_id') ?? 0);
        $paymentMethod = $this->request->getPost('payment_method') ?? 'cod';
        $notes = $this->request->getPost('notes');

        $prescriptionModel = model(PrescriptionModel::class);
        $prescription = null;

        if ($this->cartService->hasPrescriptionItems()) {
            $file = $this->request->getFile('prescription_file');
            if ($file === null || !$file->isValid()) {
                return redirect()->back()->withInput()->with('error', 'Please upload a prescription for prescription-required items.');
            }

            $prescription = $prescriptionModel->createFromUpload($this->userId(), $file, $notes);
            if ($prescription === null) {
                return redirect()->back()->withInput()->with('error', 'Prescription upload failed. Please use a JPG, PNG, or PDF file.');
            }
        }

        $result = $this->orderService->placeOrder($this->userId(), $addressId, $paymentMethod, $notes);

        if (! $result['success']) {
            return redirect()->back()->withInput()->with('error', $result['message']);
        }

        return redirect()->to('/checkout/success/' . (int) $result['order_id'])->with('success', $result['message']);
    }

    public function success(int $orderId)
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }

        $orderModel = model('OrderModel');
        $order = $orderModel->getWithItems($orderId);

        if ($order === null || (int) $order['user_id'] !== (int) $this->userId()) {
            return redirect()->to('/customer/dashboard')->with('error', 'Order not found.');
        }

        return view('checkout_success', [
            'pageTitle' => 'Order Confirmed | MediStore',
            'order' => $order,
        ]);
    }
}
