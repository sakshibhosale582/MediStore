<?php

namespace App\Controllers;

use App\Models\MedicineModel;

class WishlistController extends BaseController
{
    public function toggle(int $medicineId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $medicineModel = model(MedicineModel::class);
        $medicine = $medicineModel->find($medicineId);

        if ($medicine === null) {
            return redirect()->back()->with('error', 'Medicine not found.');
        }

        $wishlistModel = model('WishlistModel');
        $existing = $wishlistModel->where('user_id', $this->userId())->where('medicine_id', $medicineId)->first();

        if ($existing) {
            $wishlistModel->delete($existing['id']);
            return redirect()->back()->with('success', 'Removed from wishlist.');
        }

        $wishlistModel->insert([
            'user_id' => $this->userId(),
            'medicine_id' => $medicineId,
        ]);

        return redirect()->back()->with('success', 'Added to wishlist.');
    }

    public function index()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'customer') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $wishlistModel = model('WishlistModel');
        $items = $wishlistModel->getByUser($this->userId());

        return view('customer/wishlist', [
            'pageTitle' => 'Wishlist | MediStore',
            'items' => $items,
        ]);
    }
}
