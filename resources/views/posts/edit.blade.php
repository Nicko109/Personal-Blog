@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать пост</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Главная</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <form action="{{route('admin.posts.update', $post->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group w-50">
                        <label for="title">Редактировать название</label>
                        <input type="text" class="form-control" placeholder="Название поста" name="title" id="title"
                               value="{{ $post->title }}"
                        >
                        @error('title')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Редактировать изображение</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" value="{{$post->image}}">
                                <label class="custom-file-label">{{$post->image}}</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Загрузка</span>
                            </div>
                        </div>
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div>
                            <label for="content">Редактировать описание</label>
                        </div>
                        <textarea id="content" name="content" rows="8" cols="80">{{ $post->content }}</textarea>
                        @error('content')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-success" value="Редактировать">
                    </div>
                    <div class="mr-4">
                        <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-primary">Назад</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
