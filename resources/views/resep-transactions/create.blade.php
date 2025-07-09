<x-app-layout>
 

    <form action="{{ route('resep-transactions.store') }}" method="POST">
        @csrf
        <div class="bg-white p-4 rounded shadow-sm">
            <!-- Form fields dalam layout grid -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>No. Resep</label>
                    <input type="text" name="no_resep" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Nama Dokter</label>
                    <input type="text" name="doctor_name" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Nama Pasien</label>
                    <input type="text" name="patient_name" class="form-control" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Rumah Sakit</label>
                    <input type="text" name="hospital_name" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tanggal Transaksi</label>
                    <input type="date" name="transaction_date" class="form-control" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label>Catatan</label>
                <textarea name="notes" class="form-control" rows="3"></textarea>
            </div>

            <h5 class="mt-4">Daftar Obat</h5>
            <table class="table" id="obat-table">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th><button type="button" class="btn btn-sm btn-primary" id="add-row">+</button></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="products[0][name]" class="form-control" required></td>
                        <td><input type="number" name="products[0][quantity]" class="form-control" required></td>
                        <td><input type="number" name="products[0][price]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row">x</button></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success mt-3">Simpan Transaksi</button>
        </div>
    </form>

    <script>
        let index = 1;
        document.getElementById('add-row').addEventListener('click', function () {
            const table = document.querySelector('#obat-table tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="products[${index}][name]" class="form-control" required></td>
                <td><input type="number" name="products[${index}][quantity]" class="form-control" required></td>
                <td><input type="number" name="products[${index}][price]" class="form-control" required></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-row">x</button></td>
            `;
            table.appendChild(row);
            index++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
</x-app-layout>