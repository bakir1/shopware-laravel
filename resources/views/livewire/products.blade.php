<div>
    <h2>Product List</h2>

    @if(!empty($products))
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Manufacturer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['stock'] }}</td>
                        <td>{{ $product['manufacturer'] ?? 'N/A' }}</td>
                        <td>
                            <!-- Button to open modal -->
                            <button wire:click="openModal({{ $product['id'] }})">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No products found.</p>
    @endif

    <!-- Modal Window -->
    @if ($showModal)
        <div class="modal">
            <h3>Edit Product</h3>

            <div>
                <label for="price">Price:</label>
                <input type="number" wire:model="editingProduct.price">
            </div>

            <div>
                <label for="stock">Stock:</label>
                <input type="number" wire:model="editingProduct.stock">
            </div>

            <div>
                <label for="manufacturer">Manufacturer:</label>
                <select wire:model="selectedManufacturer">
                    <option value="">Select Manufacturer</option>
                    @foreach($manufacturers as $manufacturer)
                        <option value="{{ $manufacturer->id }}">{{ $manufacturer->manufacturer_title }}</option>
                    @endforeach
                </select>
            </div>

            <button wire:click="saveChanges">Save Changes</button>
            <button wire:click="closeModal">Cancel</button>
        </div>
    @endif
</div>
