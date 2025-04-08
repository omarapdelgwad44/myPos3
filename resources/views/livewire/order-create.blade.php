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
                                    wire:model="orderItems.{{ $index }}.quantity" 
                                    wire:change="updateCounter"
                                    max="{{ $item['stock'] }}">     
                           </td>
                            <td>
                                <button class="btn btn-danger" wire:click="removeProduct({{ $item['id'] }})">إزالة</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
@if($orderItems)
                    <tr>
                    <button class="btn btn-success" wire:click="save">حفظ</button>
                    <div class="mt-2">الإجمالي: {{ number_format($this->total, 2) }}</div>                    
                </tr>
@endif
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
                @if($this->total > 0)
                    <div class="mt-3">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="hasTax" wire:model.live="hasTax">
                                <label class="custom-control-label" for="hasTax">تفعيل الضريبة</label>
                            </div>
                        </div>

                        @if($hasTax)
                            <div class="form-group">
                                <label>الضريبة (%)</label>
                                <input type="number" class="form-control" wire:model.live="taxRate" min="0">
                            </div>
                            <div class="mt-2">
                                <strong>الضريبة:</strong> {{ number_format($this->totalTax, 2) }}
                            </div>
                            <div class="mt-2">
                                <strong>الإجمالي مع الضريبة:</strong> {{ number_format($this->total + $this->totalTax, 2) }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
