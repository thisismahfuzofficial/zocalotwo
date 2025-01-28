<footer id="footer" class="footer dark-background">
    <div class="container">
        <div class="row gy-3">
            <div class="col-lg-3 col-md-6 d-flex ">
                <i class="bi bi-geo-alt icon"></i>
                <div class="address">
                    <h4>Address</h4>
                    <p>{{ Settings::setting('site.address') ? Settings::setting('site.address') : 'site address' }}</p>

                    <p></p>
                </div>

            </div>

            <div class="col-lg-3 col-md-6 d-flex">
                <i class="bi bi-telephone icon"></i>
                <div>
                    <h4>Contact</h4>
                    <p>
                        <strong>Phone:</strong>
                        <span>{{ Settings::setting('site.phone') ? Settings::setting('site.phone') : 'site phone' }}</span><br>
                        <strong>Email:</strong>
                        <span>{{ Settings::setting('site.email') ? Settings::setting('site.email') : 'site email' }}</span><br>
                    </p>
                </div>
            </div>

            {{-- <div class="col-lg-3 col-md-6 d-flex">
                <i class="bi bi-clock icon"></i>
                <div>
                    <h4>Opening Hours</h4>
                    <p>
                        <strong>Mon-Sat:</strong> <span>11AM - 23PM</span><br>
                        <strong>Sunday</strong>: <span>Closed</span>
                    </p>
                </div>
            </div> --}}

            <div class="col-lg-3">
                
            </div>
            <div class="col-lg-3 col-md-6 ">
                <h4>Follow Us</h4>
                <div class="social-links d-flex">
                    <a href="https://twitter.com/chefonwheels11" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="https://www.facebook.com/TacoZocalo" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com/tacozocalo/" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.tripadvisor.com/Restaurant_Review-g58120-d13820298-Reviews-Taco_Zocalo-Reston_Fairfax_County_Virginia.html" class="linkedin"><i class="bi bi-arrows-move"></i></a>
                    <a href="https://www.yelp.com/biz/taco-zocalo-ashburn" class="linkedin"><i class="bi bi-arrows-move"></i></a>
                </div>
            </div>

        </div>
    </div>

   

</footer>
