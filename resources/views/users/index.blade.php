@extends('layouts.head-isi')

@section('content')
<div>
    <div class="container-fluid mx-4 mt-10 text-black">
        <div class="mx-4 mt-7" style="width:600px;height:330px;">
            <div class="card shadow" style="background: rgba(255, 255, 255, 0.5); border: none;">
                <div class="card-body text-start">
                    <h1>List Users</h1>
                    <a href="{{ route('users.create') }}">Tambah User</a>
                    <table border="0" cellpadding="6" >
                        <tr><th>ID</th><th>Name</th><th>Email</th><th>Number</th><th>Aksi</th></tr>
                        @foreach($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->phone_number }}</td>
                            <td>
                                <a href="{{ route('users.edit', $u) }}">Edit</a>
                                <form action="{{ route('users.destroy', $u) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button>Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button>Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
