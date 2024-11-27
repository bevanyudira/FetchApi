<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
</head>
<body class="bg-gray-100 p-5">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-5">Manajemen Data Buku</h1>

        <!-- Form Tambah/Update Buku -->
        <div class="mb-5 bg-white p-5 shadow-md rounded">
            <h2 class="text-2xl font-bold mb-4" id="form-title">Tambah Buku</h2>
            <form id="book-form">
                <input type="hidden" id="book-id">
                <div class="mb-3">
                    <label class="block text-gray-700">Judul Buku</label>
                    <input type="text" id="judul" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Penulis</label>
                    <input type="text" id="penulis" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Harga</label>
                    <input type="number" id="harga" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Tanggal Terbit</label>
                    <input type="date" id="tgl_terbit" class="w-full border px-3 py-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Foto Buku</label>
                    <input type="file" id="photo" class="w-full border px-3 py-2 rounded">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" id="reset-form">Reset</button>
            </form>
        </div>

        <!-- Tabel Data Buku -->
        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Judul</th>
                    <th class="px-4 py-2">Penulis</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Tanggal Terbit</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="books-table">
                <!-- Data akan diisi melalui JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
        const apiUrl = '/api/books';

        // Fetch All Books
        async function fetchBooks() {
            const response = await axios.get(apiUrl);
            const books = response.data.data.data;

            const table = document.getElementById('books-table');
            table.innerHTML = books.map((book, index) => `
                <tr>
                    <td class="border px-4 py-2">${index + 1}</td>
                    <td class="border px-4 py-2">${book.judul}</td>
                    <td class="border px-4 py-2">${book.penulis}</td>
                    <td class="border px-4 py-2">Rp ${book.harga.toLocaleString()}</td>
                    <td class="border px-4 py-2">${book.tgl_terbit}</td>
                    <td class="border px-4 py-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="editBook(${book.id})">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteBook(${book.id})">Hapus</button>
                    </td>
                </tr>
            `).join('');
        }

        // Add or Update Book
        document.getElementById('book-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const id = document.getElementById('book-id').value;
            const formData = new FormData();
            formData.append('judul', document.getElementById('judul').value);
            formData.append('penulis', document.getElementById('penulis').value);
            formData.append('harga', document.getElementById('harga').value);
            formData.append('tgl_terbit', document.getElementById('tgl_terbit').value);
            if (document.getElementById('photo').files[0]) {
                formData.append('photo', document.getElementById('photo').files[0]);
            }

            try {
                if (id) {
                    // Update
                    await axios.post(`${apiUrl}/${id}?_method=PUT`, formData);
                    alert('Buku berhasil diperbarui!');
                } else {
                    // Create
                    await axios.post(apiUrl, formData);
                    alert('Buku berhasil ditambahkan!');
                }
                document.getElementById('reset-form').click();
                fetchBooks();
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });

        // Edit Book
        async function editBook(id) {
            const response = await axios.get(`${apiUrl}/${id}`);
            const book = response.data.data;

            document.getElementById('book-id').value = book.id;
            document.getElementById('judul').value = book.judul;
            document.getElementById('penulis').value = book.penulis;
            document.getElementById('harga').value = book.harga;
            document.getElementById('tgl_terbit').value = book.tgl_terbit;

            document.getElementById('form-title').textContent = 'Edit Buku';
        }

        // Delete Book
        async function deleteBook(id) {
            if (confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
                try {
                    await axios.delete(`${apiUrl}/${id}`);
                    alert('Buku berhasil dihapus!');
                    fetchBooks();
                } catch (error) {
                    console.error(error);
                    alert('Terjadi kesalahan saat menghapus data.');
                }
            }
        }

        // Reset Form
        document.getElementById('reset-form').addEventListener('click', function () {
            document.getElementById('book-id').value = '';
            document.getElementById('judul').value = '';
            document.getElementById('penulis').value = '';
            document.getElementById('harga').value = '';
            document.getElementById('tgl_terbit').value = '';
            document.getElementById('photo').value = '';
            document.getElementById('form-title').textContent = 'Tambah Buku';
        });

        // Initial Fetch
        fetchBooks();
    </script>
</body>
</html>
