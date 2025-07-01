@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen bg-white">
            <!-- Main content -->
            <main class="flex-grow p-6 overflow-y-auto min-h-screen">
                <section id="profil" class="max-w-3xl mx-auto">
                    <h2 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-3">Profil Saya</h2>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tampilan data -->
                    <div id="profil-view" class="space-y-6 text-gray-700 text-lg">
                        <div>
                            <span class="font-semibold text-gray-900">Nama:</span> <span id="nama-text">{{ Auth::user()->name }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Email:</span> <span id="email-text">{{ Auth::user()->email }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Nomor HP:</span> <span id="phone">{{ Auth::user()->phone ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Kecamatan:</span> <span id="kecamatan">{{ Auth::user()->kecamatan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Kelurahan:</span> <span id="kelurahan">{{ Auth::user()->kelurahan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900">Alamat:</span> <span id="alamat">{{ Auth::user()->alamat ?? '-' }}</span>
                        </div>
                        <button id="edit-profil-btn" class="mt-6 bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 font-semibold transition">Edit Profil</button>
                    </div>
                    <br>
                    <div>
                        <a href="/logout" class="hover:underline text-red-700">Logout</a>
                    </div>

                    <!-- Form edit -->
                    <form id="profil-edit" method="POST" action="{{ route('profil.update') }}" class="hidden space-y-6 text-gray-800 mt-6 max-w-lg">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="input-nama" class="block font-semibold mb-2">Nama:</label>
                            <input type="text" id="input-nama" name="name" value="{{ Auth::user()->name }}" class="w-full border border-gray-300 rounded px-4 py-2" required />
                        </div>
                        <div>
                            <label for="input-email" class="block font-semibold mb-2">Email:</label>
                            <input type="email" id="input-email" name="email" value="{{ Auth::user()->email }}" class="w-full border border-gray-300 rounded px-4 py-2" required />
                        </div>
                        <div>
                            <label for="input-hp" class="block font-semibold mb-2">Nomor HP:</label>
                            <input type="text" id="input-hp" name="phone" value="{{ Auth::user()->phone }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                        </div>
                        <div>
                            <label for="input-hp" class="block font-semibold mb-2">Kecamatan:</label>
                            <input type="text" id="input-kecamatan" name="kecamatan" value="{{ Auth::user()->kecamatan }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                        </div>
                        <div>
                            <label for="input-hp" class="block font-semibold mb-2">Kelurahan</label>
                            <input type="text" id="input-kelurahan" name="kelurahan" value="{{ Auth::user()->kelurahan }}" class="w-full border border-gray-300 rounded px-4 py-2" />
                        </div>
                        <div>
                            <label for="input-alamat" class="block font-semibold mb-2">Alamat:</label>
                            <textarea id="input-alamat" name="alamat" class="w-full border border-gray-300 rounded px-4 py-2">{{ Auth::user()->alamat }}</textarea>                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 font-semibold transition">Simpan</button>
                            <button type="button" onclick="cancelEdit()" class="bg-gray-300 px-6 py-3 rounded hover:bg-gray-400 font-semibold transition">Batal</button>
                        </div>
                    </form>

                </section>
            </main>
        </div>
@endsection
