@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tạo Quyền Mới</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Quyền</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Quay Lại</a>
    </form>
</div>
@endsection
