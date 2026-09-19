<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Tampilkan data users (dengan Yajra DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()->select(['id', 'name', 'email', 'role', 'created_at']);

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('role', function ($user) {
                    $badgeStyles = [
                        'super_admin'    => 'bg-danger',
                        'admin_ppdb'     => 'bg-primary',
                        'verifikator'    => 'bg-info text-dark',
                        'kepala_sekolah' => 'bg-success',
                        'bendahara'      => 'bg-warning text-dark',
                        'guru'           => 'bg-secondary',
                        'pendaftar'      => 'bg-dark',
                    ];
                    $style = $badgeStyles[$user->role] ?? 'bg-light text-dark';
                    $label = User::ROLES[$user->role] ?? ucfirst($user->role);

                    return '<span class="badge ' . $style . ' px-2 py-1"><i class="bi bi-shield-check me-1"></i>' . e($label) . '</span>';
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at ? $user->created_at->translatedFormat('d M Y H:i') : '-';
                })
                ->addColumn('action', function ($user) {
                    $editUrl = route('users.edit', $user->id);
                    $deleteUrl = route('users.destroy', $user->id);

                    $buttons = '<div class="d-inline-flex align-items-center justify-content-center gap-1 text-nowrap">';
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.78rem; border-radius: 6px;" title="Edit Data & Password"><i class="bi bi-pencil-square"></i><span>Edit</span></a>';

                    if (Auth::id() !== $user->id) {
                        $buttons .= '<button type="button" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1 px-2 py-1 btn-delete" data-id="' . $user->id . '" data-name="' . e($user->name) . '" data-url="' . $deleteUrl . '" style="font-size: 0.78rem; border-radius: 6px;" title="Hapus Pengguna"><i class="bi bi-trash3"></i><span>Hapus</span></button>';
                    } else {
                        $buttons .= '<span class="badge bg-light text-secondary border d-inline-flex align-items-center gap-1 px-2 py-1" style="font-size: 0.75rem; border-radius: 6px; min-height: 27px;" title="Akun Anda yang sedang aktif"><i class="bi bi-shield-check text-success"></i><span>Aktif</span></span>';
                    }

                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['role', 'action'])
                ->make(true);
        }

        return view('pages.users.index');
    }

    /**
     * Form tambah user baru
     */
    public function create()
    {
        $roles = User::ROLES;
        return view('pages.users.create', compact('roles'));
    }

    /**
     * Simpan user baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'role'     => ['required', 'string', Rule::in(array_keys(User::ROLES))],
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar. Gunakan email lain.',
            'role.required'      => 'Role pengguna wajib dipilih.',
            'role.in'            => 'Pilihan role tidak valid.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Form edit data user
     */
    public function edit(User $user)
    {
        $roles = User::ROLES;
        return view('pages.users.edit', compact('user', 'roles'));
    }

    /**
     * Perbarui data user dan password (jika diisi)
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role'     => ['required', 'string', Rule::in(array_keys(User::ROLES))],
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan oleh akun lain.',
            'role.required'      => 'Role pengguna wajib dipilih.',
            'role.in'            => 'Pilihan role tidak valid.',
            'password.min'       => 'Password baru minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $updateData = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // Jika password diisi, enkripsi dan ganti password lama dengan yang baru.
        // Jika password kosong, tetap gunakan password lama.
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        $message = $request->filled('password')
            ? 'Data pengguna dan password berhasil diperbarui!'
            : 'Data pengguna berhasil diperbarui (password tetap yang lama)!';

        return redirect()->route('users.index')->with('success', $message);
    }

    /**
     * Hapus data user
     */
    public function destroy(Request $request, User $user)
    {
        if (Auth::id() === $user->id) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!',
                ], 422);
            }
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!');
        }

        $userName = $user->name;
        $user->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengguna ' . $userName . ' berhasil dihapus!',
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Pengguna ' . $userName . ' berhasil dihapus!');
    }
}
