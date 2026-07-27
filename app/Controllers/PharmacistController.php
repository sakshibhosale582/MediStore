<?php

namespace App\Controllers;

use App\Models\PrescriptionModel;
use App\Services\NotificationService;

class PharmacistController extends BaseController
{
    protected NotificationService $notificationService;

    public function __construct()
    {
        $this->notificationService = service('notificationService');
    }

    public function dashboard()
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'pharmacist') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $prescriptionModel = model(PrescriptionModel::class);

        return view('pharmacist/dashboard', [
            'pageTitle' => 'Pharmacist Dashboard | MediStore',
            'prescriptions' => $prescriptionModel->where('status', 'pending')->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function review(int $prescriptionId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'pharmacist') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $prescriptionModel = model(PrescriptionModel::class);
        $prescription = $prescriptionModel->find($prescriptionId);

        if ($prescription === null) {
            return redirect()->to('/pharmacist/dashboard')->with('error', 'Prescription not found.');
        }

        return view('pharmacist/review', [
            'pageTitle' => 'Review Prescription | MediStore',
            'prescription' => $prescription,
        ]);
    }

    public function saveReview(int $prescriptionId = 0)
    {
        if ($this->requireLogin('/login') !== null) {
            return $this->requireLogin('/login');
        }

        if ($this->userRole() !== 'pharmacist') {
            return redirect()->to('/')->with('error', 'Unauthorized access.');
        }

        $status = $this->request->getPost('status') ?? 'rejected';
        $notes = trim($this->request->getPost('review_notes') ?? '');
        $prescriptionModel = model(PrescriptionModel::class);
        $prescription = $prescriptionModel->find($prescriptionId);

        if ($prescription === null) {
            return redirect()->to('/pharmacist/dashboard')->with('error', 'Prescription not found.');
        }

        $prescriptionModel->updateStatus($prescriptionId, $status, $notes, $this->userId());
        $this->notificationService->notifyPrescriptionStatus((int) $prescription['user_id'], $prescriptionId, $status);

        return redirect()->to('/pharmacist/dashboard')->with('success', 'Prescription review saved.');
    }
}
