@extends('user.layout')

@section('styles')
<style>
    .StripeElement {
        background-color: white;
        padding: 8px 12px;
        border-radius: 4px;
        border: 1px solid transparent;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">{{ __('Check Out') }}</h2>
                </div>

                

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-success text-bold">{{$plan->name}} / ${{ number_format($plan->price, 2)}}</h3>

                    <form action="{{route('paymentsuccess')}}" method="POST" id="subscribe-form">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="plan-name">Plan Name</label>
                                <input type="text" name="plan-name" id="plan-name" value="{{$plan->name}}" class="form-control" disabled readonly/>
                            </div>
                            <div class="col-md-4">
                                <label for="price">Amount</label>
                                <input type="number" name="price" id="price" value="{{$plan->price}}" class="form-control" disabled readonly/>
                            </div>
                        </div> 
                        <input type="hidden" name="plan" id="plan" value="{{ $plan->id}}">
                        <label for="card-holder-name">Card Holder Name</label>
                        <input id="card-holder-name" type="text" class="form-control">
                        @csrf
                        <div class="form-row">
                            <label for="card-element">Credit or debit card</label>
                            <div id="card-element" class="form-control">
                            </div>
                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>
                        <div class="stripe-errors"></div>

                        <div class="form-group text-center">
                            <button  type="submit" id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-lg btn-success btn-block">SUBMIT</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe("{{ $stripeKey }}"); 
    const elements = stripe.elements()
    const cardElement = elements.create('card')

    cardElement.mount('#card-element')

    const form = document.getElementById('subscribe-form')
    const cardBtn = document.getElementById('card-button')
    const cardHolderName = document.getElementById('card-holder-name')

    form.addEventListener('submit', async (e) => {
        e.preventDefault()

        cardBtn.disabled = true
        const {setupIntent, error } = await stripe.confirmCardSetup(
            cardBtn.dataset.secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            }
        )

        if(error) {
            cardBtn.disable = false
        }else {
            let token = document.createElement('input')
            token.setAttribute('type', 'hidden')
            token.setAttribute('name', 'token')
            token.setAttribute('value', setupIntent.payment_method)
            form.appendChild(token)
            form.submit();
        }
    })



</script>

@endsection
