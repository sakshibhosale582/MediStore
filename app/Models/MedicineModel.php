<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicineModel extends Model
{
    protected $table            = 'medicines';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id', 'brand_id', 'manufacturer_id', 'name', 'generic_name', 'slug',
        'price', 'discount_price', 'stock', 'description', 'usage_info', 'side_effects',
        'storage_instructions', 'prescription_required', 'image', 'expiry_date', 'status',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'id'          => 'permit_empty|integer',
        'category_id' => 'required|integer',
        'name'        => 'required|min_length[2]|max_length[200]',
        'slug'        => 'required|is_unique[medicines.slug,id,{id}]',
        'price'       => 'required|decimal',
        'stock'       => 'required|integer',
    ];

    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data): array
    {
        if (empty($data['data']['slug']) && ! empty($data['data']['name'])) {
            helper('medistore');
            $data['data']['slug'] = slugify($data['data']['name']);
        }

        return $data;
    }

    public function getEffectivePrice(array $medicine): float
    {
        if (! empty($medicine['discount_price']) && (float) $medicine['discount_price'] > 0) {
            return (float) $medicine['discount_price'];
        }

        return (float) $medicine['price'];
    }

    public function getWithDetails(int|string $idOrSlug): ?array
    {
        $builder = $this->db->table($this->table . ' m')
            ->select('m.*, c.name as category_name, c.slug as category_slug, b.name as brand_name, mf.name as manufacturer_name')
            ->join('categories c', 'c.id = m.category_id', 'left')
            ->join('brands b', 'b.id = m.brand_id', 'left')
            ->join('manufacturers mf', 'mf.id = m.manufacturer_id', 'left');

        if (is_numeric($idOrSlug)) {
            $builder->where('m.id', (int) $idOrSlug);
        } else {
            $builder->where('m.slug', $idOrSlug);
        }

        $medicine = $builder->get()->getRowArray();

        if ($medicine) {
            $medicine['effective_price'] = $this->getEffectivePrice($medicine);
        }

        return $medicine;
    }

    public function search(string $keyword = '', array $filters = [], int $limit = 20, int $offset = 0): array
    {
        $builder = $this->db->table($this->table . ' m')
            ->select('m.*, c.name as category_name, b.name as brand_name')
            ->join('categories c', 'c.id = m.category_id', 'left')
            ->join('brands b', 'b.id = m.brand_id', 'left')
            ->where('m.status', 1);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('m.name', $keyword)
                ->orLike('m.generic_name', $keyword)
                ->orLike('b.name', $keyword)
                ->groupEnd();
        }

        if (! empty($filters['category_id'])) {
            $builder->where('m.category_id', (int) $filters['category_id']);
        }

        if (! empty($filters['brand_id'])) {
            $builder->where('m.brand_id', (int) $filters['brand_id']);
        }

        if (! empty($filters['manufacturer_id'])) {
            $builder->where('m.manufacturer_id', (int) $filters['manufacturer_id']);
        }

        if (isset($filters['prescription_required'])) {
            $builder->where('m.prescription_required', (int) $filters['prescription_required']);
        }

        if (! empty($filters['min_price'])) {
            $builder->where('m.price >=', (float) $filters['min_price']);
        }

        if (! empty($filters['max_price'])) {
            $builder->where('m.price <=', (float) $filters['max_price']);
        }

        if (! empty($filters['in_stock'])) {
            $builder->where('m.stock >', 0);
        }

        $sort = $filters['sort'] ?? 'name';
        $order = $filters['order'] ?? 'ASC';

        $allowedSorts = ['name', 'price', 'created_at', 'stock'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'name';
        }

        $builder->orderBy('m.' . $sort, strtoupper($order) === 'DESC' ? 'DESC' : 'ASC');

        $results = $builder->limit($limit, $offset)->get()->getResultArray();

        foreach ($results as &$item) {
            $item['effective_price'] = $this->getEffectivePrice($item);
        }

        return $results;
    }

    public function countSearch(string $keyword = '', array $filters = []): int
    {
        $builder = $this->db->table($this->table . ' m')
            ->join('brands b', 'b.id = m.brand_id', 'left')
            ->where('m.status', 1);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('m.name', $keyword)
                ->orLike('m.generic_name', $keyword)
                ->orLike('b.name', $keyword)
                ->groupEnd();
        }

        if (! empty($filters['category_id'])) {
            $builder->where('m.category_id', (int) $filters['category_id']);
        }

        if (! empty($filters['brand_id'])) {
            $builder->where('m.brand_id', (int) $filters['brand_id']);
        }

        if (! empty($filters['in_stock'])) {
            $builder->where('m.stock >', 0);
        }

        return $builder->countAllResults();
    }

    public function getFeatured(int $limit = 8): array
    {
        return $this->where('status', 1)
            ->where('stock >', 0)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function decrementStock(int $medicineId, int $quantity): bool
    {
        return $this->db->table($this->table)
            ->where('id', $medicineId)
            ->where('stock >=', $quantity)
            ->set('stock', 'stock - ' . (int) $quantity, false)
            ->update();
    }

    public function incrementStock(int $medicineId, int $quantity): bool
    {
        return $this->db->table($this->table)
            ->where('id', $medicineId)
            ->set('stock', 'stock + ' . (int) $quantity, false)
            ->update();
    }

    public function getLowStock(int $threshold = 10): array
    {
        return $this->where('status', 1)
            ->where('stock <=', $threshold)
            ->orderBy('stock', 'ASC')
            ->findAll();
    }
}
