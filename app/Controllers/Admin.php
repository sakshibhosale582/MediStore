<?php

namespace App\Controllers;

use App\Models\MedicineModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $userModel = model(UserModel::class);
        $users = $userModel->findAll();

        return view('admin/dashboard', [
            'pageTitle' => 'Admin Dashboard | MediStore',
            'users' => $users,
            'totalUsers' => count($users),
            'activeUsers' => count(array_filter($users, fn($user) => !empty($user['is_active']))),
            'customerCount' => count(array_filter($users, fn($user) => ($user['role'] ?? '') === 'customer')),
            'pharmacistCount' => count(array_filter($users, fn($user) => ($user['role'] ?? '') === 'pharmacist')),
        ]);
    }

    public function users()
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $userModel = model(UserModel::class);
        $users = $userModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/users', [
            'pageTitle' => 'Manage Users | MediStore',
            'users' => $users,
        ]);
    }

    public function toggleUser(int $userId)
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $userModel = model(UserModel::class);
        $user = $userModel->find($userId);

        if ($user === null) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        if ((int) $user['id'] === (int) $this->userId()) {
            return redirect()->to('/admin/users')->with('error', 'You cannot deactivate your own account.');
        }

        $userModel->update($userId, ['is_active' => empty($user['is_active']) ? 1 : 0]);

        return redirect()->to('/admin/users')->with('success', 'User status updated.');
    }

    public function orders()
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $orderModel = model('OrderModel');
        $orders = $orderModel->orderBy('created_at', 'DESC')->findAll();

        return view('admin/orders', [
            'pageTitle' => 'Order Management | MediStore',
            'orders' => $orders,
        ]);
    }

    public function updateOrder(int $orderId)
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $orderModel = model('OrderModel');
        $order = $orderModel->find($orderId);

        if ($order === null) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found.');
        }

        return view('admin/order_update', [
            'pageTitle' => 'Update Order | MediStore',
            'order' => $order,
        ]);
    }

    public function saveOrderStatus(int $orderId)
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $orderModel = model('OrderModel');
        $status = trim($this->request->getPost('order_status') ?? 'pending');

        $orderModel->update($orderId, ['order_status' => $status]);

        return redirect()->to('/admin/orders')->with('success', 'Order status updated.');
    }

    public function inventory()
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $medicineModel = model(MedicineModel::class);

        return view('admin/inventory', [
            'pageTitle' => 'Inventory | MediStore',
            'medicines' => $medicineModel->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function updateStock(int $medicineId)
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $stock = max(0, (int) ($this->request->getPost('stock') ?? 0));
        $medicineModel = model(MedicineModel::class);
        $medicineModel->update($medicineId, ['stock' => $stock]);

        return redirect()->to('/admin/inventory')->with('success', 'Inventory updated.');
    }

    public function medicines()
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        return view('admin/medicines', [
            'pageTitle' => 'Manage Medicines | MediStore',
            'medicines' => model(MedicineModel::class)->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function createMedicine()
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        return $this->medicineForm();
    }

    public function storeMedicine()
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $data = $this->medicineData();
        $image = $this->storeMedicineImage();
        if ($image !== null && isset($image['error'])) {
            return redirect()->back()->withInput()->with('error', $image['error']);
        }

        if ($image !== null) {
            $data['image'] = $image['path'];
        }

        $medicineModel = model(MedicineModel::class);
        if (! $medicineModel->insert($data)) {
            if ($image !== null) {
                $this->removeMedicineImage($image['path']);
            }
            return redirect()->back()->withInput()->with('error', implode(' ', $medicineModel->errors()));
        }

        return redirect()->to('/admin/medicines')->with('success', 'Medicine added successfully.');
    }

    public function editMedicine(int $medicineId)
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $medicine = model(MedicineModel::class)->find($medicineId);
        if ($medicine === null) {
            return redirect()->to('/admin/medicines')->with('error', 'Medicine not found.');
        }

        return $this->medicineForm($medicine);
    }

    public function updateMedicine(int $medicineId)
    {
        $guard = $this->requireRole(['admin'], '/login');
        if ($guard !== null) {
            return $guard;
        }

        $medicineModel = model(MedicineModel::class);
        $medicine = $medicineModel->find($medicineId);
        if ($medicine === null) {
            return redirect()->to('/admin/medicines')->with('error', 'Medicine not found.');
        }

        $data = $this->medicineData($medicineId);
        $image = $this->storeMedicineImage();
        if ($image !== null && isset($image['error'])) {
            return redirect()->back()->withInput()->with('error', $image['error']);
        }

        if ($image !== null) {
            $data['image'] = $image['path'];
        }

        if (! $medicineModel->update($medicineId, $data)) {
            if ($image !== null) {
                $this->removeMedicineImage($image['path']);
            }
            return redirect()->back()->withInput()->with('error', implode(' ', $medicineModel->errors()));
        }

        if ($image !== null && ! empty($medicine['image'])) {
            $this->removeMedicineImage($medicine['image']);
        }

        return redirect()->to('/admin/medicines')->with('success', 'Medicine updated successfully.');
    }

    private function medicineForm(?array $medicine = null)
    {
        return view('admin/medicine_form', [
            'pageTitle' => $medicine === null ? 'Add Medicine | MediStore' : 'Edit Medicine | MediStore',
            'medicine' => $medicine,
            'categories' => model(CategoryModel::class)->getActive(),
        ]);
    }

    private function medicineData(?int $medicineId = null): array
    {
        $name = trim((string) $this->request->getPost('name'));

        $data = [
            'category_id' => (int) $this->request->getPost('category_id'),
            'name' => $name,
            'slug' => $this->uniqueMedicineSlug($name, $medicineId),
            'generic_name' => trim((string) $this->request->getPost('generic_name')) ?: null,
            'price' => (float) $this->request->getPost('price'),
            'discount_price' => $this->request->getPost('discount_price') !== '' ? (float) $this->request->getPost('discount_price') : null,
            'stock' => max(0, (int) $this->request->getPost('stock')),
            'description' => trim((string) $this->request->getPost('description')) ?: null,
            'usage_info' => trim((string) $this->request->getPost('usage_info')) ?: null,
            'side_effects' => trim((string) $this->request->getPost('side_effects')) ?: null,
            'storage_instructions' => trim((string) $this->request->getPost('storage_instructions')) ?: null,
            'prescription_required' => $this->request->getPost('prescription_required') ? 1 : 0,
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
            'status' => $this->request->getPost('status') ? 1 : 0,
        ];

        // CodeIgniter validates before it removes non-allowed fields. Supplying
        // the current ID lets the is_unique slug rule exclude this record.
        if ($medicineId !== null) {
            $data['id'] = $medicineId;
        }

        return $data;
    }

    private function uniqueMedicineSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = slugify($name);
        $slug = $baseSlug;
        $suffix = 2;
        $medicineModel = model(MedicineModel::class);

        while (true) {
            $query = $medicineModel->where('slug', $slug);
            if ($ignoreId !== null) {
                $query->where('id !=', $ignoreId);
            }
            if ($query->first() === null) {
                return $slug;
            }
            $slug = $baseSlug . '-' . $suffix++;
        }
    }

    private function storeMedicineImage(): ?array
    {
        $file = $this->request->getFile('image');
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if (! $file->isValid() || $file->hasMoved()) {
            return ['error' => 'The image upload failed. Please choose another file.'];
        }
        if ($file->getSize() > 5 * 1024 * 1024) {
            return ['error' => 'The image must be 5 MB or smaller.'];
        }

        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = $file->getMimeType();
        if (! isset($extensions[$mime])) {
            return ['error' => 'Please upload a JPG, PNG, or WebP image.'];
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        $destination = FCPATH . 'uploads/medicines/';
        if (! is_dir($destination) && ! mkdir($destination, 0755, true) && ! is_dir($destination)) {
            return ['error' => 'The image storage folder could not be created.'];
        }

        $file->move($destination, $filename);
        return ['path' => 'medicines/' . $filename];
    }

    private function removeMedicineImage(string $path): void
    {
        $filename = basename(str_replace('\\', '/', $path));
        $fullPath = FCPATH . 'uploads/medicines/' . $filename;
        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}
