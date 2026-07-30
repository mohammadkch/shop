<?php

namespace App\Controllers\Admin;

class ProductPrice extends BaseController
{
    public function manage($productId)
    {
        $data = $this->getPricingData((int) $productId);

        if ($data === null) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        $this->viewData = array_merge($this->viewData, $data);
        $this->viewData['title'] = 'مدیریت قیمت‌ها - ' . $data['product']['name'];
        $this->viewData['form_action'] = 'admin/product-price/save/' . $productId;

        return view('admin/product_price/manage', $this->viewData);
    }

    public function save($productId)
    {
        $productId = (int) $productId;
        $data = $this->getPricingData($productId);

        if ($data === null) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        $postedRows = $this->request->getPost('prices') ?? [];
        if (!is_array($postedRows)) {
            $postedRows = [];
        }

        $allowedCombinations = [];
        foreach ($data['combinations'] as $combination) {
            $allowedCombinations[$combination['key']] = $combination;
        }

        $rowsToSave = [];
        $errors = [];

        foreach ($postedRows as $index => $row) {
            if (!is_array($row)) {
                continue;
            }

            $key = (string) ($row['key'] ?? '');
            if (!isset($allowedCombinations[$key])) {
                $errors[] = 'یکی از ترکیب‌های ارسال‌شده دیگر برای این محصول معتبر نیست.';
                continue;
            }

            $price = trim((string) ($row['price'] ?? ''));
            $salePrice = trim((string) ($row['sale_price'] ?? ''));
            $stock = trim((string) ($row['stock'] ?? '0'));
            $sku = trim((string) ($row['sku'] ?? ''));
            $hasExistingPrice = !empty($allowedCombinations[$key]['price']);

            if ($price === '' && !$hasExistingPrice) {
                continue;
            }

            if ($price === '' || !is_numeric($price) || (float) $price <= 0) {
                $errors[] = 'قیمت اصلی در ردیف ' . ((int) $index + 1) . ' معتبر نیست.';
                continue;
            }

            if ($salePrice !== '' && (!is_numeric($salePrice) || (float) $salePrice < 0)) {
                $errors[] = 'قیمت فروش در ردیف ' . ((int) $index + 1) . ' معتبر نیست.';
                continue;
            }

            if ($salePrice !== '' && (float) $salePrice > (float) $price) {
                $errors[] = 'قیمت فروش در ردیف ' . ((int) $index + 1) . ' نباید بیشتر از قیمت اصلی باشد.';
                continue;
            }

            if ($stock === '' || filter_var($stock, FILTER_VALIDATE_INT) === false || (int) $stock < 0) {
                $errors[] = 'موجودی در ردیف ' . ((int) $index + 1) . ' معتبر نیست.';
                continue;
            }

            if (mb_strlen($sku) > 100) {
                $errors[] = 'SKU در ردیف ' . ((int) $index + 1) . ' بیشتر از ۱۰۰ کاراکتر است.';
                continue;
            }

            $combination = $allowedCombinations[$key];
            $rowsToSave[$key] = [
                'product_id' => $productId,
                'color_option_id' => $combination['color']['id'] ?? null,
                'size_option_id' => $combination['size']['id'] ?? null,
                'price' => (float) $price,
                'sale_price' => $salePrice === '' ? null : (float) $salePrice,
                'stock' => (int) $stock,
                'sku' => $sku === '' ? null : $sku,
            ];
        }

        if (!empty($errors)) {
            $this->flash('validation_error', implode(' | ', array_unique($errors)));
            return redirect()->to('admin/product-price/manage/' . $productId);
        }

        if (empty($rowsToSave)) {
            $this->flash('validation_error', 'حداقل قیمت یک ترکیب را وارد کنید.');
            return redirect()->to('admin/product-price/manage/' . $productId);
        }

        $defaultKey = (string) $this->request->getPost('default_key');
        if (!isset($rowsToSave[$defaultKey])) {
            $defaultKey = array_key_first($rowsToSave);
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $db->table('product_price')
            ->where('product_id', $productId)
            ->set(['is_default' => 0])
            ->update();

        foreach ($rowsToSave as $key => $row) {
            $existing = $this->findPrice(
                $productId,
                $row['color_option_id'],
                $row['size_option_id']
            );

            $row['is_default'] = $key === $defaultKey ? 1 : 0;
            $row['updated_at'] = time();

            if ($existing) {
                $db->table('product_price')
                    ->where('id', $existing['id'])
                    ->update($row);
            } else {
                $row['created_at'] = time();
                $db->table('product_price')->insert($row);
            }
        }

        $db->transComplete();

        if (!$db->transStatus()) {
            $this->flash('validation_error', 'خطا در ذخیره قیمت‌های محصول.');
            return redirect()->to('admin/product-price/manage/' . $productId);
        }

        $this->flash('price_update_success', 'قیمت‌های محصول با موفقیت ذخیره شدند.');
        return redirect()->to('admin/product-price/manage/' . $productId);
    }

    public function cleanup($productId)
    {
        $productId = (int) $productId;
        $data = $this->getPricingData($productId);

        if ($data === null) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        $staleIds = array_column($data['stalePrices'], 'id');
        if (!empty($staleIds)) {
            \Config\Database::connect()
                ->table('product_price')
                ->where('product_id', $productId)
                ->whereIn('id', $staleIds)
                ->delete();
        }

        $this->ensureDefaultPrice($productId);
        $this->flash('price_cleanup_success', count($staleIds) . ' قیمت نامعتبر پاک‌سازی شد.');
        return redirect()->to('admin/product-price/manage/' . $productId);
    }

    public function delete($productId, $priceId)
    {
        $productId = (int) $productId;
        $priceId = (int) $priceId;
        $data = $this->getPricingData($productId);

        if ($data === null) {
            $this->flash('product_not_found', 'محصول مورد نظر یافت نشد');
            return redirect()->to('admin/product');
        }

        $staleIds = array_map('intval', array_column($data['stalePrices'], 'id'));
        if (!in_array($priceId, $staleIds, true)) {
            $this->flash('validation_error', 'فقط قیمت‌های نامعتبر از این بخش قابل حذف هستند.');
            return redirect()->to('admin/product-price/manage/' . $productId);
        }

        \Config\Database::connect()
            ->table('product_price')
            ->where('id', $priceId)
            ->where('product_id', $productId)
            ->delete();

        $this->ensureDefaultPrice($productId);
        $this->flash('price_delete_success', 'قیمت نامعتبر حذف شد.');
        return redirect()->to('admin/product-price/manage/' . $productId);
    }

    private function getPricingData(int $productId): ?array
    {
        $product = model('App\Models\ProductModel')->find($productId);
        if (!$product) {
            return null;
        }

        $db = \Config\Database::connect();
        $assignedOptions = $db->table('product_option po')
            ->select('o.id, o.value, o.color_code, o.sort_order, o.is_active, l.type')
            ->join('option o', 'o.id = po.option_id')
            ->join('label l', 'l.id = o.label_id')
            ->where('po.product_id', $productId)
            ->whereIn('l.type', ['color', 'size'])
            ->orderBy('l.sort_order', 'ASC')
            ->orderBy('o.sort_order', 'ASC')
            ->orderBy('o.id', 'ASC')
            ->get()
            ->getResultArray();

        $colors = [];
        $sizes = [];
        foreach ($assignedOptions as $option) {
            if ($option['type'] === 'color') {
                $colors[] = $option;
            } elseif ($option['type'] === 'size') {
                $sizes[] = $option;
            }
        }

        $prices = $db->table('product_price pp')
            ->select('pp.*, color.value as color_name, color.color_code, size.value as size_name')
            ->join('option color', 'color.id = pp.color_option_id', 'left')
            ->join('option size', 'size.id = pp.size_option_id', 'left')
            ->where('pp.product_id', $productId)
            ->orderBy('pp.id', 'ASC')
            ->get()
            ->getResultArray();

        $priceByKey = [];
        foreach ($prices as $price) {
            $key = $this->combinationKey(
                $price['color_option_id'],
                $price['size_option_id']
            );

            if (
                !isset($priceByKey[$key])
                || ((int) $price['is_default'] === 1 && (int) $priceByKey[$key]['is_default'] !== 1)
            ) {
                $priceByKey[$key] = $price;
            }
        }

        $combinations = [];
        if (!empty($colors) && !empty($sizes)) {
            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    $combinations[] = $this->makeCombination($color, $size, $priceByKey);
                }
            }
        } elseif (!empty($colors)) {
            foreach ($colors as $color) {
                $combinations[] = $this->makeCombination($color, null, $priceByKey);
            }
        } elseif (!empty($sizes)) {
            foreach ($sizes as $size) {
                $combinations[] = $this->makeCombination(null, $size, $priceByKey);
            }
        } else {
            $combinations[] = $this->makeCombination(null, null, $priceByKey);
        }

