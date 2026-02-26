@extends('user.layout')


@section('styles')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark">
                    <h2 class="text-center brand-text">{{ __('Dyebold Packages') }}</h2>
                    <div class="marquee-container">
                      <h3 class="marquee-text">Buy a Package To Unlock BRY Color Page for You</h3>
                    </div>
                </div>

  <div class="container">


    <div class="row justify-content-center">
    @foreach($plans as $plan)
        <div class="col-md-4">
            <div class="card plan-card py-2" id="plan-item">
                <div class="bg-dark text-center p-3">
                    <h4 class="text-white">{{$plan->name}}</h4>
                    <p class="plan-price brand-text">${{$plan->price}}</p>
                </div>
                <div class="plan-body text-center">
                    
                    <ul class="plan-features">
                        <li><i class="fas fa-check-circle text-success"></i> {{$plan->name}}</li>
                        <li><i class="fas fa-check-circle text-success"></i> 24/7 Support</li>
                        <li><i class="fas fa-check-circle text-success"></i> Renewable</li>
                        <li><i class="fas fa-check-circle text-success"></i> Advanced Security</li>
                    </ul>
                    <a href="{{route('package.show',$plan->slug)}}" class="btn btn-primary w-100 mt-3">Get Started</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
  </div>
</section>


            </div>
        </div>
    </div>
</div>
@endsection

