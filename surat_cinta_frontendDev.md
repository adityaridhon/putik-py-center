# 📖 Frontend Developer Guide - Putik Psychology Center

> Dokumentasi lengkap tentang fitur yang sudah dibangun dan cara kerja integrasi frontend-backend

---

## 🎯 Ringkasan Proyek

Aplikasi **Putik Psychology Center** adalah platform manajemen layanan psikologi berbasis web menggunakan:
- **Backend**: Laravel 11 + Inertia.js
- **Frontend**: Vue 3 + TypeScript + Tailwind CSS
- **Database**: MySQL
- **Komponen UI**: shadcn-vue

---

## 🗂️ Struktur Fitur yang Sudah Dibangun

### 1. **Manajemen Profil Perusahaan** ✅
**Route:** `/profil-umum`

**File Backend:**
- Controller: `app/Http/Controllers/Admin/CompanyProfileController.php`
- Model: `app/Models/CompanyProfile.php`
- Migration: `database/migrations/*_create_company_profiles_table.php`

**File Frontend:**
- Page: `resources/js/pages/admin/ProfilUmum.vue`
- Component: `resources/js/components/admin/profil-umum/GeneralProfileCard.vue`

**Fitur:**
- ✅ Edit profil perusahaan (nama, headline, tentang, kontak)
- ✅ Upload logo perusahaan
- ✅ Upload gambar landing page
- ✅ Auto-refresh data setelah update
- ✅ Redirect ke halaman Manajemen Konten setelah simpan

**API Endpoints:**
```php
GET  /profil-umum                  // Tampilkan form edit
POST /profil-umum                  // Update profil (multipart/form-data)
```

---

### 2. **Manajemen Layanan (Services)** ✅
**Route:** `/services`

**File Backend:**
- Controller: `app/Http/Controllers/Admin/ServiceController.php`
- Model: `app/Models/Service.php`
- Migration: `database/migrations/*_create_services_table.php`

**File Frontend:**
- Component: `resources/js/components/admin/profil-umum/ServiceLists.vue`

**Fitur:**
- ✅ **Tambah Layanan** - Modal form untuk tambah layanan baru
- ✅ **Lihat Detail** - Modal view untuk melihat detail layanan
- ✅ **Edit Layanan** - Modal form untuk edit nama, deskripsi, gambar
- ✅ **Hapus Layanan** - Dengan konfirmasi sebelum hapus
- ✅ Upload gambar layanan
- ✅ Status aktif/non-aktif

**API Endpoints:**
```php
GET    /services              // List semua layanan (JSON)
POST   /services              // Tambah layanan baru (multipart/form-data)
GET    /services/{id}         // Detail layanan (JSON)
POST   /services/{id}         // Update layanan (multipart/form-data) *pakai POST karena file upload
DELETE /services/{id}         // Hapus layanan
```

**Struktur Database:**
```sql
services:
- id (bigint)
- name (string)
- description (text, nullable)
- image (string, nullable)
- is_active (boolean, default: true)
- created_at, updated_at
```

---

### 3. **Manajemen Klien (Clients)** ✅
**Route:** `/clients`

**File Backend:**
- Controller: `app/Http/Controllers/Admin/ClientController.php`
- Model: `app/Models/Client.php`
- Migration: `database/migrations/*_create_clients_table.php`

**File Frontend:**
- Component: `resources/js/components/admin/profil-umum/ClientLists.vue`

**Fitur:**
- ✅ **Tambah Klien** - Modal form untuk tambah klien baru
- ✅ **Lihat Detail** - Modal view untuk melihat detail klien
- ✅ **Edit Klien** - Modal form untuk edit nama, domisili, logo
- ✅ **Hapus Klien** - Dengan konfirmasi sebelum hapus
- ✅ Upload logo klien

**API Endpoints:**
```php
GET    /clients              // List semua klien (JSON)
POST   /clients              // Tambah klien baru (multipart/form-data)
GET    /clients/{id}         // Detail klien (JSON)
POST   /clients/{id}         // Update klien (multipart/form-data)
DELETE /clients/{id}         // Hapus klien
```

**Struktur Database:**
```sql
clients:
- id (bigint)
- name (string)
- location (string, nullable)
- logo (string, nullable)
- created_at, updated_at
```

---

### 4. **Dashboard Card Counter** ✅
**File Frontend:**
- Component: `resources/js/components/admin/profil-umum/ProfileCardHeader.vue`
- Page: `resources/js/pages/admin/Konten.vue`

**Fitur:**
- ✅ Menampilkan jumlah layanan dari database
- ✅ Menampilkan jumlah klien dari database
- ✅ Data real-time (auto update saat CRUD)

---

## 🔧 Cara Kerja Integrasi Frontend-Backend

### 1. **Upload File (Gambar/Logo)**

```vue
<!-- Frontend -->
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    image: null as File | null,
});

const submit = () => {
    form.post('/services', {
        forceFormData: true,  // ⚠️ PENTING untuk file upload
        preserveScroll: true,
    });
};
</script>

<template>
    <Input 
        type="file" 
        @change="form.image = ($event.target as HTMLInputElement).files?.[0] || null"
    />
</template>
```

```php
// Backend
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['name']);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('services', 'public');
    }

    Service::create($data);

    return redirect()->route('konten')->with('success', 'Berhasil ditambahkan.');
}
```

---

### 2. **Update dengan File Upload**

⚠️ **Catatan Penting:** Karena HTML form method hanya support GET dan POST, untuk update dengan file kita pakai **POST** dengan field `_method`.

```vue
<!-- Frontend -->
const submitEdit = () => {
    editForm.post(`/services/${selectedService.value.id}`, {
        forceFormData: true,
        preserveScroll: true,
    });
};
```

