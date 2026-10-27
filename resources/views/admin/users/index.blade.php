<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error') || $errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    {{ session('error') ?? $errors->first() }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead>
                            <tr class="border-b font-semibold">
                                <th class="py-2 pr-4">#</th>
                                <th class="py-2 pr-4">Nama</th>
                                <th class="py-2 pr-4">Email</th>
                                <th class="py-2 pr-4">Role</th>
                                <th class="py-2 pr-4">Terdaftar</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $loop->iteration }}</td>
                                    <td class="py-2 pr-4">{{ $user->name }}</td>
                                    <td class="py-2 pr-4">{{ $user->email }}</td>
                                    <td class="py-2 pr-4">{{ $user->role }}</td>
                                    <td class="py-2 pr-4">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="py-2">
                                        @if ($user->id === auth()->id())
                                            <span class="text-gray-400">(akun Anda)</span>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <form method="POST" action="{{ route('admin.users.role', $user) }}"
                                                    class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role" class="border-gray-300 rounded-md text-sm">
                                                        <option value="user" @selected($user->role === 'user')>user
                                                        </option>
                                                        <option value="admin" @selected($user->role === 'admin')>admin
                                                        </option>
                                                    </select>
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-blue-600 text-white rounded-md">Simpan</button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                    onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-red-600 text-white rounded-md">Hapus</button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
