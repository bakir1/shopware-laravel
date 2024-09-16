<div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Manufacturer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td> {{ $product['name'] }} </td>
                    <td> {{ $product['price'] }} </td>
                    <td> {{ $product['stock'] }} </td>
                    <td>{{ $product['manufacturer'] ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>