```php
// Backend - Controller menerima dengan method POST
public function update(Request $request, Service $service)
{
    $data = $request->only(['name', 'description']);

    if ($request->hasFile('image')) {
        // Hapus gambar lama
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        // Upload gambar baru
        $data['image'] = $request->file('image')->store('services', 'public');
    }

    $service->update($data);
    return redirect()->route('konten')->with('success', 'Berhasil diperbarui.');
}
```

---

### 3. **Delete Resource**

```vue
<!-- Frontend -->
const deleteService = (id: number) => {
    if (confirm('Apakah Anda yakin?')) {
        router.delete(`/services/${id}`, {
            preserveScroll: true,
        });
    }
};
```

```php
// Backend
public function destroy(Service $service)
{
    if ($service->image) {
        Storage::disk('public')->delete($service->image);
    }
    
    $service->delete();
    
    return redirect()->route('konten')->with('success', 'Berhasil dihapus.');
}
```

---

## 📁 File Storage

### Setup Storage Link
Pastikan storage symlink sudah dibuat:
```bash
php artisan storage:link
```

### Akses Gambar di Frontend
```vue
<!-- Accessor dari Model otomatis menambahkan path lengkap -->
<img :src="service.image_url || '/images/logo_putik.webp'" />
```

```php
// Model Service.php
protected $appends = ['image_url'];

public function getImageUrlAttribute()
{
    return $this->image ? asset('storage/' . $this->image) : null;
}
```

---

## 🎨 Komponen UI yang Digunakan

### Dialog/Modal
```vue
<Dialog v-model:open="showModal">
    <DialogContent>
        <DialogHeader>
            <DialogTitle>Judul Modal</DialogTitle>
            <DialogDescription>Deskripsi modal</DialogDescription>
        </DialogHeader>
        <!-- Konten -->
    </DialogContent>
</Dialog>
```

### Form dengan Inertia
```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    description: '',
});

const submit = () => {
    form.post('/endpoint', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>
```

### Table
```vue
<Table>
    <TableHeader>
        <TableRow>
            <TableHead>Nama Kolom</TableHead>
        </TableRow>
    </TableHeader>
    <TableBody>
        <TableRow v-for="item in items" :key="item.id">
            <TableCell>{{ item.name }}</TableCell>
        </TableRow>
    </TableBody>
</Table>
```

---

## 🔐 Route Protection

Semua route admin sudah dilindungi middleware `auth`:
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/konten', ...);
    Route::resource('services', ServiceController::class);
    Route::resource('clients', ClientController::class);
});
```

---

## 🗄️ Seeder Data

Untuk development, sudah ada seeder:
```bash
php artisan db:seed --class=ServiceSeeder
php artisan db:seed --class=ClientSeeder
php artisan db:seed --class=CompanyProfileSeeder
```

Atau reset semua dan seed ulang:
```bash
php artisan migrate:fresh --seed
```

---

## 🐛 Troubleshooting

### 1. **Error 404 saat submit form**
- Pastikan route sudah terdaftar: `php artisan route:list`
- Cek method HTTP yang digunakan (GET/POST/DELETE)

### 2. **Gambar tidak muncul**
- Pastikan storage link sudah dibuat: `php artisan storage:link`
- Cek folder `storage/app/public/` ada file-nya
- Akses langsung: `http://localhost:8000/storage/services/nama-file.jpg`

### 3. **Data tidak update di frontend**
- Cek apakah `preserveScroll: true` sudah ditambahkan
- Pastikan backend return redirect, bukan JSON
- Gunakan `form.reset()` setelah `onSuccess`

### 4. **Validation error tidak muncul**
- Akses error dengan `form.errors.fieldName`
- Tampilkan di template: `<span v-if="form.errors.name">{{ form.errors.name }}</span>`

---

## 📝 Best Practices

### 1. **Form Handling**
```vue
// ✅ Good - pakai useForm dari Inertia
const form = useForm({ name: '' });
form.post('/endpoint');

// ❌ Bad - jangan pakai axios manual
axios.post('/endpoint', data);
```

### 2. **File Upload**
```vue
// ✅ Good - forceFormData untuk file
form.post('/endpoint', { forceFormData: true });

// ❌ Bad - lupa forceFormData
form.post('/endpoint');
```

### 3. **Props Typing**
```vue
// ✅ Good - define props dengan TypeScript
defineProps<{
    services?: any[];
}>();

// ❌ Bad - tanpa type
defineProps(['services']);
```

---

## 🚀 Development Workflow

### Tambah Fitur CRUD Baru

1. **Backend:**
   ```bash
   php artisan make:model NamaModel -m
   php artisan make:controller Admin/NamaController --resource
   ```

2. **Migration:**
   ```php
   Schema::create('nama_table', function (Blueprint $table) {
       $table->id();
       $table->string('name');
       // ... kolom lain
       $table->timestamps();
   });
   ```

3. **Model:**
   ```php
   protected $fillable = ['name', 'field1', 'field2'];
   ```

4. **Controller:**
   - Copy dari `ServiceController.php` atau `ClientController.php`
   - Sesuaikan nama model dan validasi

5. **Route:**
   ```php
   Route::resource('nama', NamaController::class);
   ```

6. **Frontend Component:**
   - Copy dari `ServiceLists.vue` atau `ClientLists.vue`
   - Sesuaikan field dan endpoint

---

## 📞 Contact

Jika ada pertanyaan atau butuh bantuan:
- Developer: [Nama Developer]
- Email: [Email]
- Dokumentasi Laravel Inertia: https://inertiajs.com/

---

**Last Updated:** 24 Januari 2026
**Version:** 1.0.0
