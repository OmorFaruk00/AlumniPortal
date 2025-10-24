
<div class="">

    <div class="">
        <div class="">
            <div class="profile-signature">
                <div class="signature-icon">
                    <img src="{{ asset(Auth::user()->image) }}" alt="">
                </div>
                <div class="signature-details">
                    <h2 class="title"><span>{{ Auth::user()->name }}</span></h2>
                    <span class="post">{{ Auth::user()->designation}}</span>
                    <ul class="social-links">
                        <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href=""><i class="fab fa-twitter"></i></a></li>
                        <li><a href=""><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
                <ul class="signature-content">
                    <li><i class="fa fa-phone"></i> {{ Auth::user()->phone }}</li>
                    <li><i class="fa fa-envelope"></i> {{ Auth::user()->email }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
