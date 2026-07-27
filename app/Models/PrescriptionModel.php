<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\Files\UploadedFile;

class PrescriptionModel extends Model
{
    protected $table            = 'prescriptions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'file', 'file_type', 'notes', 'status', 'pharmacist_id', 'review_notes', 'reviewed_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByUser(int $userId): array
    {
        return $this->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    public function createFromUpload(int $userId, UploadedFile $file, ?string $notes = null): ?array
    {
        if (! $file->isValid()) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        $mimeType = $file->getMimeType();

        if (! in_array($mimeType, $allowedTypes, true)) {
            return null;
        }

        if (! is_dir(PRESCRIPTION_PATH)) {
            mkdir(PRESCRIPTION_PATH, 0777, true);
        }

        $newName = 'prescription_' . $userId . '_' . time() . '_' . $file->getRandomName();
        $file->move(PRESCRIPTION_PATH, $newName);

        $id = $this->insert([
            'user_id'   => $userId,
            'file'      => 'uploads/prescriptions/' . $newName,
            'file_type' => $this->getFileType($mimeType),
            'notes'     => $notes,
            'status'    => 'pending',
        ]);

        return $id ? $this->find($id) : null;
    }

    public function updateStatus(int $prescriptionId, string $status, ?string $reviewNotes = null, ?int $pharmacistId = null): bool
    {
        $data = [
            'status' => $status,
            'review_notes' => $reviewNotes,
            'reviewed_at' => date('Y-m-d H:i:s'),
        ];

        if ($pharmacistId !== null) {
            $data['pharmacist_id'] = $pharmacistId;
        }

        return (bool) $this->update($prescriptionId, $data);
    }

    protected function getFileType(string $mimeType): string
    {
        return str_starts_with($mimeType, 'image/') ? 'image' : 'pdf';
    }
}
