@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        @if(session()->has('message'))
        <div class="alert alert-success" id="success-alert">
            {{ session()->get('message') }}
        </div>
        @endif

        <div class="col-md-12">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    <h3>Search user</h3>
                    <!--
                    <a href="{{route('admCreateReg')}}" class="btn btn-primary">Create User</a>
                    -->
                    <form class="form-inline" action="{{route('searchUser')}}" method="GET">
                        @csrf
                        <div class="mb-2">
                            <label for="search" class="sr-only">search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search user">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{route('alluser')}}" class="btn btn-danger">Reset</a>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Created</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit/Del</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($liza as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    @if($item->stripe_id > 0)
                                    <p class="text-success">Active</p>
                                    @else
                                    <p class="text-danger">Not Active</p>
                                    @endif
                                </td>
                                <td class="d-flex">

                                    <form action="{{route('userDelete', $item->id)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                aria-hidden="true"></i></button>

                                        <a href="{{route('editUser', $item->id)}}" class="btn btn-success btn-sm">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                    </form>


                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>


                    <!-- Pagination -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            @if($liza->currentPage() > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $liza->previousPageUrl() }}">Previous</a>
                            </li>
                            @endif
                            <div class="paginationWrapper">
                                {{ $liza->links() }}
                            </div>
                            @if($liza->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $liza->nextPageUrl() }}">Next</a>
                            </li>
                            @endif
                        </ul>
                    </nav>



                </div>
            </div>
        </div>
    </div>
</div>

@endsection