@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Пост</h1>
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
                <div class="col-12">
                    <!-- /.row --> <div class="mr-4 mb-4">
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Назад</a>
                    </div>
                    <div class="card">

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Наименование</th>
                                    <th>Описание</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td class="text-wrap">{{ $post->title }}</td>
                                    <td class="text-wrap">{{ $post->content }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card-header d-flex p-3">
                <div class="mr-4">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-success">Редактировать</a>
                </div>
                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <input type="submit" class="btn btn-danger" value="Удалить">
                </form>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