        $validKeys = array_column($combinations, 'key');
        $stalePrices = [];
        $defaultKey = null;
        foreach ($prices as $price) {
            $key = $this->combinationKey($price['color_option_id'], $price['size_option_id']);
            $isDuplicate = isset($priceByKey[$key])
                && (int) $priceByKey[$key]['id'] !== (int) $price['id'];

            if (!in_array($key, $validKeys, true) || $isDuplicate) {
                $stalePrices[] = $price;
            } elseif ((int) $price['is_default'] === 1) {
                $defaultKey = $key;
            }
        }

        $defaultKey ??= $combinations[0]['key'];

        return [
            'product' => $product,
            'productId' => $productId,
            'colors' => $colors,
            'sizes' => $sizes,
            'combinations' => $combinations,
            'stalePrices' => $stalePrices,
            'defaultKey' => $defaultKey,
        ];
    }

    private function makeCombination(?array $color, ?array $size, array $priceByKey): array
    {
        $key = $this->combinationKey($color['id'] ?? null, $size['id'] ?? null);

        return [
            'key' => $key,
            'color' => $color,
            'size' => $size,
            'price' => $priceByKey[$key] ?? null,
        ];
    }

    private function combinationKey($colorOptionId, $sizeOptionId): string
    {
        return ((int) $colorOptionId ?: 0) . ':' . ((int) $sizeOptionId ?: 0);
    }

    private function findPrice(int $productId, ?int $colorOptionId, ?int $sizeOptionId): ?array
    {
        $builder = \Config\Database::connect()
            ->table('product_price')
            ->where('product_id', $productId);

        $colorOptionId === null
            ? $builder->where('color_option_id', null)
            : $builder->where('color_option_id', $colorOptionId);
        $sizeOptionId === null
            ? $builder->where('size_option_id', null)
            : $builder->where('size_option_id', $sizeOptionId);

        return $builder->get()->getRowArray();
    }

    private function ensureDefaultPrice(int $productId): void
    {
        $db = \Config\Database::connect();
        $prices = $db->table('product_price')
            ->where('product_id', $productId)
            ->orderBy('is_default', 'DESC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        if (empty($prices)) {
            return;
        }

        $defaultId = (int) $prices[0]['id'];
        $db->table('product_price')
            ->where('product_id', $productId)
            ->set(['is_default' => 0, 'updated_at' => time()])
            ->update();
        $db->table('product_price')
            ->where('id', $defaultId)
            ->update(['is_default' => 1, 'updated_at' => time()]);
    }
}
