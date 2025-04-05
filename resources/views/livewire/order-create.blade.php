<!-- resources/views/livewire/order-create.blade.php -->

<div class="row">
    <!-- Order Summary -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">ملخص الطلب</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderItems as $index => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>
                                <input type="number" class="form-control" min="1"
                                    wire:model.live="orderItems.{{ $index }}.quantity" max="{{ $item['stock'] }}"
                                    wire:change="updateQuantity({{ $index }}, $event.target.value)">
                            </td>
                            <td>
                                <button class="btn btn-danger" wire:click="removeProduct({{ $item['id'] }})">إزالة</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <button class="btn btn-success" wire:click="save">حفظ</button>
                <div class="mt-2">الإجمالي: {{ number_format($this->total, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Products List -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">إضافة طلب</div>
            <div class="card-body">
                <div class="form-group">
                    <label>التصنيفات</label>
                    <select class="form-control" wire:model.live="selectedCategory">
                        <option value="">اختر تصنيف</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th>السعر</th>
                            <th>المخزون</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->sale_price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <button class="btn btn-primary" wire:click="addProduct({{ $product->id }})">إضافة</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
