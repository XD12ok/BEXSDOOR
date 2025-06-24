@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen  bg-white">
        <!-- Sidebar -->
        <nav id="sidebar" class="top-0 left-0 bottom-0 w-44 bg-black py-4 transform -translate-x-full md:translate-x-0 md:static md:flex md:flex-col transition-transform duration-300 ease-in-out z-40">
            <a href="{{route('userDashboard')}}" class="text-white font-semibold px-5 py-3 text-left border-l-4 hover:bg-blue-500 bg-blue-800 border-yellow-400 w-full">Profil Saya</a>
            <a href="{{route('orders.history')}}" class="text-white font-semibold px-5 py-3 text-left hover:bg-blue-500 w-full">Pesanan Saya</a>
        </nav>

        <!-- Overlay sidebar (untuk mobile) -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

        <div class="flex flex-col flex-grow">
            <!-- Hamburger button mobile -->
            <header class="bg-white p-4 shadow-md md:hidden flex items-center">
                <button id="hamburger-btn" aria-label="Toggle sidebar" class="text-gray-700 focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="ml-4 text-xl font-semibold text-gray-900">Profil Saya</h1>
            </header>

            <!-- Main content -->
            <main class="flex-grow p-6 md:ml-44 overflow-y-auto min-h-screen">
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
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const overlay = document.getElementById('overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
            overlay.classList.toggle('block');
        }

        hamburgerBtn?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Edit Profil toggle
        const editBtn = document.getElementById('edit-profil-btn');
        const profilView = document.getElementById('profil-view');
        const profilEdit = document.getElementById('profil-edit');

        editBtn?.addEventListener('click', () => {
            profilView.classList.add('hidden');
            profilEdit.classList.remove('hidden');
        });

        function cancelEdit() {
            profilEdit.classList.add('hidden');
            profilView.classList.remove('hidden');
        }
    </script>
@endsection
