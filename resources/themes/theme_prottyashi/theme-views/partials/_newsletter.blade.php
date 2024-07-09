<div class="my-5" style="margin:auto; width: 50%">
    <div class="d-flex mt-4 mb-3 gap-5">
{{--        <img src="https://images.pexels.com/photos/4065624/pexels-photo-4065624.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="" width="30%" style="filter: grayscale(100%)">--}}
        <img src="https://images.pexels.com/photos/6951358/pexels-photo-6951358.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="newsletter-image" width="30%" style="filter: grayscale(100%)">
        <div class="w-50 text-center">
            <div class="d-flex justify-content-center gap-2">
                <h6 class="text-uppercase mb-5" style="font-size: xx-large; font-weight: lighter">{{translate('stay_tuned')}}</h6>
{{--                <i class="bi bi-send-fill mt-n1 font-weight-normal"></i>--}}
            </div>
{{--            <p>{{translate('subscribe_to_our_newsletter_to_get_latest_updates')}}</p>--}}
            <p>{{translate('join_Prottyashi_family!_The_best_way_to_keep_in_touch_and_to_be_informed_of_our_great_deals.')}}</p>
            <div>
                <form action="{{ route('subscription') }}" method="post">
                    @csrf
                    <div class="position-relative">
                        <div class="position-relative mb-5 d-block border border-primary" style="border-radius: 3px">
{{--                            <i style="color: var(--bs-primary) " class="bi bi-envelope envelop-icon fs-18"></i>--}}
                            <input style="border: 1px solid var(--bs-primary)" type="text" placeholder="{{ translate('enter_your_email') }}"
                                   class="form-control border-0" name="subscription_email" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary w-100 text-uppercase py-3" style="border-radius: 3px">{{ translate('subscribe_me_to_newsletter') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
