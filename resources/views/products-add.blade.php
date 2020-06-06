@extends('layouts.app')

@section('content')
    <h1>Создать товар</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products-add') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Название</label>
            <input id="name" name="name" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <input id="description" name="description" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label for="image">Картинка</label>
            <input id="image" name="image" type="file" class="form-control">
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input id="price" name="price" type="text" class="form-control">
        </div>

        <div class="form-group">
            <label for="availability">В наличии</label>
            <input id="availability" name="availability" type="checkbox" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Создать</button>
    </form>
@endsection()
