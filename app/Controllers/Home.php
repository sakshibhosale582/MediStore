<?php

namespace App\Controllers;

use App\Models\BannerModel;
use App\Models\CategoryModel;
use App\Models\MedicineModel;
use App\Models\OfferModel;
use App\Models\ReviewModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index(): string
    {
        helper('medistore');

        $medicineModel = model(MedicineModel::class);
        $categoryModel = model(CategoryModel::class);
        $bannerModel = model(BannerModel::class);
        $offerModel = model(OfferModel::class);

        $data = [
            'pageTitle'        => 'MediStore | Online Pharmacy',
            'featuredMedicines' => $medicineModel->getFeatured(8),
            'categories'       => $categoryModel->getActive(),
            'banners'          => $bannerModel->getActive(),
            'offers'           => $offerModel->getActive(),
        ];

        return view('home', $data);
    }

    public function shop(): string
    {
        helper('medistore');

        $medicineModel = model(MedicineModel::class);
        $categoryModel = model(CategoryModel::class);

        $keyword = trim($this->request->getGet('q') ?? '');
        $categoryId = $this->request->getGet('category_id');
        $brandId = $this->request->getGet('brand_id');
        $manufacturerId = $this->request->getGet('manufacturer_id');
        $prescriptionRequired = $this->request->getGet('prescription_required');
        $inStock = $this->request->getGet('in_stock');
        $sort = $this->request->getGet('sort') ?: 'name';
        $order = $this->request->getGet('order') ?: 'ASC';
        $page = max(1, (int) ($this->request->getGet('page') ?: 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $filters = [
            'category_id' => $categoryId !== null ? (int) $categoryId : null,
            'brand_id' => $brandId !== null ? (int) $brandId : null,
            'manufacturer_id' => $manufacturerId !== null ? (int) $manufacturerId : null,
            'prescription_required' => $prescriptionRequired !== null ? (int) $prescriptionRequired : null,
            'in_stock' => $inStock ? 1 : null,
            'sort' => $sort,
            'order' => $order,
        ];

        $medicines = $medicineModel->search($keyword, array_filter($filters, static fn($value) => $value !== null && $value !== ''), $limit, $offset);
        $total = $medicineModel->countSearch($keyword, array_filter($filters, static fn($value) => $value !== null && $value !== ''));

        $data = [
            'pageTitle' => 'Shop Medicines | MediStore',
            'medicines' => $medicines,
            'categories' => $categoryModel->getActive(),
            'keyword' => $keyword,
            'filters' => $filters,
            'page' => $page,
            'perPage' => $limit,
            'total' => $total,
            'totalPages' => (int) ceil($total / $limit),
        ];

        return view('shop', $data);
    }

    public function medicine(string $slug): string
    {
        helper('medistore');

        $medicineModel = model(MedicineModel::class);
        $reviewModel = model(ReviewModel::class);
        $medicine = $medicineModel->getWithDetails($slug);

        if ($medicine === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = [
            'pageTitle' => esc($medicine['name']) . ' | MediStore',
            'medicine' => $medicine,
            'reviews' => $reviewModel->getByMedicine((int) $medicine['id']),
        ];

        return view('medicine', $data);
    }

    public function submitReview(string $slug)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        $medicineModel = model(MedicineModel::class);
        $medicine = $medicineModel->getWithDetails($slug);

        if ($medicine === null) {
            return redirect()->to('/')->with('error', 'Medicine not found.');
        }

        $rating = (int) ($this->request->getPost('rating') ?? 0);
        $comment = trim($this->request->getPost('comment') ?? '');

        if ($rating < 1 || $rating > 5) {
            return redirect()->back()->withInput()->with('error', 'Please select a valid rating.');
        }

        $reviewModel = model(ReviewModel::class);
        $reviewModel->insert([
            'user_id' => $this->userId(),
            'medicine_id' => (int) $medicine['id'],
            'rating' => $rating,
            'comment' => $comment,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted for moderation.');
    }
}
