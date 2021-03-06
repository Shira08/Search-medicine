@extends('layouts.base',['title'=> 'Ajout Hopital'])
    
    @section('content')
        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('layouts.partials._nav')
            
            <div class="row g-4">
                <div class="col-12 text-center">
                    <h2 class="text-primary">Section Hopitaux</h2>
                </div>
                <div class="col-lg-10 mx-auto grid-margin stretch-card">
                    <div class="bg-white shadow rounded h-100 p-4">
                        <h4 class="mb-4 text-secondary">Ajouter un hopital</h4>
    
                        <form action="{{route('save.hospital')}}" method="post">
                            @if(Session::has('success'))
                            <div class="alert alert-success">{{Session::get('success')}}</div>
                            @endif
                            @if(Session::has('fail'))
                            <div class="alert alert-danger">{{Session::get('fail')}}</div>
                            @endif
                            @csrf
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="John Doe"
                                            name="name" maxlength="">
                                        <label for="floatingInput">Name</label>
                                        <span class="text-danger">@error('name')
                                            {{$message}}
                                            @enderror</span>
    
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="tel" class="form-control" name="contact" id="floatingPassword"
                                            pattern="\w+[229]\w+[0-9]{2}+[0-9]{2}+[0-9]{2}+[0-9]{2}" placeholder="">
                                        <label for="floatingPassword">Contact: +229xxxxxxxx</label>
                                        <span class="text-danger">@error('contact')
                                            {{$message}}
                                            @enderror</span>
    
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="example@gmail.com"
                                    name="email">
                                <label for="floatingInput">Email</label>
                                <span class="text-danger">@error('email')
                                    {{$message}}
                                    @enderror</span>
    
                            </div>
                            <div class="row">
    
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Indication"
                                            name="indication" maxlength="">
                                        <label for="floatingInput">Indication</label>
    
                                        <span class="text-danger">@error('indication')
                                            {{$message}}
                                            @enderror</span>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating mb-3">
                                        <input type="url" class="form-control" id="floatingInput" placeholder="Itin??raire"
                                            name="itineraire">
                                            <label for="floatingInput">Itin??raire</label>
                                        <span class="text-danger">@error('itineraire')
                                            {{$message}}
                                            @enderror</span>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-floating mb-3">
    
                                <input type="password" class="form-control" id="floatingInput" placeholder="Password"
                                    name="password">
                                <label for="floatingInput">Password</label>
    
                                <span class="text-danger">@error('password')
                                    {{$message}}
                                    @enderror</span>
                            </div>
    
                            <button type="submit" name="add-pharmacy" class="btn btn-primary col-12">Ajouter un
                                Hopital</button>
    
                        </form>
                    </div>
                </div>
            </div>
       
            @include('layouts.partials._footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>  
    @endsection  